<?php
include_once 'database.php';
class orders{
    private $data;
    public function __construct()
    {
        $this->data=new database();
    }
    public function getOrders($keyword)
    {
       $sql="SELECT user.idUser AS idUser, user.hoTen AS hoTen, product.idProduct AS idProduct ,product.tenSanPham AS tenSanPham, orders.soLuong,orders.thanhTien,orders.hoTen AS nguoiNhan,orders.soDienThoai,orders.diaChi,orders.ngayDatHang,orders.phuongThuc,orders.ghiChu,orders.idUser
             FROM user JOIN orders ON user.idUser = orders.idUser
	                   JOIN product ON orders.idProduct = product.idProduct
             WHERE user.hoTen LIKE '%$keyword%'";
             return $this->data->select($sql);
    }
    public function getOrdersFetch()
    {
        return $this->data->fetch();
    }
}
?>