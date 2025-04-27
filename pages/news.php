<?php
session_start();
include_once '../admin/entities/news.php';

$news = new news();
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Lấy danh sách tin tức
if (!empty($keyword)) {
    $result = $news->searchNews($keyword);
} else {
    $result = $news->getAllNews();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức - Vợt cầu lông</title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/news.css">
    <link rel="stylesheet" href="../public/css/products.css">
    <link rel="stylesheet" href="../public/css/cart.css"> 
    <script>
        var isLoggedIn = <?php echo isset($_SESSION['idUser']) ? 'true' : 'false'; ?>;
        let idUser = <?php echo isset($_SESSION['idUser']) ? $_SESSION['idUser'] : 'null'; ?>;
    </script>
</head>
<body>
    <div class="wrapper">
        <?php include '../includes/header.php'; ?>
        
        <main class="main">
        <div class="breadcrumbs">
            <a href="../public/index.php">Trang chủ</a> &gt; <a href="./news.php">Tin tức</a>
                               
        </div>
            <div class="container">
                <div class="news-header">
                    <h1>Tin tức</h1>
                    <div class="news-search">
                        <form action="news.php" method="GET">
                            <input type="text" name="keyword" placeholder="Tìm kiếm tin tức..." value="<?php echo $keyword; ?>">
                            <button type="submit"><i class="ti-search"></i></button>
                        </form>
                    </div>
                </div>
                
                <div class="news-content">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <div class="news-list">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="news-item">
                                    <div class="news-image">
                                        <a href="news-detail.php?id=<?php echo $row['idTinTuc']; ?>">
                                            <img src="../public/images/news/<?php echo $row['hinhAnh']; ?>" alt="<?php echo $row['tieuDe']; ?>">
                                        </a>
                                    </div>
                                    <div class="news-info">
                                        <h2><a href="news-detail.php?id=<?php echo $row['idTinTuc']; ?>"><?php echo $row['tieuDe']; ?></a></h2>
                                        <div class="news-meta">
                                            <span class="news-author"><i class="ti-user"></i> <?php echo $row['tacGia']; ?></span>
                                        </div>
                                        <p class="news-description"><?php echo $row['moTa']; ?></p>
                                        <a href="news-detail.php?id=<?php echo $row['idTinTuc']; ?>" class="read-more">Đọc tiếp <i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-results">
                            <p>Không tìm thấy tin tức nào<?php echo !empty($keyword) ? ' phù hợp với từ khóa "' . $keyword . '"' : ''; ?>.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        
        <?php
    include '../includes/footer.php';
    ?>
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
    <script src="../public/js/main.js"></script>
    <script src="../public/js/cart.js"></script>
</body>
</html>
