<?php
include_once '../../admin/entities/cart-customer.php'; // chỉnh lại đúng đường dẫn class nếu khác

header('Content-Type: application/json');
session_start();

$idUser = $_GET['idUser'] ?? ($_SESSION['idUser'] ?? null);

if (!$idUser) {
    echo json_encode(['success' => false, 'message' => 'Không có ID người dùng']);
    exit;
}

$cart = new cart_customer();
$cartItems = $cart->getCartByUser($idUser);

// Format lại dữ liệu trả ra
$cartFormatted = [];
foreach ($cartItems as $item) {
    $images = explode(',', $item['hinhAnh']); // nếu có nhiều ảnh, lấy cái đầu
    $cartFormatted[] = [
        'id' => $item['idProduct'],
        'name' => $item['tenSanPham'],
        'price' => number_format($item['gia'], 0, ',', '.') . 'đ',
        'quantity' => (int)$item['soLuong'],
        'image' => '../public/images/product/' . $images[0] . '/' . ($images[1] ?? '') // chỉnh đường dẫn nếu cần
    ];
}




echo json_encode(['success' => true, 'cart' => $cartFormatted]);
