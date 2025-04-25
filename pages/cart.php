<?php
session_start();
include_once '../admin/entities/cart-customer.php';
$cart = new cart_customer();
$idUser = @$_SESSION['idUser'];
$cart = new cart_customer();
$result = $cart->getCartByUser($idUser);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/cart.css">
</head>

<body class="">
    <div class="wrapper" style="background-color: #f5f5f5;">
    <?php
    include '../includes/header.php';
?>
        <main class="main-cart">
            <div class="main_cart-container">
                <div id="name_giohang">
                    <h1>Giỏ Hàng</h1>
                </div>

                <div class="search-cart">
                    <input type="text" placeholder="Tìm sản phẩm, thương hiệu, và tên shop">
                </div>

                <div class="class-cart_content">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <td align="left" bgcolor="fafafa"><input id="chonhet" type="checkbox" aria-label="Chọn tất cả"></td>
                                <th>Sản Phẩm</th>
                                <th>Đơn Giá</th>
                                <th>Số Lượng</th>
                                <th>Số Tiền</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if ($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()){ 
                                        $listImage = explode(',', $row['hinhAnh']);
                            ?>
                                <tr class="san-pham-items">
                                    <td><input type="checkbox" class="product-checkbox" name="chon" value=""></td>     
                                    <td>
                                        <div class="product-item">
                                            <img src="../public/images/product/<?php echo ($listImage[0]."/".$listImage[1]);?>" alt="Vợt" class="product-image">
                                            <div class="product-info">
                                                <div class="product-name"><?php echo($row['tenSanPham']); ?></div>
                                            </div>
                                        </div>
                                    </td>   
                                    <td class="price"><?php echo number_format($row['gia'], 0, ',', '.'); ?>đ</td>
                                    <td>
                                        <div class="quantity-control">
                                            <button class="quantity-btn-minus" data-id="<?php echo $row['idProduct']; ?>">-</button>
                                            <input type="text" value="<?php echo($row['soLuong']); ?>" class="quantity-input">
                                            <button class="quantity-btn-plus" data-id="<?php echo $row['idProduct']; ?>">+</button>
                                        </div>
                                    </td>
                                    <td class="product-total"><?php echo number_format($row['thanhTien'], 0, ',', '.'); ?>đ</td>
                                    <td class="close-cart_item">
                                        <button class="action-btn" data-id="<?php echo $row['idProduct']; ?>" data-iduser="<?php echo $_SESSION['idUser']; ?>">
                                            <span>Xóa</span>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>Không có sản phẩm trong giỏ hàng.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <div class="summary">
                        <h3 class="summary-title">Tóm tắt đơn hàng</h3>
                        <div class="summary-row summary-total">
                            <div><span>Tổng cộng:</span></div>
                            <div class="total-sum"><span class="total-amount">5.340.000đ</span></div>
                        </div>
                        <button class="checkout-btn">THANH TOÁN</button>
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
                <div class="detail_cart-side">
                    <img src="../public/images/san-pham.jpg" alt="Vợt" class="product-image">
                    <div class="item-info">
                        <div class="item-name">VỢT CẦU LÔNG YONEX ARCSABER 0</div>
                        <div class="item-quantity"><span style="color: red;">1</span> × 560.000đ</div>
                    </div>
                </div>
            </div>
            <div class="total-cart-side">
                <div>TỔNG TIỀN:</div>
                <div>560.000đ</div>
            </div>
            <div class="cart-buttons">
                <button class="view-cart-btn">XEM GIỎ HÀNG</button>
                <button class="checkout-cart-btn">THANH TOÁN</button>
            </div>
        </div>
    </div>
    <script src="../public/js/cart2.js"></script>
    <script src="../public/js/jquery-3.7.1.min.js"></script>
</body>

</html>