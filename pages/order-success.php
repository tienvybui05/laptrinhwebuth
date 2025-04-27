<?php
session_start();
include_once '../admin/entities/orders.php';
include_once '../admin/entities/product.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['idUser'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['idUser'];
$orderCode = isset($_GET['code']) ? $_GET['code'] : '';

if (empty($orderCode)) {
    header('Location: order-history.php');
    exit();
}

$orders = new orders();
$product = new product();

// Lấy thông tin đơn hàng
$orderDetails = $orders->getOrderById($orderCode, $userId);

if (!$orderDetails) {
    header('Location: order-history.php');
    exit();
}

// Nhóm sản phẩm trong đơn hàng
$orderProducts = [];
$orderInfo = null;
$totalAmount = 0;

while ($row = $orders->getOrdersFetch()) {
    if (!$orderInfo) {
        $orderInfo = [
            'orderCode' => $row['maTongDonHang'],
            'orderDate' => $row['ngayDatHang'],
            'customerName' => $row['hoTen'],
            'customerPhone' => $row['soDienThoai'],
            'customerAddress' => $row['diaChi'],
            'paymentMethod' => $row['phuongThuc'],
            'orderNote' => $row['ghiChu']
        ];
    }
    
    $orderProducts[] = [
        'productId' => $row['idProduct'],
        'productName' => $row['tenSanPham'],
        'price' => $row['thanhTien'] / $row['soLuong'], // Giá đơn vị
        'quantity' => $row['soLuong'],
        'subtotal' => $row['thanhTien'],
        'image' => explode(',', $row['hinhAnh'])[0] . '/' . explode(',', $row['hinhAnh'])[1]
    ];
    
    $totalAmount += $row['thanhTien'];
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/cart.css">
    
</head>
<body>
    <div class="wrapper">
    <?php
    include '../includes/header.php';
?>
        
        <main class="main">
            <div class="success-container">
                <div class="success-header">
                    <i class="ti-check-box"></i>
                    <h1>Đặt hàng thành công!</h1>
                    <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xác nhận.</p>
                </div>
                
                <div class="order-details">
                    <div class="order-info">
                        <div class="order-info-column">
                            <h3>Thông tin đơn hàng</h3>
                            <p><strong>Mã đơn hàng:</strong> #<?php echo $orderInfo['orderCode']; ?></p>
                            <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($orderInfo['orderDate'])); ?></p>
                           
                            <p><strong>Phương thức thanh toán:</strong> <?php echo $orderInfo['paymentMethod'] === 'COD' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng'; ?></p>
                        </div>
                        <div class="order-info-column">
                            <h3>Thông tin giao hàng</h3>
                            <p><strong>Họ tên:</strong> <?php echo $orderInfo['customerName']; ?></p>
                            <p><strong>Số điện thoại:</strong> <?php echo $orderInfo['customerPhone']; ?></p>
                            <p><strong>Địa chỉ:</strong> <?php echo $orderInfo['customerAddress']; ?></p>
                            <?php if (!empty($orderInfo['orderNote'])): ?>
                            <p><strong>Ghi chú:</strong> <?php echo $orderInfo['orderNote']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <h3>Chi tiết sản phẩm</h3>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderProducts as $product): ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <img src="../public/images/product/<?php echo $product['image']; ?>" alt="<?php echo $product['productName']; ?>" class="product-image">
                                        <span class="product-name"><?php echo $product['productName']; ?></span>
                                    </div>
                                </td>
                                <td><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td><?php echo number_format($product['subtotal'], 0, ',', '.'); ?> đ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <div class="order-summary">
                        <div class="summary-row">
                            <div class="summary-label">Tạm tính:</div>
                            <div class="summary-value"><?php echo number_format($totalAmount, 0, ',', '.'); ?> đ</div>
                        </div>
                        
                        <div class="summary-row total-row">
                            <div class="summary-label">Tổng cộng:</div>
                            <div class="summary-value"><?php echo number_format($totalAmount); ?> đ</div>
                        </div>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="../public/index.php" class="btn btn-outline">Tiếp tục mua sắm</a>
                    <button onclick="window.print()" class="btn btn-primary">In hóa đơn</button>
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
    </div>
</body>
</html>
