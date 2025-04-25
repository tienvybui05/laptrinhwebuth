<?php
include_once 'database.php';
class orders {
    private $data;
    private $cachedResults = null; // Thêm biến để lưu trữ kết quả
    
    public function __construct() {
        $this->data = new database();
    }
    
    /**
     * Tạo mã đơn hàng duy nhất theo phương pháp 2
     * Format: DH + User ID (5 chữ số) + Timestamp
     */
    public function generateOrderCode($userId) {
        $prefix = 'DH';
        $userPart = str_pad($userId, 5, '0', STR_PAD_LEFT); // Đảm bảo ID người dùng luôn có 5 chữ số
        $timestamp = date('YmdHis'); // Định dạng: năm tháng ngày giờ phút giây
        
        return $prefix . $userPart . $timestamp;
    }
<<<<<<< HEAD


    // Thêm sản phẩm vào giỏ hàng
    public function addToOrder($idUser, $idProduct, $soLuong, $thanhTien) {
    $sql = "INSERT INTO orders (idUser, idProduct, soLuong, thanhTien, ngayDatHang) 
            VALUES ('$idUser', '$idProduct', '$soLuong', '$thanhTien', NOW())";
    return $this->data->insert($sql);
}

    public function getOrdersFetch()
    {
        return $this->data->fetch();
=======
    
    /**
     * Lấy thông tin đơn hàng theo mã đơn hàng
     * @param string $orderCode Mã đơn hàng
     * @param int|null $userId ID người dùng (để kiểm tra quyền truy cập)
     * @return bool Có tìm thấy đơn hàng không
     */
    public function getOrderById($orderCode, $userId = null) {
        if ($userId !== null) {
            $sql = "SELECT o.idOrder, o.idUser, o.idProduct, o.soLuong, o.thanhTien, o.hoTen, o.soDienThoai, o.diaChi, 
                    o.ngayDatHang, o.phuongThuc, o.ghiChu, o.maTongDonHang, p.tenSanPham, p.hinhAnh
                    FROM orders o
                    JOIN product p ON o.idProduct = p.idProduct
                    WHERE o.maTongDonHang = '$orderCode' AND o.idUser = $userId";
        } else {
            $sql = "SELECT o.idOrder, o.idUser, o.idProduct, o.soLuong, o.thanhTien, o.hoTen, o.soDienThoai, o.diaChi, 
                    o.ngayDatHang, o.phuongThuc, o.ghiChu, o.maTongDonHang, p.tenSanPham, p.hinhAnh
                    FROM orders o
                    JOIN product p ON o.idProduct = p.idProduct
                    WHERE o.maTongDonHang = '$orderCode'";
        }
        
        $result = $this->data->select($sql);
        
        // Lưu trữ tất cả các kết quả vào mảng để sử dụng sau này
        $this->cachedResults = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->cachedResults[] = $row;
            }
            return true;
        }
        
