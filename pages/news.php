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
</head>
<body>
    <div class="wrapper">
        <?php include '../includes/header.php'; ?>
        
        <main class="main">
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
        
        <footer class="footer">
            <div class="container">
                <div class="footer-left">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <h3>Thông tin liên hệ</h3>
                    <p>Địa chỉ: 123 đường ABC, TP.HCM</p>
                    <p>Email: info@example.com</p>
                </div>
                <div class="footer-center">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="../public/index.php">Trang chủ</a></li>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="news.php">Tin tức</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-right">
                    <h3>Theo dõi chúng tôi</h3>
                    <ul>
                        <li><a href="#"><i class="ti-facebook"></i>Facebook</a></li>
                        <li><a href="#"><i class="ti-twitter"></i>Twitter</a></li>
                        <li><a href="#"><i class="ti-instagram"></i>Instagram</a></li>
                        <li><a href="#"><i class="ti-linkedin"></i>Linkedin</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
