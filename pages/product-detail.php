<?php
include '../admin/entities/product.php';
$product = new product();

// Lấy ID sản phẩm từ URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Nếu không có ID hoặc ID không hợp lệ, chuyển hướng về trang sản phẩm
if ($productId <= 0) {
    header('Location: products.php');
    exit;
}

// Lấy thông tin sản phẩm
$productInfo = $product->getProductbyId($productId);

// Nếu không tìm thấy sản phẩm, chuyển hướng về trang sản phẩm
if (!$productInfo) {
    header('Location: products.php');
    exit;
}

// Xử lý hình ảnh sản phẩm
$listImage = explode(',', $productInfo['hinhAnh']);
$mainImage = "../public/images/product/{$listImage[0]}/{$listImage[1]}";

// Tính giá gốc từ giá hiện tại và phần trăm khuyến mãi
$discountPercent = (int)str_replace('%', '', $productInfo['khuyenMai']);
$currentPrice = $productInfo['gia'];
$originalPrice = $discountPercent > 0 ? round($currentPrice / (1 - $discountPercent/100)) : $currentPrice;

// Lấy các sản phẩm liên quan (cùng thương hiệu)
$relatedProducts = $product->getRelatedProducts($productId, $productInfo['thuongHieu'], 4);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productInfo['tenSanPham']; ?></title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/product-detail.css">
</head>

