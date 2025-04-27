<?php
session_start();
include '../../admin/entities/orders.php';

$data = json_decode(file_get_contents("php://input"), true);

// Debug: Kiểm tra xem idUser có trong session không
error_log('idUser từ session: ' . (isset($_SESSION['idUser']) ? $_SESSION['idUser'] : 'null'));
error_log('Dữ liệu gửi lên từ client: ' . json_encode($data));

if (!isset($_SESSION['idUser'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập']);
    exit;
}

$idUser = $data['idUser'] ?? ($_SESSION['idUser'] ?? null);
error_log('idUser: ' . $idUser);

if (!$idUser) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy người dùng']);
    exit;
}

$order = new orders();
$success = $order->addCartToOrder($idUser); // Hàm này tự xử lý giỏ hàng sang đơn

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không thể thêm đơn hàng']);
}
?>
