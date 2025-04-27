<?php
    session_start();
    include_once '../admin/entities/cart-customer.php';
    include_once '../admin/entities/product.php';
    include_once '../admin/entities/orders.php';

    // Kiểm tra đăng nhập
    if (!isset($_SESSION['idUser'])) {
        header('Location: ../auth/login.php');
        exit();
    }

    $idUser = $_SESSION['idUser'];
    $cart = new cart_customer();
    $product = new product();
    $orders = new orders();

    // Lấy giỏ hàng của người dùng
    $result = $orders->getOdersByUser($idUser);

    $totalAmount = 0;
    $cartItems = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $totalAmount += $row['thanhTien'];
            $cartItems[] = $row;
        }
    }

    // Xử lý khi form được gửi đi
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hoTen = $_POST['ten'];
        $soDienThoai = $_POST['dienthoai'];
        $diaChi = $_POST['diachi'];
        $ghiChu = $_POST['noidung'];
        $phuongThuc = $_POST['payment'];

        // Chuẩn bị dữ liệu sản phẩm từ giỏ hàng
        $products = [];
        foreach ($cartItems as $item) {
            $products[] = [
                'idProduct' => $item['idProduct'],
                'soLuong' => $item['soLuong'],
                'thanhTien' => $item['thanhTien']
            ];
        }

        // Tạo đơn hàng (theo kiểu updateOrder bạn yêu cầu)
        $orderCode = $orders->updateOrder($idUser, $hoTen, $soDienThoai, $diaChi, $phuongThuc, $ghiChu);

        if ($orderCode) {
            // Xóa giỏ hàng sau khi đặt hàng thành công
            $cart->clearCart($idUser, $orderCode);
            $cart->decreaseStock($idUser, $orderCode);
            
            // Chuyển hướng đến trang đặt hàng thành công
            header("Location: order-success.php?code=$orderCode");
            exit();
        }
    }
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>

    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/cart.css">
    
    <script>
        const idUser = <?php echo isset($_SESSION['idUser']) ? json_encode($_SESSION['idUser']) : 'null'; ?>;
    </script>
</head>

<body>
    <div class="wrapper">
    <?php
    include '../includes/header.php';
?>
        <main class="main-payment">
            <div class="main-leftpayment">
                <div class="leftpayment">
                    <h1>Thông tin giao hàng</h1>
                    <hr>
                    <form method="POST" action="">
                        <div class="row">
                            <div id="hang1">
                                <div id="formhoten">
                                    <input placeholder="Họ và tên" type="text" class="form-control" name="ten" required>
                                </div>
                                <div id="formsdt">
                                    <input placeholder="Điện thoại" type="tel" class="form-control" name="dienthoai" required>
                                </div>
                            </div>
                            <div class="form2">
                                <input placeholder="Địa chỉ" type="text" class="form-control" name="diachi" required>
                            </div>
                            <div class="form2">
                                <textarea placeholder="Ghi chú" class="form-control" name="noidung" rows="5"></textarea>
                            </div>
                        </div>
                    
                        <h3>Phương thức thanh toán</h3>
                        <div class="payment-method">                 
                            <div class="method-option">
                                <label>
                                    <div class="payment-status">
                                        <input type="radio" name="payment" value="COD">
                                        <strong>Thanh toán khi giao hàng (COD)</strong>
                                    </div>
                                    <div class="option-content payment-info" id="cod-info">                               
                                        Tất cả đơn hàng được kiểm tra trước khi thanh toán<br>
                                        • Thời gian nhận hàng nội thành: 1h-24h<br>
                                        • Ngoại thành & tỉnh khác: 2-3 ngày<br>
                                        <em>Nếu không hài lòng, chỉ trả phí vận chuyển 45,000đ</em>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="method-option">
                                <label>
                                    <div class="payment-status">
                                        <input type="radio" name="payment" value="BANK">
                                        <strong>Chuyển khoản ngân hàng</strong>
                                    </div>
                                    <div class="option-content payment-info" id="bank-info">
                                        Liên hệ hotline trước khi chuyển khoản : 0971.415.565</br>
                                        Số Tài Khoản : 019704060152822</br>
                                        Ngân hàng Quốc Tế VIB</br>
                                        Chủ tài khoản : ĐÀO VĂN CÔNG</em>
                                    </div>
                                </label>
                            </div>
                        </div>
                    
                </div>
            </div>
            <div class="slidebarpayment">
                <h2 style="text-align: center;">ĐƠN HÀNG CỦA BẠN</h2>
    
                <!-- Header bảng -->
                <div class="order-header">
                    <div class="header-product">Sản phẩm</div>
                    <div class="header-qty">Số lượng</div>
                    <div class="header-price">Tạm tính</div>
                </div>
                <hr>
                <div class="product-all">
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="product-summary">
                                <div class="product-info">
                                    <p class="product-name"><?php echo $item['tenSanPham']; ?></p>
                                </div>
                                <div class="product-qty">x <?php echo $item['soLuong']; ?></div>
                                <div class="product-price"><?php echo number_format($item['thanhTien'], 0, ',', '.'); ?>đ</div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="product-summary">
                            <div class="product-info">
                                <p class="product-name">Không có sản phẩm trong giỏ hàng</p>
                            </div>
                            <div class="product-qty">x 0</div>
                            <div class="product-price">0đ</div>
                        </div>
                    <?php endif; ?>
                </div>
                <hr>
                <div class="price-summary">
                    <div class="total-row">
                        <strong>Tổng cộng</strong>
                        <strong class="total-amount"><?php echo number_format($totalAmount ); ?>đ</strong>
                    </div>
                </div>
                <button type="submit" class="checkout-btn">Đặt hàng</button>
                </form>
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
    <script src="../public/js/payment.js"></script>
</body>
</html>
