<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    http_response_code(403);
    header("location:../auth/accessDenied.php ");
    exit();
}
include_once 'database.php';
class cart{
    private $data;
    public function __construct()
    {
        $this->data = new database();
    }
    public function getCart($keyword)
    {
       
 $sql = "SELECT user.idUser AS idUser, 
                user.hoTen AS hoTen, 
                cart.idCart AS idCart, 
                cart.idProduct AS idProduct,
                cart.soLuong AS soLuong,
                cart.thanhTien AS thanhTien,
                product.tenSanPham AS tenSanPham
                FROM user
                JOIN cart ON cart.idUser = user.idUser
                JOIN product ON cart.idProduct = product.idProduct
                WHERE user.hoTen LIKE '%$keyword%' ";
        return $this->data->select($sql);
    }
    public function getCartFetch()
    {
        return $this->data->fetch();
    }
}

?>