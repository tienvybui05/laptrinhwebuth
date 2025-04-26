<?php
session_start();
include_once '../entities/database.php';
include_once '../entities/product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['productId']) || !isset($data['quantity'])) {
        echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
        exit;
    }

    $productId = (int)$data['productId'];
    $quantity = (int)$data['quantity'];

    if ($quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Số lượng không hợp lệ.']);
        exit;
    }

    $product = new product();
    $productInfo = $product->getProductbyId($productId);

    if (!$productInfo) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
        exit;
    }

    // Lưu sản phẩm "Mua ngay" vào session
    $_SESSION['buy_now'] = [
        'idProduct' => $productId,
        'tenSanPham' => $productInfo['tenSanPham'],
        'gia' => $productInfo['gia'],
        'soLuong' => $quantity,
        'thanhTien' => $productInfo['gia'] * $quantity
    ];

    echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được lưu tạm.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
exit;