<?php
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
                product.tenSanPham AS tenSanPham,
                product.hinhAnh AS hinhAnh,
                product.thuongHieu AS thuongHieu
                product.gia AS gia
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
    public function getPaginatedCartOfAdmin($currentPage,$cartPerpage,$keyword,$thuongHieu)
    {
        $offset = ($currentPage - 1) * $cartPerpage;

        // Lấy tổng số sản phẩm
        if($thuongHieu=="tatca") 
        {
            $sqlTotal = "SELECT COUNT(*) as total FROM user
                                                  JOIN cart ON cart.idUser = user.idUser
                                                  JOIN product ON cart.idProduct = product.idProduct 
                                                  WHERE product.tenSanPham LIKE '%$keyword%'";
        } else 
        {
            $sqlTotal = "SELECT COUNT(*) as total FROM user
                                                  JOIN cart ON cart.idUser = user.idUser
                                                  JOIN product ON cart.idProduct = product.idProduct 
                                                  WHERE product.thuongHieu = '$thuongHieu' AND product.tenSanPham LIKE '%$keyword%'";
        }
        $resultTotal = $this->data->select($sqlTotal);
        $totalCart = 0;
        if ($row = $resultTotal->fetch_assoc()) 
        {
            $totalCart = $row['total'];
        }

        // Tính tổng số trang
        $totalPages = ceil($totalCart / $cartPerpage);

        if($thuongHieu=="tatca") 
        {
            $sql = "SELECT user.idUser AS idUser, 
                    user.hoTen AS hoTen, 
                    cart.idCart AS idCart, 
                    cart.idProduct AS idProduct,
                    cart.soLuong AS soLuong,
                    cart.thanhTien AS thanhTien,
                    product.tenSanPham AS tenSanPham,
                    product.hinhAnh AS hinhAnh,
                    product.thuongHieu AS thuongHieu,
                    product.gia AS gia
                    FROM user
                    JOIN cart ON cart.idUser = user.idUser
                    JOIN product ON cart.idProduct = product.idProduct
                    WHERE product.tenSanPham LIKE '%$keyword%' ORDER BY cart.idCart ASC LIMIT $offset, $cartPerpage";
        } 
        else 
        {
            $sql = "SELECT user.idUser AS idUser, 
                    user.hoTen AS hoTen, 
                    cart.idCart AS idCart, 
                    cart.idProduct AS idProduct,
                    cart.soLuong AS soLuong,
                    cart.thanhTien AS thanhTien,
                    product.tenSanPham AS tenSanPham,
                    product.hinhAnh AS hinhAnh,
                    product.thuongHieu AS thuongHieu,
                    product.gia AS gia
                    FROM user
                    JOIN cart ON cart.idUser = user.idUser
                    JOIN product ON cart.idProduct = product.idProduct
                    WHERE product.thuongHieu = '$thuongHieu' AND product.tenSanPham LIKE '%$keyword%' ORDER BY cart.idCart ASC LIMIT $offset, $cartPerpage";
        }
        $resultCart = $this->data->select($sql);

        $carts = [];
        while ($row = $resultCart->fetch_assoc()) {
            $carts[] = $row;
        }

        return [$carts, $totalPages];
    } 
}

?>