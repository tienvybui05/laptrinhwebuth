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

// Lấy thông tin giỏ hàng
$result = $cart->getCartByUser($idUser);

// Tính tổng tiền
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
    
    // Chuẩn bị dữ liệu sản phẩm
    $products = [];
    foreach ($cartItems as $item) {
        $products[] = [
            'idProduct' => $item['idProduct'],
            'soLuong' => $item['soLuong'],
            'thanhTien' => $item['thanhTien']
        ];
    }
    
    // Tạo đơn hàng
    $orderCode = $orders->createOrder($idUser, $products, $hoTen, $soDienThoai, $diaChi, $phuongThuc, $ghiChu);
    
    if ($orderCode) {
        // Xóa giỏ hàng sau khi đặt hàng thành công
        $cart->clearCart($idUser);
        
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
    <style>
        .main-payment {
            width: auto;
            min-height: calc(100vh - 120px);
            display: flex;
        }
        .main-leftpayment{
            width: 50%;
            padding: 30px 30px 30px 150px;
            background-color: #F4F4F4;
        }
        .leftpayment h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .signup-link {
            margin: 10px 0 20px;
            font-size: 14px;
        }

        .signup-link a {
            color: #e74c3c;
            text-decoration: none;
        }

        .slidebarpayment{
            width: 40%;
            padding: 20px;
            background-color: #ececec;
            border-left: 1px solid #ddd;
            padding-right: 10%;
            padding-left: 40px;
        }
        .row{
            box-sizing: border-box;
        }
        /* Định dạng input và textarea */
        .row input,
        .row textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            box-sizing: border-box;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: white;
        }

        .row input:focus,
        .row textarea:focus {
            border-color: #050505;
            outline: none;
        }

        #hang1{
            display: flex;
            justify-content: space-between;
        }
        #formhoten{
            margin-right: 0px;
            width: 65%;
        }
        #formsdt{
            width: 32%;
        }

        /* phuong thuc thanh toan */
        .payment-method {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: white;
            margin-bottom: 20px;
        }
        .payment-status{
            padding: 20px;
            border: 1px solid #e0e0e0;
        }
        .option-content{
            color: #555;
            background-color: #F4F4F4;
            padding: 20px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }
        .method-option label {
            display: block;
            cursor: pointer;
        }

        /* Phần sản phẩm trong đơn hàng */
        .payment-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        /* Phần tổng tiền */
        .totalpayment-item {
            margin: 20px 0;
        }
        .totalpayment-item h3 {
            color: #e74c3c;
            font-size: 1.2rem;
        }

        /* Nút thanh toán */
        .checkout-btn {
            width: 100%;
            padding: 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .slidebarpayment h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        .price-summary {
            margin: 25px 0;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 15px;
            color: #555;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            font-size: 16px;
        }

        .total-amount {
            color: #e74c3c;
            font-size: 18px;
        }

        .checkout-btn {
            width: 100%;
            padding: 14px;
            background: #000000;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: #242424;
            color: rgb(255, 255, 255);
        }

        /* Header đơn hàng */
        .product-name {
            font-size: 15px;
            color: #333;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .product-price {
            font-weight: 500;
            color: #333;
            width: 100px;
            text-align: right;
        }

        .order-header {
            display: flex;
            padding: 10px 0;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }

        .header-product {
            flex: 2;
            padding-right: 15px;
        }

        .header-qty {
            width: 80px;
            text-align: center;
        }

        .header-price {
            width: 100px;
            text-align: right;
        }

        /* Điều chỉnh lại product-summary */
        .product-summary {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
        }

        .product-info {
            flex: 2;
            padding-right: 15px;
        }

        .product-qty {
            width: 80px;
            text-align: center;
            color: #666;
        }
        
        .payment-info {
            display: none;
        }
        
        .payment-info.active {
            display: block;
        }
    </style>
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
                    <div class="signup-link">
                        Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a>
                    </div>
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
                            <?php $listImage = explode(',', $item['hinhAnh']); ?>
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
