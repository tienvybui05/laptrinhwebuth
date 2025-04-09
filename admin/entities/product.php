<?php
include 'database.php';
class product{
    private $data;
    public function __construct()
    {
        $this->data=new database();
    }
    public function getProduct($keyword)
    {
        $sql="SELECT * FROM  product WHERE tensanpham like '%$keyword%' ORDER BY idProduct DESC";
        return $this->data->select($sql);
    }
    public function getProductFetch()
    {
        return $this->data->fetch();
    }
    public function addProduct($tenSanPham,$thuongHieu, $khuyenMai,$gia,$moTa,$trongLuong,$tonKho,$doCung,$diemCanBang,$anh,$trinhDo)
    {
      $sql ="INSERT INTO product(tenSanPham,thuongHieu,khuyenMai,gia,moTa,trongLuong,tonKho,doCung,diemCanBang,hinhAnh,trinhDo)
             VALUES ('$tenSanPham','$thuongHieu', '$khuyenMai','$gia','$moTa','$trongLuong','$tonKho','$doCung','$diemCanBang','$anh','$trinhDo')";
        return $this->data->insert($sql);
    }
}
?>