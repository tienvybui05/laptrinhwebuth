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
    public function getProductbyId($id)
    {
        $sql = "SELECT * FROM product WHERE idProduct = '$id'";
        $result =  $this->data->select($sql);
        return $this->data->fetch();
    }
    public function addProduct($tenSanPham,$thuongHieu, $khuyenMai,$gia,$moTa,$trongLuong,$tonKho,$doCung,$diemCanBang,$anh,$trinhDo)
    {
      $sql ="INSERT INTO product(tenSanPham,thuongHieu,khuyenMai,gia,moTa,trongLuong,tonKho,doCung,diemCanBang,hinhAnh,trinhDo)
             VALUES ('$tenSanPham','$thuongHieu', '$khuyenMai','$gia','$moTa','$trongLuong','$tonKho','$doCung','$diemCanBang','$anh','$trinhDo')";
        return $this->data->insert($sql);
    }
    public function updateProduct($id,$tenSanPham,$thuongHieu, $khuyenMai,$gia,$moTa,$trongLuong,$tonKho,$doCung,$diemCanBang,$anh,$trinhDo)
    {
        $sql ="UPDATE product SET tenSanPham    = '$tenSanPham', 
                                  thuongHieu    = '$thuongHieu',
                                  khuyenMai     = '$khuyenMai',
                                  gia           = '$gia',
                                  moTa          = '$moTa',
                                  trongLuong    = '$trongLuong',
                                  tonKho        = '$tonKho',
                                  doCung        = '$doCung',
                                  diemCanBang   = '$diemCanBang',
                                  hinhAnh       = '$anh',
                                  trinhDo       = '$trinhDo'
                                  WHERE idProduct = '$id'";
        return $this->data->update($sql);

    }
    public function deleteProduct($id)
    {
        $sql= "DELETE FROM product WHERE idProduct = '$id'";
        return $this->data->delete($sql);
    }
}
?>