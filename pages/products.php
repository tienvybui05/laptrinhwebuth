<?php
session_start();
echo 'User ID: ' . ($_SESSION['idUser'] ?? 'Chưa có');

?>
<?php

include '../admin/entities/product.php';
$product = new product();

// Lấy dữ liệu phân trang từ class product
$productsPerPage = 16;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($currentPage < 1) {
    $currentPage = 1;
}

// Lấy tham số lọc từ URL
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$priceMin = isset($_GET['price_min']) ? (int)$_GET['price_min'] : 0;
$priceMax = isset($_GET['price_max']) ? (int)$_GET['price_max'] : 0; // Đặt giá trị mặc định là 0
$doCung = isset($_GET['do_cung']) ? $_GET['do_cung'] : '';
$diemCanBang = isset($_GET['diem_can_bang']) ? $_GET['diem_can_bang'] : '';
$trongLuong = isset($_GET['trong_luong']) ? $_GET['trong_luong'] : '';
$loiChoi = isset($_GET['loi_choi']) ? $_GET['loi_choi'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Lấy khoảng giá từ cơ sở dữ liệu
$priceRange = $product->getPriceRange();

// Nếu giá max chưa được đặt trong URL, sử dụng giá max từ cơ sở dữ liệu
if ($priceMax == 0) {
    $priceMax = $priceRange['max'];
}

// Lấy tổng số sản phẩm (không phân trang)
$totalProducts = $product->getTotalProducts($keyword, $priceMin, $priceMax, $doCung, $diemCanBang, $trongLuong, $loiChoi, $category);

// Lấy sản phẩm theo phân trang và các bộ lọc
$result = $product->getFilteredProducts($keyword, $priceMin, $priceMax, $doCung, $diemCanBang, $trongLuong, $loiChoi, $sortBy, $currentPage, $productsPerPage, $category);
$totalPages = ceil($totalProducts / $productsPerPage);

// Tính vị trí bắt đầu và kết thúc của sản phẩm hiển thị
$startItem = (($currentPage - 1) * $productsPerPage) + 1;
$endItem = min($startItem + count($result) - 1, $totalProducts);

// Cập nhật phần lấy dữ liệu từ cơ sở dữ liệu
// Lấy danh sách danh mục
$categories = $product->getCategories();

// Lấy danh sách các giá trị lọc từ cơ sở dữ liệu
$stiffnessValues = $product->getStiffnessValues();
$balanceValues = $product->getBalanceValues();
$tensionValues = $product->getTensionValues();
$playStyleValues = $product->getPlayStyleValues();

// Lấy các khoảng giá phổ biến
$popularPriceRanges = $product->getPopularPriceRanges();

// Kiểm tra xem có bộ lọc nào được áp dụng không
$hasFilters = !empty($keyword) || $priceMin > 0 || $priceMax < $priceRange['max'] || !empty($doCung) || !empty($diemCanBang) || !empty($trongLuong) || !empty($loiChoi) || !empty($category);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/products.css">
    <link rel="stylesheet" href="../public/css/cart.css">
 
</head>

<body>
    <div class="wrapper">
    <?php
    include '../includes/header.php';
?>
        <main class="main">
            <div class="container">

                <div class="content-wrapper">
                    <!-- Sidebar -->
                    <aside class="sidebar">
                        <div class="category-box">
                            <div class="category-header">
                                DANH MỤC SẢN PHẨM
                            </div>
                            <ul class="category-list">
                                <li><a href="products.php" class="<?php echo empty($category) ? 'active' : ''; ?>">Tất cả sản phẩm</a></li>
                                <?php foreach ($categories as $cat): ?>
                                <li><a href="products.php?category=<?php echo urlencode($cat); ?>" class="<?php echo $category === $cat ? 'active' : ''; ?>"><?php echo $cat; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </aside>

                    <!-- Product Grid -->
                    <div class="product-area">
                        <div class="product-controls">
                            <div class="breadcrumbs">
                                <a href="../public/index.html">Trang chủ</a> &gt; <a href="./products.php">Sản phẩm</a>
                                <?php if (!empty($category)): ?>
                                &gt; <span><?php echo $category; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="product-count">
                                Hiển thị <?php echo $startItem; ?>–<?php echo $endItem; ?> của <?php echo $totalProducts; ?> kết quả
                            </div>
                            <div class="product-sort">
                                <span>Sắp xếp:</span>
                                <select id="sort-select" onchange="applySort(this.value)">
                                    <option value="newest" <?php echo $sortBy == 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                                    <option value="price-asc" <?php echo $sortBy == 'price-asc' ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
                                    <option value="price-desc" <?php echo $sortBy == 'price-desc' ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
                                    <option value="name-asc" <?php echo $sortBy == 'name-asc' ? 'selected' : ''; ?>>Tên: A-Z</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hiển thị các bộ lọc đã chọn -->
                        <?php if ($hasFilters): ?>
                        <div class="active-filters">
                            <div class="active-filters-header">
                                <span>Bộ lọc đã chọn:</span>
                                <a href="products.php" class="clear-all-filters">Xóa tất cả</a>
                            </div>
                            <div class="filter-tags">
                                <?php if (!empty($keyword)): ?>
                                <div class="filter-tag">
                                    Từ khóa: <?php echo htmlspecialchars($keyword); ?>
                                    <a href="<?php echo removeFilterFromUrl('keyword'); ?>" class="remove-filter"><i class="ti-close"></i></a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if ($priceMin > 0 || $priceMax < $priceRange['max']): ?>
                                <div class="filter-tag">
                                    Giá: <?php echo number_format($priceMin, 0, ',', '.'); ?>đ - <?php echo number_format($priceMax, 0, ',', '.'); ?>đ
                                    <a href="<?php echo removeFilterFromUrl(['price_min', 'price_max']); ?>" class="remove-filter"><i class="ti-close"></i></a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($doCung)): ?>
                                <div class="filter-tag">
                                    Độ cứng: <?php echo $doCung; ?>
                                    <a href="<?php echo removeFilterFromUrl('do_cung'); ?>" class="remove-filter"><i class="ti-close"></i></a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($diemCanBang)): ?>
                                <div class="filter-tag">
                                    Điểm cân bằng: <?php echo $diemCanBang; ?>
                                    <a href="<?php echo removeFilterFromUrl('diem_can_bang'); ?>" class="remove-filter"><i class="ti-close"></i></a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($trongLuong)): ?>
                                <div class="filter-tag">
                                    Trọng lượng: <?php echo $trongLuong; ?>
                                    <a href="<?php echo removeFilterFromUrl('trong_luong'); ?>" class="remove-filter"><i class="ti-close"></i></a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($loiChoi)): ?>
                                <div class="filter-tag">
                                    Lối chơi: <?php echo $loiChoi; ?>
                                    <a href="<?php echo removeFilterFromUrl('loi_choi'); ?>" class="remove-filter"><i class="ti-close"></i></a>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($category)): ?>
                                <div class="filter-tag">
                                    Danh mục: <?php echo $category; ?>
                                    <a href="<?php echo removeFilterFromUrl('category'); ?>" class="remove-filter"><i class="ti-close"></i></a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="filter-bar">
                            <div class="filter-group">
                                <button class="filter-btn">Khoảng Giá <i class="ti-angle-down"></i></button>
                                <div class="filter-dropdown price-dropdown">
                                    <div class="price-options">
                                        <?php foreach ($popularPriceRanges as $range): ?>
                                        <a href="#" class="price-option" data-min="<?php echo $range['min']; ?>" data-max="<?php echo $range['max']; ?>"><?php echo $range['label']; ?></a>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="price-custom">
                                        <p>Hoặc chọn mức giá phù hợp với bạn</p>
                                        <div class="price-range-inputs">
                                            <input type="text" class="price-input" id="min-price-input" placeholder="<?php echo $priceRange['min']; ?>" value="<?php echo $priceMin; ?>">
                                            đ
                                            <input type="text" class="price-input" id="max-price-input"
                                                placeholder="<?php echo $priceRange['max']; ?>" value="<?php echo $priceMax; ?>"> đ
                                        </div>

                                        <div class="price-slider-container">
                                            <div class="price-slider-container">
                                                <div class="multi-range-slider" id="price-range-slider">
                                                    <input type="range" id="min-price-slider" min="<?php echo $priceRange['min']; ?>" max="<?php echo $priceRange['max']; ?>"
                                                        value="<?php echo $priceMin; ?>" class="price-slider min-slider">
                                                    <input type="range" id="max-price-slider" min="<?php echo $priceRange['min']; ?>" max="<?php echo $priceRange['max']; ?>"
                                                        value="<?php echo $priceMax; ?>" class="price-slider max-slider">
                                                    <div class="slider-track"></div>
                                                </div>
                                                <div class="price-labels">
                                                    <span><?php echo number_format($priceRange['min'], 0, ',', '.'); ?>đ</span>
                                                    <span><?php echo number_format($priceRange['max'], 0, ',', '.'); ?>đ</span>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="apply-filter-btn" id="apply-price-filter">LỌC</button>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-group">
                                <button class="filter-btn">Độ Cứng <i class="ti-angle-down"></i></button>
                                <div class="filter-dropdown">
                                    <div class="stiffness-options">
                                        <?php 
                                        $stiffnessChunks = array_chunk($stiffnessValues, 3); // Hiển thị 3 giá trị mỗi hàng
                                        foreach ($stiffnessChunks as $chunk): 
                                        ?>
                                        <div class="stiffness-row">
                                            <?php foreach ($chunk as $value): ?>
                                            <a href="#" class="stiffness-option <?php echo $doCung == $value ? 'active' : ''; ?>" data-value="<?php echo $value; ?>"><?php echo $value; ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-group">
                                <button class="filter-btn">Điểm Cân Bằng <i class="ti-angle-down"></i></button>
                                <div class="filter-dropdown balance-dropdown">
                                    <div class="balance-options">
                                        <?php 
                                        $balanceChunks = array_chunk($balanceValues, 2); // Hiển thị 2 giá trị mỗi hàng
                                        foreach ($balanceChunks as $chunk): 
                                        ?>
                                        <div class="balance-row">
                                            <?php foreach ($chunk as $value): ?>
                                            <a href="#" class="balance-option <?php echo $diemCanBang == $value ? 'active' : ''; ?>" data-value="<?php echo $value; ?>"><?php echo $value; ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-group">
                                <button class="filter-btn">Trọng Lượng <i class="ti-angle-down"></i></button>
                                <div class="filter-dropdown tension-dropdown">
                                    <div class="tension-options">
                                        <?php 
                                        $tensionChunks = array_chunk($tensionValues, 2); // Hiển thị 2 giá trị mỗi hàng
                                        foreach ($tensionChunks as $chunk): 
                                        ?>
                                        <div class="tension-row">
                                            <?php foreach ($chunk as $value): ?>
                                            <a href="#" class="tension-option <?php echo $trongLuong == $value ? 'active' : ''; ?>" data-value="<?php echo $value; ?>"><?php echo $value; ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-group">
                                <button class="filter-btn">Lối Chơi <i class="ti-angle-down"></i></button>
                                <div class="filter-dropdown">
                                    <div class="play-style-options">
                                        <?php 
                                        $playStyleChunks = array_chunk($playStyleValues, 2); // Hiển thị 2 giá trị mỗi hàng
                                        foreach ($playStyleChunks as $chunk): 
                                        ?>
                                        <div class="play-style-row">
                                            <?php foreach ($chunk as $value): ?>
                                            <a href="#" class="play-style-option <?php echo $loiChoi == $value ? 'active' : ''; ?>" data-value="<?php echo $value; ?>"><?php echo $value; ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="san-pham-list">
                            
                        <?php
