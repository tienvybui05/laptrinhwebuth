<?php
session_start();
include_once '../admin/entities/orders.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['idUser'])) {
    header('Location: ../auth/login.php');
    exit();
}

$userId = $_SESSION['idUser'];
$orders = new orders();

// Lấy danh sách đơn hàng của người dùng
$result = $orders->getOrdersByUserId($userId);

// Nhóm đơn hàng theo mã tổng đơn hàng
$groupedOrders = [];
while ($row = $orders->getOrdersFetch()) {
    $orderCode = $row['maTongDonHang'];
    if (!isset($groupedOrders[$orderCode])) {
        $groupedOrders[$orderCode] = [
            'orderCode' => $orderCode,
            'orderDate' => $row['ngayDatHang'],
            'totalAmount' => 0,
            'products' => []
        ];
    }
    
    $groupedOrders[$orderCode]['products'][] = [
        'productId' => $row['idProduct'],
        'productName' => $row['tenSanPham'],
        'price' => $row['thanhTien'] / $row['soLuong'], // Giá đơn vị
        'quantity' => $row['soLuong'],
        'subtotal' => $row['thanhTien'],
        'image' => explode(',', $row['hinhAnh'])[0] . '/' . explode(',', $row['hinhAnh'])[1]
    ];
    
    $groupedOrders[$orderCode]['totalAmount'] += $row['thanhTien'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/products.css">
    <link rel="stylesheet" href="../public/css/order-history.css">
</head>
<body>
    <div class="wrapper">
        <!-- Header sẽ được thêm từ layout -->
        
        <main class="main">
            <div class="order-history-container">
                <h1 class="order-history-title">Lịch sử đơn hàng</h1>
                
                <?php if (empty($groupedOrders)): ?>
                <div class="empty-orders">
                    <i class="ti-shopping-cart"></i>
                    <p>Bạn chưa có đơn hàng nào</p>
                    <a href="products.php" class="btn-shop-now">Mua sắm ngay</a>
                </div>
                <?php else: ?>
                    <?php foreach ($groupedOrders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-id">Đơn hàng #<?php echo $order['orderCode']; ?></div>
                            <div class="order-date">Ngày đặt: <?php echo date('d/m/Y', strtotime($order['orderDate'])); ?></div>
                        </div>
                        <div class="order-content">
                            <?php foreach ($order['products'] as $product): ?>
                            <div class="order-product">
                                <img src="../public/images/product/<?php echo $product['image']; ?>" alt="<?php echo $product['productName']; ?>" class="product-image">
                                <div class="product-details">
                                    <div class="product-name"><?php echo $product['productName']; ?></div>
                                    <div class="product-price"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</div>
                                    <div class="product-quantity">Số lượng: <?php echo $product['quantity']; ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="order-footer">
                            <div class="order-total">Tổng tiền: <span class="order-total-value"><?php echo number_format($order['totalAmount'], 0, ',', '.'); ?> đ</span></div>
                            <div class="order-actions">
                                <a href="order-detail.php?code=<?php echo $order['orderCode']; ?>" class="btn-order-detail">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
        
        <!-- Footer sẽ được thêm từ layout -->
    </div>

    <script src="../public/js/order-history.js"></script>
</body>
</html>
