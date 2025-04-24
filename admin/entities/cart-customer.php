<?php
include_once 'database.php';
class cart_customer {
    private $data;

    public function __construct() {
        $this->data = new database();
    }

    // Lấy giỏ hàng của một người dùng
    public function getCartByUser($idUser) {
        $sql = "SELECT cart.*, product.tenSanPham, product.gia, product.hinhAnh
                FROM cart 
                JOIN product ON cart.idProduct = product.idProduct
                WHERE cart.idUser = '$idUser'";
        return $this->data->select($sql);
    }

    // Lấy sản phẩm cụ thể trong giỏ hàng
    public function getCartItem($idUser, $idProduct) {
        $sql = "SELECT * 
                FROM cart 
                JOIN product ON cart.idProduct = product.idProduct
                WHERE cart.idUser = '$idUser' AND cart.idProduct = '$idProduct'";
        $result = $this->data->select($sql);
    
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    
        return null;
    }
    

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($idUser, $idProduct, $soLuong, $thanhTien) {
        $sql = "INSERT INTO cart (idUser, idProduct, soLuong, thanhTien) VALUES ('$idUser', '$idProduct', '$soLuong', '$thanhTien')";
        return $this->data->insert($sql);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart($idUser, $idProduct, $soLuong, $thanhTien) {
        $sql = "UPDATE cart SET soLuong = '$soLuong', thanhTien = '$thanhTien' WHERE idUser = '$idUser' AND idProduct = '$idProduct'";
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

    public function updateQuantity($idUser, $idProduct, $quantity) {
        // Lấy thông tin sản phẩm để tính thành tiền
        $sql = "SELECT product.gia FROM product WHERE idProduct = '$idProduct'";
        $result = $this->data->select($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $gia = $row['gia'];
            $thanhTien = $quantity * $gia;
        
            // Cập nhật số lượng và thành tiền
            $updateSql = "UPDATE cart SET soLuong = '$quantity', thanhTien = '$thanhTien' 
                      WHERE idUser = '$idUser' AND idProduct = '$idProduct'";
            return $this->data->update($updateSql);
        }
    
        return false;
    }
}
?>