if (!empty($result)) {
    foreach ($result as $row) {
        $listImage = explode(',', $row['hinhAnh']);
        // Ẩn sản phẩm có khuyến mãi 0%
        if ($row['khuyenMai'] == '0%') {
            $discountClass = 'hidden-discount';
        } else {
            $discountClass = '';
        }
?>
        <div class="san-pham-item" data-id="<?php echo($row['idProduct'])?>">
            <div class="discount <?php echo $discountClass; ?>"><?php echo($row['khuyenMai']); ?></div>

            <img src="../public/images/product/<?php echo ($listImage[0]."/".$listImage[1]);?>" alt="Vợt cầu lông Yonex">
            <h3><?php echo($row['tenSanPham']); ?></h3>
            <p class="price"><?php echo number_format($row['gia'], 0, ',', '.'); ?> đ</p>
            <div class="san-pham-buttons">
                <button class="btn-add-cart">
                    <i class="ti-shopping-cart"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                </button>
                <button class="btn-buy-now">
                    <i class="ti-credit-card"></i> Mua ngay <!-- Icon mua ngay -->
                </button>
            </div>
        </div>
<?php
    }
} else {
    echo '<p class="no-products-found">Không có sản phẩm nào được tìm thấy.</p>';
}
?>
                        </div>

                        <!-- Phân trang -->
                        <div class="pagination">
                            <?php if ($currentPage > 1): ?>
                                <a href="?page=<?php echo $currentPage - 1; ?><?php echo getQueryString(['page']); ?>" class="prev">&laquo; Trang trước</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?php echo $i; ?><?php echo getQueryString(['page']); ?>" class="<?php echo $i === $currentPage ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="?page=<?php echo $currentPage + 1; ?><?php echo getQueryString(['page']); ?>" class="next">Trang sau &raquo;</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        </div>
    <div class="cart-side">
        <div class="container-cart">
            <div class="header_cart-side">
                <div class="header_cart">
                    <h1>Giỏ hàng</h1>
                </div>
                <div class="close_cart-side">
                    <p>Đóng<img src="../public/themify-icons/SVG/close.svg"></p>
                </div>
            </div>
            <div class="detail-side">
            </div>
            <div class="total-cart-side">
                <div>TỔNG TIỀN:</div>
                <div class="productTotal"><span class="total-amount">0</span><span>đ</span></div>
            </div>
            <div class="cart-buttons">
                <button class="view-cart-btn">XEM GIỎ HÀNG</button>
                <button class="checkout-cart-btn">THANH TOÁN</button>
            </div>
        </div>
    </div>
    <?php
    include '../includes/footer.php';
    ?>
    <script src="../public/js/main.js"></script>
    <script src="../public/js/cart.js"></script>
    <script src="../public/js/products.js"></script>
    
    <?php
    // Hàm để tạo query string từ các tham số hiện tại, trừ các tham số cần loại bỏ
    function getQueryString($excludeParams = []) {
        $params = $_GET;
        foreach ($excludeParams as $param) {
            unset($params[$param]);
        }
        
        if (empty($params)) {
            return '';
        }
        
        return '&' . http_build_query($params);
    }
    
    // Hàm để tạo URL loại bỏ một hoặc nhiều bộ lọc
    function removeFilterFromUrl($filterParams) {
        $params = $_GET;
        
        if (is_array($filterParams)) {
            foreach ($filterParams as $param) {
                unset($params[$param]);
            }
        } else {
            unset($params[$filterParams]);
        }
        
        return 'products.php?' . http_build_query($params);
    }
    ?>
        <div class="cart-side">
        <div class="container-cart">
            <div class="header_cart-side">
                <div class="header_cart">
                    <h1>Giỏ hàng</h1>
                </div>
                <div class="close_cart-side">
                    <p>Đóng<img src="../public/themify-icons/SVG/close.svg"></p>
                </div>
            </div>
            <div class="detail-side">
            </div>
            <div class="total-cart-side">
                <div>TỔNG TIỀN:</div>
                <div class="productTotal"><span class="total-amount">0</span><span>đ</span></div>
            </div>
            <div class="cart-buttons">
                <button class="view-cart-btn">XEM GIỎ HÀNG</button>
                <button class="checkout-cart-btn">THANH TOÁN</button>
            </div>
        </div>
    </div>

<script src="../public/js/main.js"></script>
<script src="../public/js/cart.js"></script>
</body>

</html>
