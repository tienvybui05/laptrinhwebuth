<?php
include_once 'database.php';

class cart_customer {
    private $data;

    public function __construct() {
        $this->data = new database();
    }

    // Lấy giỏ hàng của một người dùng
    public function getCartByUser($idUser) {
        $sql = "SELECT * FROM cart WHERE idUser = '$idUser'";
        return $this->data->select($sql);
    }

    // Lấy sản phẩm cụ thể trong giỏ hàng
    public function getCartItem($idUser, $idProduct) {
        $sql = "SELECT * FROM cart WHERE idUser = '$idUser' AND idProduct = '$idProduct'";
        $result = $this->data->select($sql);
    
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    
        return null;
    }
    

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($idUser, $idProduct, $soLuong) {
        $sql = "INSERT INTO cart (idUser, idProduct, soLuong) VALUES ('$idUser', '$idProduct', '$soLuong')";
        return $this->data->insert($sql);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart($idUser, $idProduct, $soLuong) {
        $sql = "UPDATE cart SET soLuong = '$soLuong' WHERE idUser = '$idUser' AND idProduct = '$idProduct'";
        return $this->data->update($sql);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCartItem($idUser, $idProduct) {
        $sql = "DELETE FROM cart WHERE idUser = '$idUser' AND idProduct = '$idProduct'";
        return $this->data->delete($sql);
    }

    // Xóa toàn bộ giỏ hàng của người dùng (tuỳ chọn)
    public function clearCart($idUser) {
        $sql = "DELETE FROM cart WHERE idUser = '$idUser'";
        return $this->data->delete($sql);
    }
}
?>
