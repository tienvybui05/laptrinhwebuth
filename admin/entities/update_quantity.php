<?php
session_start();
include_once '../entities/cart-customer.php';

if (isset($_POST['idProduct']) && isset($_POST['quantity'])) {
    $idUser = $_SESSION['idUser'];
    $idProduct = $_POST['idProduct'];
    $quantity = $_POST['quantity'];

    $cart = new cart_customer();
    $success = $cart->updateQuantity($idUser, $idProduct, $quantity);

    if ($success) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không thể cập nhật giỏ hàng']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu']);
}
?>
