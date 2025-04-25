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

    <style>
        .main-lienhe .khung {
            width: 50%;
            margin-left: 10%;
            margin-bottom: 10px;
            float: left;
        }

        .main-lienhe .khung-phai {
            width: 30%;
            float: right;
            background-color: black;
            border-radius: 12px;
            padding: 15px;
            margin-right: 5%;
            margin-top: 14px;
        }

        /* Phần chứa logo */
        .logo-container {
            background-color: #232222;
            width: 100%;
            height: 110px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 12px 12px 12px 12px;
            box-sizing: border-box;
        }

      

        .menu-title {
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 5px;
        }

        /* Danh sách chi nhánh */
        .chinhanh {
            padding: 15px;
        }

        .chinhanh ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .chinhanh li {
            background: black;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 16px;
        }

        .chinhanh a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s, transform 0.2s;
            display: inline-block;
        }

        .chinhanh a:hover {
            color: #0056b3;
            transform: scale(1.05);
        }

        .chinhanh a:active {
            color: #003d80;
        }

        .chinhanh li b {
            color: white;
            font-size: 17px;
        }

        .chinhanh li br {
            display: block;
            content: "";
            margin-bottom: 5px;
        }

        /* Định dạng chung cho form */
        .group_contact {
            max-width: 600px;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            margin: auto;
        }

        /* Định dạng input và textarea */
        .group_contact .row input,
        .group_contact .row textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            box-sizing: border-box;
        }

        #formhoten input {
            width: 49%;
            float: left;
        }

        #formmail input {
            width: 49%;
            float: right;
        }

        .clearfix {
            clear: both;
        }

        /* Khoảng cách giữa các ô nhập */
        .form2 {
            margin-top: 10px;
        }

        /* Chỉnh textarea */
        .form2 textarea {
            width: 100%;
            height: 150px;
            resize: none;
            font-family: Arial, sans-serif;
        }

        /* Định dạng nút gửi */
        .sub {
            margin-top: 10px;
        }

        .sub button {
            background-color: #004a67;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .sub button:hover {
            background-color: #00384d;
        }

        .bando .map-frame {
            width: 85%;
            height: 450px;
            border: 0;
            margin-top: 10px;
            margin-left: 10%;
            margin-bottom: 10px;
            margin-right: 5%;
            box-sizing: border-box;
            clear: both;
        }

      
    </style>
    

</head>

<body>
    <div class="wrapper">
    
    <?php
    include '../includes/header.php';
?>
        <main class="main-lienhe">
            <div class="khung">
                <div class="nd1">
                    <h3>NƠI GIẢI ĐÁP TOÀN BỘ MỌI THẮC MẮC CỦA BẠN?</h3>
                    <div>
                        <p><b>Hotline:</b> <span style="color: olive;">0704638037 | 0903735248</span></p>
                    </div>
                    <div>
                        <p><b>Email:</b> <span style="color: olive;">abc@shopvot.com</span></p>
                    </div>
                </div>
                <div class="form-contact">
                    <div class="containermt-4">
                        <h4 class="mb-3">Liên hệ với chúng tôi</h4>
                        <form accept-charset="UTF-8" action="contact" method="post" class="has-validation-callback">
                            <input name="act" type="hidden" value="gui">

                            <div class="group_contact">
                                <div class="row">
                                    <div id="hang1">
                                        <div id="formhoten">
                                            <input placeholder="Họ và tên" type="text" class="form-control" name="ten"
                                                required>
                                        </div>
                                        <div id="formmail">
                                            <input placeholder="Email" type="email" class="form-control" name="email"
                                                required>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> <!-- Thêm dòng này -->
                                    <div class="form2">
                                        <input placeholder="Điện thoại" type="tel" class="form-control" name="dienthoai"
                                            required>
                                    </div>
                                    <div class="form2">
                                        <textarea placeholder="Nội dung" class="form-control" name="noidung" rows="5"
                                            required></textarea>
                                    </div>
                                    <div class="sub">
                                        <button type="submit" class="btn btn-primary">Gửi thông tin</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="khung-phai">
                <div class="logo-container">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <h3 class="menu-title" style="color: white; text-align: center;">Địa chỉ liên hệ</h3>
                </div>
                <div class="chinhanh">
                    <ul>
                        <li>
                            <b>Trường đại học giao thông vận tải CS1</b> - 0912345678
                            <br>
                            <a href="https://maps.app.goo.gl/M4QBoxX7LauDNWKf8" target="_blank">
                                Số 2, Đường Võ Oanh, P.25, Q. Bình Thạnh, TP. Hồ Chí Minh
                            </a>
                        </li>
                        <li>
                            <b>Trường đại học giao thông vận tải CS2</b> - 0912345678
                            <br>
                            <a href="https://maps.app.goo.gl/Sxo4f32H1XaYUznW9" target="_blank">
                                Số 10 đường số 12, KP3, P. An Khánh, TP. Thủ Đức, TP. Hồ Chí Minh
                            </a>
                        </li>
                        <li>
                            <b>Trường đại học giao thông vận tải CS3</b> - 0912345678
                            <br>
                            <a href="https://maps.app.goo.gl/2nGVVG7M6XdQamnw7" target="_blank">
                                Số 70 đường Tô Ký, phường Tân Chánh Hiệp, quận 12, TP. Hồ Chí Minh
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bando">
                <!-- Bản đồ Google Maps -->
                <div class="google-map">
                    <iframe class="map-frame"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15673.148864820329!2d106.59906348715825!3d10.865745499999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752b2a11844fb9%3A0xbed3d5f0a6d6e0fe!2zVHLGsOG7nW5nIMSQ4bqhaSBI4buNYyBHaWFvIFRow7RuZyBW4bqtbiBU4bqjaSBUaMOgbmggUGjhu5EgSOG7kyBDaMOtIE1pbmggKFVUSCkgLSBDxqEgc-G7nyAz!5e0!3m2!1svi!2s!4v1742871467945!5m2!1svi!2s"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
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
                    <p>Email:
                </div>
                <div class="footer-center">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Sản phẩm</a></li>
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