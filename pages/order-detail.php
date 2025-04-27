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
    <title>Chi tiết đơn hàng #<?php echo $orderInfo['orderCode']; ?></title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/products.css">
    <link rel="stylesheet" href="../public/css/order-detail.css">
    <link rel="stylesheet" href="../public/css/cart.css">

</head>
<body>
    <div class="wrapper">
        <!-- Header sẽ được, thêm từ layout -->
         <?php
    include '../includes/header.php';
?>
        
        <main class="main">
            <div class="order-detail-container">
                <a href="order-history.php" class="back-to-orders">
                    <i class="ti-arrow-left"></i> Quay lại lịch sử đơn hàng
                </a>
                
                <div class="order-detail-header">
                    <div class="order-detail-id">Chi tiết đơn hàng #<?php echo $orderInfo['orderCode']; ?></div>
                    <div class="order-detail-date">Ngày đặt: <?php echo date('d/m/Y', strtotime($orderInfo['orderDate'])); ?></div>
                </div>
                
                <!-- Thông tin khách hàng -->
                <div class="order-detail-section">
                    <div class="section-header">
                        Thông tin khách hàng
                    </div>
                    <div class="section-content">
                        <div class="customer-info">
                            <div>
                                <div class="info-group">
                                    <div class="info-label">Họ tên:</div>
                                    <div class="info-value"><?php echo $orderInfo['customerName']; ?></div>
                                </div>
                                <div class="info-group">
                                    <div class="info-label">Số điện thoại:</div>
                                    <div class="info-value"><?php echo $orderInfo['customerPhone']; ?></div>
                                </div>
                            </div>
                            <div>
                                <div class="info-group">
                                    <div class="info-label">Địa chỉ giao hàng:</div>
                                    <div class="info-value"><?php echo $orderInfo['customerAddress']; ?></div>
                                </div>
                                <div class="info-group">
                                    <div class="info-label">Phương thức thanh toán:</div>
                                    <div class="info-value"><?php echo $orderInfo['paymentMethod']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Chi tiết sản phẩm -->
                <div class="order-detail-section">
                    <div class="section-header">
                        Chi tiết sản phẩm
                    </div>
                    <div class="section-content">
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
                                            <img src="../public/images/product/<?php echo $product['image']; ?>" alt="<?php echo $product['productName']; ?>">
                                            <div class="product-name-cell"><?php echo $product['productName']; ?></div>
                                        </div>
                                    </td>
                                    <td class="product-price-cell"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td class="product-price-cell"><?php echo number_format($product['subtotal'], 0, ',', '.'); ?> đ</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Tổng kết đơn hàng -->
                <div class="order-detail-section">
                    <div class="section-header">
                        Tổng kết đơn hàng
                    </div>
                    <div class="section-content">
                        <table class="summary-table">
                            <tr>
                                <td class="summary-label">Tổng tiền sản phẩm:</td>
                                <td class="summary-value"><?php echo number_format($totalAmount, 0, ',', '.'); ?> đ</td>
                            </tr>
                            <tr>
                                <td class="summary-label">Phí vận chuyển:</td>
                                <td class="summary-value">0 đ</td>
                            </tr>
                            <tr>
                                <td class="summary-label">Giảm giá:</td>
                                <td class="summary-value">0 đ</td>
                            </tr>
                            <tr class="total-row">
                                <td class="summary-label">Tổng thanh toán:</td>
                                <td class="summary-value"><?php echo number_format($totalAmount, 0, ',', '.'); ?> đ</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Ghi chú đơn hàng -->
                <?php if (!empty($orderInfo['orderNote'])): ?>
                <div class="order-detail-section">
                    <div class="section-header">
                        Ghi chú đơn hàng
                    </div>
                    <div class="section-content">
                        <div class="info-value"><?php echo $orderInfo['orderNote']; ?></div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Nút thao tác -->
                <div class="order-actions-container">
                    <button class="btn-contact-support">
                        <i class="ti-headphone-alt"></i> Liên hệ hỗ trợ
                    </button>
                    <button class="btn-print-order" onclick="window.print();">
                        <i class="ti-printer"></i> In đơn hàng
                    </button>
                </div>
            </div>
        </main>
        
        <!-- Footer sẽ được thêm từ layout -->
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
    
    <script src="../public/js/main.js"></script>
    <script src="../public/js/cart.js"></script>
    

    <script src="../public/js/order-detail.js"></script>
</body>
</html>