<body>
    <div class="wrapper">
    <header class="header">
            <div class="container">
                <!--Thanh menu  -->
                <nav class="navbar">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <ul id="main-menu">
                        <li><a href="../public/index.html" class="">Trang chủ</a></li>
                        <li><a href="../pages/about.html" class="">Giới thiệu</a></li>
                        <li><a href="../pages/products.html">Sản phẩm</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="../pages/contact.html">Liên hệ</a></li>
                    </ul>
                    <script>
                        // Lấy tên trang hiện tại (VD: index.html, about.html)
                        const currentPage = window.location.pathname.split("/").pop();

                        // Lấy tất cả link trong menu
                        const navLinks = document.querySelectorAll('#main-menu a');

                        // Duyệt qua từng link để so sánh
                        navLinks.forEach(link => {
                            const linkHref = link.getAttribute("href").split("/").pop();

                            if (linkHref === currentPage) {
                                link.classList.add("active");
                            }
                        });
                    </script>

                    <!--Thanh tìm kiếm  -->
                    <div class="search-bar">
                        <input type="text" placeholder="Tìm kiếm..." />
                        <button type="submit"><i class="ti-search"></i></button>
                    </div>
                    <div class="right-icons">
                        <a href="#" class="cart-icon"><i class="ti-shopping-cart"></i></a>
                        <div class="user-menu">
                            <a href="#" class="user-icon"><i class="ti-user"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="ti-user"></i> Thông tin người dùng</a></li>
                                <li><a href="#"><i class="ti-power-off"></i> Đăng xuất</a></li>
                            </ul>
                        </div>
                        <script>// Lấy phần tử user-menu
                        </script>

                    </div>
                </nav>
            </div>
        </header>

        <main class="main">
            <div class="container">
                <!-- Breadcrumbs -->
                <div class="breadcrumbs">
                    <a href="../public/index.html">Trang chủ</a> &gt; 
                    <a href="products.php">Sản phẩm</a> &gt; 
                    <a href="products.php?keyword=<?php echo urlencode($productInfo['thuongHieu']); ?>"><?php echo $productInfo['thuongHieu']; ?></a> &gt; 
                    <span><?php echo $productInfo['tenSanPham']; ?></span>
                </div>

                <!-- Product Detail Section -->
                <div class="product-detail">
                    <div class="product-gallery">
                        <div class="main-image">
                            <img src="<?php echo $mainImage; ?>" alt="<?php echo $productInfo['tenSanPham']; ?>" id="main-product-image">
                        </div>
                        <div class="thumbnail-images">
                            <div class="thumbnail active" data-image="<?php echo $mainImage; ?>">
                                <img src="<?php echo $mainImage; ?>" alt="<?php echo $productInfo['tenSanPham']; ?> - Hình 1">
                            </div>
                            <?php
                            // Nếu có nhiều hình ảnh, hiển thị thêm
                            if (count($listImage) > 2) {
                                for ($i = 2; $i < count($listImage); $i++) {
                                    $thumbImage = "../public/images/product/{$listImage[0]}/{$listImage[$i]}";
                                    echo '<div class="thumbnail" data-image="' . $thumbImage . '">';
                                    echo '<img src="' . $thumbImage . '" alt="' . $productInfo['tenSanPham'] . ' - Hình ' . $i . '">';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="product-info">
                        <h1 class="product-title"><?php echo $productInfo['tenSanPham']; ?></h1>
                        
                        <div class="product-meta">
                            <div class="product-code">
                                <span>Mã: </span>
                                <span class="code-value">SP<?php echo $productInfo['idProduct']; ?></span>
                            </div>
                            <div class="product-brand">
                                <span>Thương hiệu: </span>
                                <a href="products.php?keyword=<?php echo urlencode($productInfo['thuongHieu']); ?>" class="brand-link"><?php echo $productInfo['thuongHieu']; ?></a>
                            </div>
                            <div class="product-status">
                                <span>Tình trạng: </span>
                                <span class="status-value in-stock"><?php echo $productInfo['tonKho'] > 0 ? 'Còn hàng' : 'Hết hàng'; ?></span>
                            </div>
                        </div>

                        <div class="product-price">
                            <div class="current-price"><?php echo number_format($currentPrice, 0, ',', '.'); ?> đ</div>
                            <?php if ($discountPercent > 0): ?>
                            <div class="original-price"><?php echo number_format($originalPrice, 0, ',', '.'); ?> đ</div>
                            <div class="discount-badge">-<?php echo $productInfo['khuyenMai']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="product-details">
                            <h3>Thông số kỹ thuật</h3>
                            <table class="specs-table">
                                <tr>
                                    <td>Trọng lượng:</td>
                                    <td><?php echo $productInfo['trongLuong']; ?></td>
                                </tr>
                                <tr>
                                    <td>Độ cứng:</td>
                                    <td><?php echo $productInfo['doCung']; ?></td>
                                </tr>
                                <tr>
                                    <td>Điểm cân bằng:</td>
                                    <td><?php echo $productInfo['diemCanBang']; ?></td>
                                </tr>
                                <tr>
                                    <td>Trình độ:</td>
                                    <td><?php echo $productInfo['trinhDo']; ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="product-features">
                            <h3>Đặc điểm nổi bật</h3>
                            <ul class="features-list">
                                <li><i class="fas fa-check"></i> Tặng 2 Quấn cán vợt Cầu Lông</li>
                                <li><i class="fas fa-check"></i> Sản phẩm cam kết chính hãng</li>
                                <li><i class="fas fa-check"></i> Một số sản phẩm sẽ được tặng bao đơn hoặc bao nhung bảo vệ vợt</li>
                                <li><i class="fas fa-check"></i> Thanh toán sau khi kiểm tra và nhận hàng</li>
                                <li><i class="fas fa-check"></i> Bảo hành chính hãng theo nhà sản xuất</li>
                            </ul>
                        </div>

                        <div class="quantity-selector">
                            <span>Số lượng:</span>
                            <div class="quantity-controls">
                                <button class="quantity-btn decrease"><i class="fas fa-minus"></i></button>
                                <input type="text" class="quantity-input" value="1">
                                <button class="quantity-btn increase"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="product-actions">
                            <button class="btn-buy-now">MUA NGAY</button>
                            <button class="btn-add-cart">THÊM VÀO GIỎ HÀNG</button>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="product-description">
                    <div class="description-tabs">
                        <div class="tab active" data-tab="description">MÔ TẢ SẢN PHẨM</div>
                        <div class="tab" data-tab="specs">THÔNG SỐ KỸ THUẬT</div>
                    </div>

                    <div class="tab-content active" id="description-content">
                        <h2><?php echo $productInfo['tenSanPham']; ?></h2>
                        <div class="product-description-content">
                            <?php echo nl2br($productInfo['moTa']); ?>
                        </div>
                    </div>

                    <div class="tab-content" id="specs-content">
                        <h2>Thông Số Kỹ Thuật Chi Tiết</h2>
                        <table class="full-specs-table">
                            <tr>
                                <th>Thông số</th>
                                <th>Chi tiết</th>
                            </tr>
                            <tr>
                                <td>Tên sản phẩm</td>
                                <td><?php echo $productInfo['tenSanPham']; ?></td>
                            </tr>
                            <tr>
                                <td>Mã sản phẩm</td>
                                <td>SP<?php echo $productInfo['idProduct']; ?></td>
                            </tr>
                            <tr>
                                <td>Thương hiệu</td>
                                <td><?php echo $productInfo['thuongHieu']; ?></td>
                            </tr>
                            <tr>
                                <td>Trọng lượng</td>
                                <td><?php echo $productInfo['trongLuong']; ?></td>
                            </tr>
                            <tr>
                                <td>Độ cứng</td>
                                <td><?php echo $productInfo['doCung']; ?></td>
                            </tr>
                            <tr>
                                <td>Điểm cân bằng</td>
                                <td><?php echo $productInfo['diemCanBang']; ?></td>
                            </tr>
                            <tr>
                                <td>Trình độ phù hợp</td>
                                <td><?php echo $productInfo['trinhDo']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Related Products -->
                <div class="related-products">
                    <h2>SẢN PHẨM LIÊN QUAN</h2>
                    <div class="product-grid">
                        <?php foreach ($relatedProducts as $relatedProduct): 
                            $relatedImages = explode(',', $relatedProduct['hinhAnh']);
                            $relatedImage = "../public/images/product/{$relatedImages[0]}/{$relatedImages[1]}";
                            
                            // // Ẩn sản phẩm có khuyến mãi 0%
                            // if ($relatedProduct['khuyenMai'] == '0%') {
                            //     $discountClass = 'hidden-discount';
                            // } else {
                            //     $discountClass = '';
                            // }
                        ?>
                        <div class="san-pham-item">
                            <div class="discount <?php echo $discountClass; ?>"><?php echo $relatedProduct['khuyenMai']; ?></div>
                            <a href="product-detail.php?id=<?php echo $relatedProduct['idProduct']; ?>">
                                <img src="<?php echo $relatedImage; ?>" alt="<?php echo $relatedProduct['tenSanPham']; ?>">
                                <h3><?php echo $relatedProduct['tenSanPham']; ?></h3>
                                <p class="price"><?php echo number_format($relatedProduct['gia'], 0, ',', '.'); ?> đ</p>
                            </a>
                            <div class="san-pham-buttons">
                                <button class="btn-add-cart">
                                    <i class="fas fa-cart-plus"></i> Giỏ hàng
                                </button>
                                <button class="btn-buy-now">
                                    <i class="fas fa-shopping-bag"></i> Mua ngay
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="footer-left">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <h3>Thông tin liên hệ</h3>
                    <p>Địa chỉ: 123 đường ABC, TP.HCM</p>
                    <p>Email: info@example.com</p>
                    <p>Hotline: 0123.456.789</p>
                </div>
                <div class="footer-center">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="../public/index.html">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-right">
                    <h3>Theo dõi chúng tôi</h3>
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook-f"></i>Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i>Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i>Instagram</a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i>Linkedin</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>

    <script src="../public/js/product-detail.js"></script>
</body>

</html>
