<?php
session_start();
echo 'User ID: ' . ($_SESSION['idUser'] ?? 'Chưa có');
include '../admin/entities/product.php';
$product = new product();
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$result = $product->getProduct($keyword);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./css/cart.css">
    
    <script>
        var isLoggedIn = <?php echo isset($_SESSION['idUser']) ? 'true' : 'false'; ?>;
        let userId = <?php echo isset($_SESSION['idUser']) ? $_SESSION['idUser'] : 'null'; ?>;
    </script>
</head>

<body class="">
    <div class="wrapper">
<?php
    include '../includes/header.php';
?>
        <main class="main">
            <div class="container">
                <section class="banner">
                    <div class="carousel">
                        <div class="carousel-track">
                            <div class="carousel-item">
                                <img src="./images/banner1.jpg" alt="Banner 1">
                                <div class="banner-text">
                                    <h1>Chào mừng đến với Website</h1>
                                    <p>Khám phá sản phẩm của chúng tôi</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="./images/banner2.jpg" alt="Banner 2">
                                <div class="banner-text">
                                    <h1>Ưu đãi đặc biệt</h1>
                                    <p>Giảm giá lên đến 50% cho các sản phẩm mới</p>
                                </div>
                            </div>
                        </div>
                        <!-- Nút chuyển slide -->
                        <button class="prev-btn">&#10094;</button>
                        <button class="next-btn">&#10095;</button>
                    </div>
                </section>

                <section class="services">
                    <div class="services-list">
                        <div class="service-item">
                            <h5>GIAO HÀNG TOÀN QUỐC </h5>
                            <p>Tất cả tỉnh thành</p>
                        </div>
                        <div class="service-item">
                            <h5>MIỄN PHÍ VẬN CHUYỂN</h5>
                            <p>Sản phẩm bảo đảm chất lượng.</p>
                        </div>
                        <div class="service-item">
                            <h5>MIỄN PHÍ VẬN CHUYỂN</h5>
                            <p>Cho đơn hàng trên 10 triệu tại TP.HCM</p>
                        </div>
                        <div class="service-item">
                            <h5>MIỄN PHÍ VẬN CHUYỂN</h5>
                            <p>03xx.xxx.xxx</p>
                        </div>
                    </div>

                </section>
                <!-- <section class="gioi-thieu">
                    <div class="gioi-thieu-container">
                        <div class="gioi-thieu-text">
                            <h2>Giới thiệu về chúng tôi</h2>
                            <p>
                                Chúng tôi là một công ty chuyên cung cấp các sản phẩm chất lượng cao, đáp ứng nhu cầu
                                của khách hàng. Với đội ngũ chuyên nghiệp và tận tâm, chúng tôi cam kết mang đến trải
                                nghiệm tốt nhất cho bạn.
                            </p>
                            <p>
                                Sứ mệnh của chúng tôi là trở thành thương hiệu hàng đầu trong lĩnh vực cung cấp sản phẩm
                                và dịch vụ, luôn đặt khách hàng làm trọng tâm.
                            </p>
                            <a href="#" class="btn">Tìm hiểu thêm</a>
                        </div>
                        <div class="gioi-thieu-image">
                            <figure>
                                <img src="./images/gioi-thieu.jpg" alt="Giới thiệu">
                                <figcaption>Giới thiệu</figcaption>
                            </figure>
                        </div>
                    </div>
                </section> -->
                <section class="san-pham-moi">
                    <h2>SẢN PHẨM MỚI</h2>

                    <div class="san-pham-content">
                        <!-- Danh sách sản phẩm Vợt Cầu Lông -->
                        <div class="san-pham-list active" id="vot">
                         <?php
                            while($row=$product->getProductFetch()){
                                $listImage =explode(',',$row['hinhAnh']); 
                            ?>
                            
                                <div class="san-pham-item" data-id = "<?php echo($row['idProduct'])?>">
                                    <div class="discount"><?php echo($row['khuyenMai']); ?></div>

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
                         ?>
                        </div>
                        
                            

                            <!-- Danh sách sản phẩm Quả Cầu Lông -->
                            <!-- <button class="slider-prev">&#10094;</button>
                            <button class="slider-next">&#10095;</button> -->
                    </div>
                    <button class="view-more">Xem thêm</button>
                </section>
                <section class="contact">
                    <div class="contact-container">
                        <h3>Hãy liên hệ chúng tôi để được tư vấn miễn phí</h3>
                        <a href="tel:03xx.xxx.xxx" class="contact-button">
                            <i class="fas fa-phone-alt"></i> 03xx.xxx.xxx
                        </a>
                    </div>
                </section>
                <section class="vot vot-yonex">
                    <div class="header-row">
                        <h2>VỢT YONEX</h2>
                        <a href="#" class="view-more-link">Xem thêm</a>
                    </div>
                    <div class="carousel-container">
                        <div class="carousel-track">
                            <div class="san-pham-content">
                                <!-- Danh sách sản phẩm Vợt Cầu Lông -->
                                <div class="san-pham-list active" id="vot">
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>



                                    <!-- Danh sách sản phẩm Quả Cầu Lông -->
                                    <button class="slider-prev">&#10094;</button>
                                    <button class="slider-next">&#10095;</button>
                                </div>
                            </div>
                        </div>
                </section>
                <section class="vot vot-lining">
                    <div class="header-row">
                        <h2>VỢT LINING</h2>
                        <a href="#" class="view-more-link">Xem thêm</a>
                    </div>
                    <div class="carousel-container">
                        <div class="carousel-track">
                            <div class="san-pham-content">
                                <!-- Danh sách sản phẩm Vợt Cầu Lông -->
                                <div class="san-pham-list active" id="vot">
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>



                                    <!-- Danh sách sản phẩm Quả Cầu Lông -->
                                    <button class="slider-prev">&#10094;</button>
                                    <button class="slider-next">&#10095;</button>
                                </div>
                            </div>
                        </div>
                </section>
                <section class="vot vot-victor">
                    <div class="header-row">
                        <h2>VỢT VICTOR</h2>
                        <a href="#" class="view-more-link">Xem thêm</a>
                    </div>
                    <div class="carousel-container">
                        <div class="carousel-track">
                            <div class="san-pham-content">
                                <!-- Danh sách sản phẩm Vợt Cầu Lông -->
                                <div class="san-pham-list active" id="vot">
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>
                                    <div class="san-pham-item">
                                        <div class="discount">-6%</div>

                                        <img src="./images/san-pham.jpg" alt="Vợt cầu lông Yonex">
                                        <h3>Vợt cầu lông Mizuno JPX</h3>
                                        <p class="price">2.500.000 đ</p>
                                        <div class="san-pham-buttons">
                                            <button class="btn-add-cart">
                                                <i class="fas fa-cart-plus"></i> Giỏ hàng <!-- Icon giỏ hàng -->
                                            </button>
                                            <button class="btn-buy-now">
                                                <i class="fas fa-shopping-bag"></i> Mua ngay <!-- Icon mua ngay -->
                                            </button>
                                        </div>
                                    </div>



                                    <!-- Danh sách sản phẩm Quả Cầu Lông -->
                                    <button class="slider-prev">&#10094;</button>
                                    <button class="slider-next">&#10095;</button>
                                </div>
                            </div>
                        </div>
                </section>


                <section class="gioi-thieu">
                    <div class="gioi-thieu-container">
                        <div class="gioi-thieu-text">
                            <h2>Chơi Cầu Lông - Tăng Cường Sức Khỏe Mỗi Ngày!</h2>
                            <p>
                                Cầu lông là môn thể thao không chỉ mang lại niềm vui, mà còn giúp bạn cải thiện sức
                                khỏe, tăng cường sự dẻo dai và phản xạ nhanh. Với vợt cầu lông chất lượng, bạn có thể dễ
                                dàng nâng cao khả năng chơi của mình, tận hưởng mỗi trận đấu từ cơ bản đến chuyên
                                nghiệp. Chúng tôi cam kết cung cấp những cây vợt với chất liệu tốt nhất, thiết kế tối
                                ưu, giúp bạn có trải nghiệm thể thao tuyệt vời nhất.


                            </p>
                            <p>
                                Hãy chọn cho mình một cây vợt cầu lông chất lượng và bắt đầu hành trình rèn luyện sức
                                khỏe ngay hôm nay!
                            </p>
                        </div>
                        <div class="gioi-thieu-image">
                            <figure>
                                <img src="./images/gioi-thieu.jpg" alt="Giới thiệu">
                                <figcaption>Giới thiệu</figcaption>
                            </figure>
                        </div>
                    </div>
                </section>
                <section class="tin-tuc">
                    <div class="container">
                        <h2>TIN TỨC</h2>
                        <div class="tin-tuc-list">
                            <div class="tin-tuc-item">
                                <img src="./images/tin-tuc.jpg" alt="Tin tức 1">
                                <h3>Tiêu đề bài viết 1</h3>
                                <p>Mô tả ngắn gọn về bài viết 1. Đây là nội dung giới thiệu ngắn để thu hút người đọc.
                                </p>
                                <a href="#" class="btn-read-more">Đọc thêm</a>
                            </div>
                            <div class="tin-tuc-item">
                                <img src="./images/tin-tuc.jpg" alt="Tin tức 2">
                                <h3>Tiêu đề bài viết 2</h3>
                                <p>Mô tả ngắn gọn về bài viết 2. Đây là nội dung giới thiệu ngắn để thu hút người đọc.
                                </p>
                                <a href="#" class="btn-read-more">Đọc thêm</a>
                            </div>
                            <div class="tin-tuc-item">
                                <img src="./images/tin-tuc.jpg" alt="Tin tức 3">
                                <h3>Tiêu đề bài viết 3</h3>
                                <p>Mô tả ngắn gọn về bài viết 3. Đây là nội dung giới thiệu ngắn để thu hút người đọc.
                                </p>
                                <a href="#" class="btn-read-more">Đọc thêm</a>
                            </div>
                        </div>
                        <!-- Nút Xem thêm -->
                        <div class="tin-tuc-view-more">
                            <a href="./tin-tuc.html" class="btn-view-more">Xem thêm</a>
                        </div>
                    </div>
                </section>
                <section class="nha-dong-hanh">
                    <div class="container">
                        <h2>NHÀ ĐỒNG HÀNH</h2>
                        <div class="logo-carousel">
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 1"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 2"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 3"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 4"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 5"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 6"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 7"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 8"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 9"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 10"></div>

                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 1"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 2"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 3"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 4"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 5"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 6"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 7"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 8"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 9"></div>
                            <div class="logo-item"><img src="./images/nha-dong-hanh.png" alt="Logo 10"></div>
                        </div>
                    </div>
                </section>


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
                <!-- <div class="detail_cart-side">
                    <img src="../public/images/san-pham.jpg" alt="Vợt" class="product-image">
                    <div class="item-info">
                        <div class="item-name">VỢT CẦU LÔNG YONEX ARCSABER 0</div>
                        <div class="item-quantity"><span style="color: red;">1</span> × 560.000đ</div>
                    </div>
                </div> -->
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
    <!-- <script src="../public/js/side-cart.js"></script> -->
</body>
</html>