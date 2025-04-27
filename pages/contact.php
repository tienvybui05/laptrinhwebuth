<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu</title>

    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/cart.css">   

</head>

<body>
    <div class="wrapper">
    
    <?php
    include '../includes/header.php';
?>
        <main class="main-lienhe">
            
    <div class="khung">
    <h3>LIÊN HỆ VỚI CHÚNG TÔI</h3>
        <div class="nd1">
            
            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn bất cứ khi nào. Đừng ngần ngại liên hệ để được tư vấn miễn phí!</p>
            <div class="thongtin">
                <div>
                    <h4>Hotline</h4>
                    <p><span><a href="tel:0704638037" style="color: black;">0704 638 037</a></span> | <span><a href="tel:0903735248" style="color: black;">0903 735 248</a></span></p>
                </div>
                <div >
                    <h4>Email</h4>
                    <p><span><a href="mailto:abc123@gmail.com" style="color: black;">abc123@gmail.com</a></span></p>
                </div>
                <div >
                    <h4>Địa chỉ</h4>
                    <p><span>Trường Đại Học Giao Thông Vận Tải Thành Phố Hồ Chí Minh (UTH) - Cơ sở 3, 70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh</span></p>
                </div>
                <div c>
                    <h4>Giờ làm việc</h4>
                    <p><span>Thứ 2 - Thứ 7: 08:00 - 17:30</span><br><span>Chủ Nhật: Nghỉ</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bando">
        
        <div class="google-map">
            <iframe class="map-frame"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15673.148864820329!2d106.59906348715825!3d10.865745499999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752b2a11844fb9%3A0xbed3d5f0a6d6e0fe!2zVHLGsOG7nW5nIMSQ4bqhaSBI4buNYyBHaWFvIFRow7RuZyBW4bqtbiBU4bqjaSBUaMOgbmggUGjhu5EgSOG7kyBDaMOtIE1pbmggKFVUSCkgLSBDxqEgc-G7nyAz!5e0!3m2!1svi!2s!4v1742871467945!5m2!1svi!2s"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
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