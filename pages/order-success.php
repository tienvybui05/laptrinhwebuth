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
    <style>
        .success-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .success-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .success-header i {
            font-size: 60px;
            color: #4CAF50;
            display: block;
            margin-bottom: 20px;
        }
        
        .success-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .success-header p {
            font-size: 16px;
            color: #666;
        }
        
        .order-details {
            margin-top: 30px;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 20px;
        }
        
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .order-info-column {
            flex: 1;
        }
        
        .order-info-column h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .order-info-column p {
            margin: 5px 0;
            color: #666;
        }
        
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .product-table th {
            text-align: left;
            padding: 10px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #eee;
        }
        
        .product-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .product-info {
            display: flex;
            align-items: center;
        }
        
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 4px;
        }
        
        .product-name {
            font-weight: 500;
        }
        
        .order-summary {
            margin-top: 20px;
            text-align: right;
        }
        
        .summary-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        
        .summary-label {
            width: 150px;
            text-align: left;
            color: #666;
        }
        
        .summary-value {
            width: 120px;
            text-align: right;
            font-weight: 500;
        }
        
        .total-row {
            font-size: 18px;
            font-weight: 600;
            color: #e74c3c;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: #000;
            color: #fff;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #333;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #333;
            border: 1px solid #333;
        }
        
        .btn-outline:hover {
            background-color: #f5f5f5;
        }
        
        @media print {
            .action-buttons, header, footer {
                display: none;
            }
            
            body {
                background-color: #fff;
            }
            
            .success-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <!--Thanh menu  -->
                <nav class="navbar">
                    <a href="../public/index.php" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <ul id="main-menu">
                        <li><a href="../public/index.php">Trang chủ</a></li>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="news.php">Tin tức</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                    <!--Thanh tìm kiếm  -->
                    <div class="search-bar">
                        <input type="text" placeholder="Tìm kiếm..." />
                        <button type="submit"><i class="ti-search"></i></button>
                    </div>
                    <div class="right-icons">
                        <a href="cart.php" class="cart-icon"><i class="ti-shopping-cart"></i></a>
                        <div class="user-menu">
                            <a href="#" class="user-icon"><i class="ti-user"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php"><i class="ti-user"></i> Thông tin người dùng</a></li>
                                <li><a href="order-history.php"><i class="ti-package"></i> Đơn hàng của tôi</a></li>
                                <li><a href="logout.php"><i class="ti-power-off"></i> Đăng xuất</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        
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
        
        <footer class="footer">
            <div class="container">
                <div class="footer-left">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <h3>Thông tin liên hệ</h3>
                    <p>Địa chỉ: 123 đường ABC, TP.HCM</p>
                    <p>Email: info@example.com</p>
                </div>
                <div class="footer-center">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="../public/index.php">Trang chủ</a></li>
                        <li><a href="about.php">Giới thiệu</a></li>
                        <li><a href="products.php">Sản phẩm</a></li>
                        <li><a href="news.php">Tin tức</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-right">
                    <h3>Theo dõi chúng tôi</h3>
                    <ul>
                        <li><a href="#"><i class="ti-facebook"></i>Facebook</a></li>
                        <li><a href="#"><i class="ti-twitter"></i>Twitter</a></li>
                        <li><a href="#"><i class="ti-instagram"></i>Instagram</a></li>
                        <li><a href="#"><i class="ti-linkedin"></i>Linkedin</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
