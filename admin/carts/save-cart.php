<?php
session_start();
include_once '../entities/cart-customer.php';

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['idUser'])) {
    echo json_encode(['success' => false, 'message' => 'Người dùng chưa đăng nhập']);
    exit;
}

$idUser = $_SESSION['idUser'];

// Nhận dữ liệu JSON
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra dữ liệu cart
if (!isset($data['cart']) || !is_array($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu giỏ hàng không hợp lệ']);
    exit;
}

$cart = new cart_customer();
$errors = [];

foreach ($data['cart'] as $item) {
    $idProduct = $item['id'] ?? null;
    $soLuong = (int) ($item['quantity'] ?? 0);

    if (!$idProduct) {
        $errors[] = "Thiếu ID sản phẩm";
        continue;
    }

    $existingItem = $cart->getCartItem($idUser, $idProduct);

    if ($existingItem) {
        if ($soLuong > 0) {
            $cart->updateCart($idUser, $idProduct, $soLuong);
        } else {
            $cart->deleteCartItem($idUser, $idProduct);
        }
    } else {
        if ($soLuong > 0) {
            $cart->addToCart($idUser, $idProduct, $soLuong);
        }
    }
}

if (empty($errors)) {
    echo json_encode(['success' => true, 'message' => 'Giỏ hàng đã được lưu']);
} else {
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra', 'errors' => $errors]);
}
?>