<?php
session_start();
include_once '../../admin/entities/orders.php';

header('Content-Type: application/json');

if (!isset($_SESSION['idUser'])) {
    echo json_encode(['success' => false, 'message' => 'Người dùng chưa đăng nhập']);
    exit;
}

$idUser = $_SESSION['idUser'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['order']) || !is_array($data['order'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu giỏ hàng không hợp lệ']);
    exit;
}

$order = new orders();
$errors = [];

foreach ($data['order'] as $item) {
    $idProduct = $item['id'] ?? null;
    $soLuong = (int)($item['quantity'] ?? 0);
    $priceStr = $item['price'] ?? '0';
    $priceStr = str_replace(['.', 'đ', ' '], '', $priceStr);
    $donGia = (float)$priceStr;
    $thanhTien = $soLuong * $donGia;

    if (!$idProduct || $soLuong <= 0) {
        $errors[] = "Dữ liệu không hợp lệ cho sản phẩm";
        continue;
    }

    $success = $order->addToOrder($idUser, $idProduct, $soLuong, $thanhTien);
    if (!$success) {
        $errors[] = "Lỗi khi lưu sản phẩm ID $idProduct";
    }
}

if (empty($errors)) {
    echo json_encode(['success' => true, 'message' => 'Đơn hàng đã được lưu']);
} else {
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra', 'errors' => $errors]);
}
