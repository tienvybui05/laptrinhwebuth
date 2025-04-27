<?php
session_start();
include '../admin/entities/product.php';
include '../admin/entities/news.php'; // Thêm dòng này để import class news

$product = new product();
$news = new news(); // Khởi tạo đối tượng news
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$result = $product->getProduct($keyword);

// Lấy 3 tin tức mới nhất cho phần tin tức ở trang chủ
$latestNews = $news->getAllNews(3);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu</title>
    <link rel="stylesheet" href="../public/css/products.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/cart.css">

    

</head>

<body>
    <div class="wrapper">
    
    <?php
    include '../includes/header.php';
?>
        <main class="main">
        <div class="breadcrumbs">
            <a href="../public/index.php">Trang chủ</a> &gt; <a href="./about.php">Giới thiệu</a>
                               
        </div>
            <div class="container">
                <div class="gioi-thieu-about">
                    <div class="noi-dung-gioi-thieu-about">
                        <h1>Về chúng tôi</h1>
                        <p>Chúng tôi chuyên cung cấp các loại vợt cầu lông chất lượng từ những thương hiệu hàng
                            đầu như Yonex, Lining, Victor, Adidas và nhiều thương hiệu nổi tiếng khác.</p>
                        <p>Với sứ mệnh mang đến sản phẩm chính hãng, giá cả cạnh tranh cùng dịch vụ tư vấn tận tâm,
                            [Tên Trang Web] cam kết giúp bạn tìm được cây vợt phù hợp nhất với phong cách chơi và trình
                            độ của mình.</p>
                        <p>Dù bạn là người mới tập chơi hay một vận động viên chuyên nghiệp, chúng tôi luôn sẵn sàng
                            đồng hành cùng bạn trên hành trình chinh
                            phục đỉnh cao cầu lông. Hãy khám phá ngay bộ sưu tập vợt mới nhất và tận hưởng trải nghiệm
                            mua sắm tuyệt vời tại [Tên Trang Web]!</p>
                    </div>
                    <div class="anh-gioi-thieu-about">
                        <img src="../public/images/introduct-in-about.webp" alt="">
                    </div>
                </div>
                <div class="about-san-pham">
                    <div class="anh-san-pham-about">
                        <img src="../public/images/product-vdntdz-about.jpg" alt="">
                    </div>
                    <div class="noi-dung-san-pham-about">
                        <h2>Sản phẩm</h2>
                        <ul>
                            <li>
                                <p>Sản phẩm đa dạng - Từ vợt dành cho người mới chơi đến vợt chuyên nghiệp, phù hợp với
                                    mọi cấp độ.</p>
                            </li>
                            <li>
                                <p>Cam kết chính hãng - Chúng tôi chỉ cung cấp sản phẩm chính hãng với chất lượng đảm
                                    bảo.</p>
                            </li>
                            <li>
                                <p>Giá cả cạnh tranh - Mức giá tốt nhất thị trường, đi kèm nhiều ưu đãi hấp dẫn.</p>
                            </li>
                            <li>
                                <p>Tư vấn chuyên sâu - Đội ngũ hỗ trợ tận tâm giúp bạn chọn được vợt phù hợp nhất.</p>
                            </li>
                            <li>
                                <p>Giao hàng nhanh chóng - Ship toàn quốc với thời gian nhanh nhất.</p>
                            </li>
                        </ul>
                        <p>Hãy khám phá ngay bộ sưu tập vợt cầu lông ngay <a href="../pages/products.php">Tại đây 🔥</a></p>
                    </div>
                </div>
                <h2 class="center-about-lien-he">Thành viên trung tâm</h2>
                <div class="row-about">
                    <div class="column-about">
                        <div class="card-about">
                            <img class="anh-thanh-vien-about" src="../public/images/introduct-in-about.webp" alt="">
                            <div class="container-about">
                                <h3>Bùi Tiến Vỹ</h3>
                                <p class="title-about">Tư vấn</p>
                                <p>Tư vấn khách hàng về các loại vợt, phụ kiện cầu lông.</p>
                                <p>TienVy@gmail.com</p>
                                <p><a href="https://facebook.com/TienVyBui05" target="_blank" style="text-decoration: none;"><button class="button-about">Liên hệ</button></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="column-about">
                        <div class="card-about">
                            <img class="anh-thanh-vien-about" src="../public/images/introduct-in-about.webp"
                                alt="anh ca nhan">
                            <div class="container-about">
                                <h3>Võ Cao Tấn Ngọc</h3>
                                <p class="title-about">Kỹ thuật</p>
                                <p>Kiểm tra, sửa chữa các lỗi trên vợt như nứt, gãy, hư dây đan.</p>
                                <p>TanNgoc@gmail.com</p>
                                <p><a href="https://www.facebook.com/caongoctan.vo" target="_blank" style="text-decoration: none;"><button class="button-about">Liên hệ</button></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="column-about">
                        <div class="card-about">
                            <img class="anh-thanh-vien-about" src="../public/images/introduct-in-about.webp"
                                alt="anh ca nhan">
                            <div class="container-about">
                                <h3>Đinh Quốc Đạt</h3>
                                <p class="title-about">Thu ngân</p>
                                <p>Xuất hóa đơn, kiểm tra các giao dịch.</p>
                                <p>QuocDat@gmail.com</p>
                                <p><a href="https://www.facebook.com/quoc.at.145458" target="_blank" style="text-decoration: none;"><button class="button-about">Liên hệ</button></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="column-about">
                        <div class="card-about">
                            <img class="anh-thanh-vien-about" src="../public/images/introduct-in-about.webp"
                                alt="anh ca nhan">
                            <div class="container-about">
                                <h3>Trần Minh Thái</h3>
                                <p class="title-about">Chăm sóc khách hàng</p>
                                <p>Giải quyết khiếu nại và phản hồi của khách hàng.</p>
                                <p>MinhThai@gmail.com</p>
                                <p><a href="https://www.facebook.com/tran.thai.73594479" target="_blank" style="text-decoration: none;"><button class="button-about">Liên hệ</button></a></p>
                            </div>
                        </div>
                    </div>
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