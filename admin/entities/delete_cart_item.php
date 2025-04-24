<?php
session_start();
include_once("../entities/cart-customer.php");

header('Content-Type: application/json');

$response = ["status" => "error", "message" => "Lỗi không xác định"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idUser = $_POST["idUser"] ?? null;
    $idProduct = $_POST["idProduct"] ?? null;

    if ($idUser && $idProduct) {
        $cart = new cart_customer(); // sử dụng class bạn đã viết

        $deleted = $cart->deleteCartItem($idUser, $idProduct);

        if ($deleted) {
            $response["status"] = "success";
            $response["message"] = "Đã xóa sản phẩm khỏi giỏ hàng";
        } else {
            $response["message"] = "Xóa thất bại trong database";
        }
    } else {
        $response["message"] = "Thiếu tham số idUser hoặc idProduct";
    }
}

echo json_encode($response);