        return false;
    }
    
    /**
     * Lấy danh sách đơn hàng của người dùng
     * @param int $userId ID người dùng
     * @return bool Trạng thái thành công
     */
    public function getOrdersByUserId($userId) {
        // Lấy danh sách mã đơn hàng duy nhất của người dùng
        $sql = "SELECT DISTINCT maTongDonHang, ngayDatHang
                FROM orders
                WHERE idUser = $userId
                ORDER BY ngayDatHang DESC";
        
        $result = $this->data->select($sql);
        
        if (!$result || $result->num_rows == 0) {
            return false;
        }
        
        $orderCodes = [];
        while ($row = $result->fetch_assoc()) {
            $orderCodes[] = $row['maTongDonHang'];
        }
        
        // Lấy thông tin chi tiết cho mỗi đơn hàng
        $allOrders = [];
        foreach ($orderCodes as $code) {
            $sql = "SELECT o.idOrder, o.idUser, o.idProduct, o.soLuong, o.thanhTien, o.hoTen, o.soDienThoai, o.diaChi, 
                    o.ngayDatHang, o.phuongThuc, o.ghiChu, o.maTongDonHang, p.tenSanPham, p.hinhAnh
                    FROM orders o
                    JOIN product p ON o.idProduct = p.idProduct
                    WHERE o.maTongDonHang = '$code' AND o.idUser = $userId";
            
            $orderItems = $this->data->select($sql);
            
            while ($item = $orderItems->fetch_assoc()) {
                $allOrders[] = $item;
            }
        }
        
        // Lưu kết quả vào biến cachedResults để sử dụng với getOrdersFetch()
        $this->cachedResults = $allOrders;
        
        return count($allOrders) > 0;
    }
    
    /**
     * Lấy thông tin chi tiết đơn hàng
     * @return array|false Thông tin đơn hàng hoặc false nếu không có
     */
    public function getOrdersFetch() {
        if (empty($this->cachedResults)) {
            return false;
        }
        
        $result = array_shift($this->cachedResults);
        return $result;
    }
    
   
    public function createOrder($userId, $products, $hoTen, $soDienThoai, $diaChi, $phuongThuc, $ghiChu = '') {
        // Tạo mã đơn hàng duy nhất
        $orderCode = $this->generateOrderCode($userId);
        $success = true;
        
        // Thêm từng sản phẩm vào đơn hàng
        foreach ($products as $product) {
            $sql = "INSERT INTO orders (idUser, idProduct, soLuong, thanhTien, hoTen, soDienThoai, diaChi, ngayDatHang, phuongThuc, ghiChu, maTongDonHang) 
                   VALUES ($userId, {$product['idProduct']}, {$product['soLuong']}, {$product['thanhTien']}, 
                          '$hoTen', '$soDienThoai', '$diaChi', NOW(), '$phuongThuc', '$ghiChu', '$orderCode')";
            
            $result = $this->data->insert($sql);
            if (!$result) {
                $success = false;
                break;
            }
        }
        
        return $success ? $orderCode : false;
    }
    
    /**
     * Lấy tất cả đơn hàng (dành cho admin)
     * @param string $keyword Từ khóa tìm kiếm
     * @return bool Trạng thái thành công
     */
    public function getOrders($keyword = '') {
        $keyword = "%$keyword%";
        
        // Lấy danh sách mã đơn hàng duy nhất
        $sql = "SELECT DISTINCT o.maTongDonHang, o.ngayDatHang, u.hoTen AS tenKhachHang, o.hoTen AS nguoiNhan, 
                o.soDienThoai, o.diaChi, o.phuongThuc, o.ghiChu
                FROM orders o
                JOIN user u ON o.idUser = u.idUser
                WHERE u.hoTen LIKE '$keyword' OR o.hoTen LIKE '$keyword' OR o.maTongDonHang LIKE '$keyword'
                ORDER BY o.ngayDatHang DESC";
        
        $result = $this->data->select($sql);
        
        if (!$result || $result->num_rows == 0) {
            return false;
        }
        
        $orderCodes = [];
        while ($row = $result->fetch_assoc()) {
            $orderCodes[] = $row['maTongDonHang'];
        }
        
        // Lấy thông tin chi tiết cho mỗi đơn hàng
        $allOrders = [];
        foreach ($orderCodes as $code) {
            $sql = "SELECT o.idOrder, o.idUser, o.idProduct, o.soLuong, o.thanhTien, o.hoTen, o.soDienThoai, o.diaChi, 
                    o.ngayDatHang, o.phuongThuc, o.ghiChu, o.maTongDonHang, p.tenSanPham, p.hinhAnh, u.hoTen AS tenKhachHang
                    FROM orders o
                    JOIN product p ON o.idProduct = p.idProduct
                    JOIN user u ON o.idUser = u.idUser
                    WHERE o.maTongDonHang = '$code'";
            
            $orderItems = $this->data->select($sql);
            
            while ($item = $orderItems->fetch_assoc()) {
                $allOrders[] = $item;
            }
        }
        
        // Lưu kết quả vào biến cachedResults để sử dụng với getOrdersFetch()
        $this->cachedResults = $allOrders;
        
        return count($allOrders) > 0;
>>>>>>> 691c5016d28f8d18d194fb55186d1de5f3240015
    }
}
?>
