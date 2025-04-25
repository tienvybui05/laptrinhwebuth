<?php
session_start();
include_once '../admin/entities/news.php';

// Kiểm tra ID tin tức
$id = isset($_GET['id']) ? $_GET['id'] : 0;
if (!$id) {
    header('Location: news.php');
    exit();
}

$news = new news();
$newsDetail = $news->getNewsById($id);

// Nếu không tìm thấy tin tức, chuyển hướng về trang tin tức
if (!$newsDetail) {
    header('Location: news.php');
    exit();
}

// Lấy tin tức liên quan
$relatedNews = $news->getRelatedNews($id, $newsDetail['tacGia']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $newsDetail['tieuDe']; ?> - Vợt cầu lông</title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/news.css">
</head>
<body>
    <div class="wrapper">
        <?php include '../includes/header.php'; ?>
        
        <main class="main">
            <div class="container" style="padding: 25px;">
                <div class="news-detail">
                    <div class="news-breadcrumb">
                        <a href="../public/index.php">Trang chủ</a> &gt; 
                        <a href="news.php">Tin tức</a> &gt; 
                        <span><?php echo $newsDetail['tieuDe']; ?></span>
                    </div>
                    
                    <article class="news-article">
                        <h1 class="news-title"><?php echo $newsDetail['tieuDe']; ?></h1>
                        
                        <div class="news-meta">
                            <span class="news-author"><i class="ti-user"></i> <?php echo $newsDetail['tacGia']; ?></span>
                        </div>
                        
                        <div class="news-summary">
                            <p><strong><?php echo $newsDetail['moTa']; ?></strong></p>
                        </div>
                        
                        <div class="news-featured-image">
                            <img src="../public/images/news/<?php echo $newsDetail['hinhAnh']; ?>" alt="<?php echo $newsDetail['tieuDe']; ?>">
                        </div>
                        
                        <div class="news-content">
                            <?php echo $newsDetail['noiDung']; ?>
                        </div>
                        
                        <div class="news-share">
                            <span>Chia sẻ:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank" class="share-facebook"><i class="ti-facebook"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($newsDetail['tieuDe']); ?>" target="_blank" class="share-twitter"><i class="ti-twitter"></i></a>
                        </div>
                    </article>
                    
                    <?php if ($relatedNews && $relatedNews->num_rows > 0): ?>
                    <div class="related-news">
                        <h3>Tin tức liên quan</h3>
                        <div class="related-news-list">
                            <?php while ($row = $relatedNews->fetch_assoc()): ?>
                            <div class="related-news-item">
                                <div class="related-news-image">
                                    <a href="news-detail.php?id=<?php echo $row['idTinTuc']; ?>">
                                        <img src="../public/images/news/<?php echo $row['hinhAnh']; ?>" alt="<?php echo $row['tieuDe']; ?>">
                                    </a>
                                </div>
                                <div class="related-news-info">
                                    <h4><a href="news-detail.php?id=<?php echo $row['idTinTuc']; ?>"><?php echo $row['tieuDe']; ?></a></h4>
                                    
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
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
