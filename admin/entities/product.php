<?php
include_once 'database.php';
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
    public function getPaginatedProductsOfAdmin($currentPage, $productsPerPage,$keyword,$thuongHieu) {
        $offset = ($currentPage - 1) * $productsPerPage;

        // Lấy tổng số sản phẩm
        if($thuongHieu=="tatca") {
            $sqlTotal = "SELECT COUNT(*) as total FROM product WHERE tensanpham LIKE '%$keyword%'";
        } else {
            $sqlTotal = "SELECT COUNT(*) as total FROM product WHERE thuongHieu = '$thuongHieu' AND tensanpham LIKE '%$keyword%'";
        }
        $resultTotal = $this->data->select($sqlTotal);
        $totalProducts = 0;
        if ($row = $resultTotal->fetch_assoc()) {
            $totalProducts = $row['total'];
        }

        // Tính tổng số trang
        $totalPages = ceil($totalProducts / $productsPerPage);

        if($thuongHieu=="tatca") 
        {
            $sql = "SELECT * FROM product WHERE tensanpham LIKE '%$keyword%' ORDER BY idProduct ASC LIMIT $offset, $productsPerPage";
        } else 
        {
            $sql = "SELECT * FROM product WHERE thuongHieu = '$thuongHieu' AND tensanpham LIKE '%$keyword%' ORDER BY idProduct ASC LIMIT $offset, $productsPerPage";
        }
        $resultProducts = $this->data->select($sql);

        $products = [];
        while ($row = $resultProducts->fetch_assoc()) {
            $products[] = $row;
        }

        return [$products, $totalPages];
    }
    public function filterProductManager($thuongHieu,$keyword)
    {
        if($thuongHieu=="tatca")
        {
            return $this->getProduct($keyword);
        }
        $sql = "SELECT * FROM  product WHERE thuongHieu = '$thuongHieu' AND tensanpham like '%$keyword%' ORDER BY idProduct DESC";
        return $this->data->select($sql);
    }
    public function getProductFetch()
    {
        return $this->data->fetch();
    }
    
    public function getProductbyId($id)
    {
        $sql = "SELECT * FROM product WHERE idProduct = '$id'";
        $result = $this->data->select($sql);
        return $result->fetch_assoc();
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
    
    public function getPaginatedProducts($currentPage, $productsPerPage) {
        $offset = ($currentPage - 1) * $productsPerPage;

        // Lấy tổng số sản phẩm
        $sqlTotal = "SELECT COUNT(*) as total FROM product";
        $resultTotal = $this->data->select($sqlTotal);
        $totalProducts = 0;
        if ($row = $resultTotal->fetch_assoc()) {
            $totalProducts = $row['total'];
        }

        // Tính tổng số trang
        $totalPages = ceil($totalProducts / $productsPerPage);

        // Lấy sản phẩm theo trang và sắp xếp theo idProduct tăng dần
        $sql = "SELECT * FROM product ORDER BY idProduct ASC LIMIT $offset, $productsPerPage";
        $resultProducts = $this->data->select($sql);

        $products = [];
        while ($row = $resultProducts->fetch_assoc()) {
            $products[] = $row;
        }

        return [$products, $totalPages];
    }
    
    // Lấy tổng số sản phẩm theo bộ lọc
    public function getTotalProducts($keyword = '', $priceMin = 0, $priceMax = 19500000, $doCung = '', $diemCanBang = '', $trongLuong = '', $loiChoi = '', $category = '') {
        $conditions = [];
        
        if (!empty($keyword)) {
            $conditions[] = "tenSanPham LIKE '%$keyword%'";
        }
        
        if ($priceMin > 0) {
            $conditions[] = "gia >= $priceMin";
        }
        
        if ($priceMax < 19500000) {
            $conditions[] = "gia <= $priceMax";
        }
        
        if (!empty($doCung)) {
            $conditions[] = "doCung = '$doCung'";
        }
        
        if (!empty($diemCanBang)) {
            $conditions[] = "diemCanBang = '$diemCanBang'";
        }
        
        if (!empty($trongLuong)) {
            $conditions[] = "trongLuong = '$trongLuong'";
        }
        
        if (!empty($loiChoi)) {
            $conditions[] = "trinhDo = '$loiChoi'";
        }
        
        if (!empty($category)) {
            $conditions[] = "thuongHieu = '$category'";
        }
        
        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
        
        $sql = "SELECT COUNT(*) as total FROM product $whereClause";
        $result = $this->data->select($sql);
        
        if ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
        
        return 0;
    }
    
    // Lấy sản phẩm theo bộ lọc và sắp xếp
    public function getFilteredProducts($keyword = '', $priceMin = 0, $priceMax = 19500000, $doCung = '', $diemCanBang = '', $trongLuong = '', $loiChoi = '', $sortBy = 'newest', $currentPage = 1, $productsPerPage = 16, $category = '') {
        $offset = ($currentPage - 1) * $productsPerPage;
        $conditions = [];
        
        if (!empty($keyword)) {
            $conditions[] = "tenSanPham LIKE '%$keyword%'";
        }
        
        if ($priceMin > 0) {
            $conditions[] = "gia >= $priceMin";
        }
        
        if ($priceMax < 19500000) {
            $conditions[] = "gia <= $priceMax";
        }
        
        if (!empty($doCung)) {
            $conditions[] = "doCung = '$doCung'";
        }
        
        if (!empty($diemCanBang)) {
            $conditions[] = "diemCanBang = '$diemCanBang'";
        }
        
        if (!empty($trongLuong)) {
            $conditions[] = "trongLuong = '$trongLuong'";
        }
        
        if (!empty($loiChoi)) {
            $conditions[] = "trinhDo = '$loiChoi'";
        }
        
        if (!empty($category)) {
            $conditions[] = "thuongHieu = '$category'";
        }
        
        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
        
        // Xác định cách sắp xếp
        $orderBy = "ORDER BY idProduct DESC"; // Mặc định là mới nhất (theo ID giảm dần)
        
        switch ($sortBy) {
            case 'price-asc':
                $orderBy = "ORDER BY gia ASC";
                break;
            case 'price-desc':
                $orderBy = "ORDER BY gia DESC";
                break;
            case 'name-asc':
                $orderBy = "ORDER BY tenSanPham ASC";
                break;
        }
        
        $sql = "SELECT * FROM product $whereClause $orderBy LIMIT $offset, $productsPerPage";
        $result = $this->data->select($sql);
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }
    
    // Lấy danh sách các danh mục sản phẩm (thương hiệu)
    public function getCategories() {
        $sql = "SELECT DISTINCT thuongHieu FROM product ORDER BY thuongHieu ASC";
        $result = $this->data->select($sql);
        
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['thuongHieu'];
        }
        
        return $categories;
    }
    
    // Lấy danh sách các giá trị độ cứng
    public function getStiffnessValues() {
        $sql = "SELECT DISTINCT doCung FROM product WHERE doCung != '' ORDER BY doCung ASC";
        $result = $this->data->select($sql);
        
        $values = [];
        while ($row = $result->fetch_assoc()) {
            $values[] = $row['doCung'];
        }
        
        return $values;
    }
    
    // Lấy danh sách các giá trị điểm cân bằng
    public function getBalanceValues() {
        $sql = "SELECT DISTINCT diemCanBang FROM product WHERE diemCanBang != '' ORDER BY diemCanBang ASC";
        $result = $this->data->select($sql);
        
        $values = [];
        while ($row = $result->fetch_assoc()) {
            $values[] = $row['diemCanBang'];
        }
        
        return $values;
    }
    
    // Lấy danh sách các giá trị trọng lượng
    public function getTensionValues() {
        $sql = "SELECT DISTINCT trongLuong FROM product WHERE trongLuong != '' ORDER BY trongLuong ASC";
        $result = $this->data->select($sql);
        
        $values = [];
        while ($row = $result->fetch_assoc()) {
            $values[] = $row['trongLuong'];
        }
        
        return $values;
    }
    
    // Lấy danh sách các giá trị lối chơi
    public function getPlayStyleValues() {
        $sql = "SELECT DISTINCT trinhDo FROM product WHERE trinhDo != '' ORDER BY trinhDo ASC";
        $result = $this->data->select($sql);
        
        $values = [];
        while ($row = $result->fetch_assoc()) {
            $values[] = $row['trinhDo'];
        }
        
        return $values;
    }
    
    // Lấy sản phẩm liên quan (cùng thương hiệu)
    public function getRelatedProducts($productId, $thuongHieu, $limit = 4) {
        $sql = "SELECT * FROM product WHERE thuongHieu = '$thuongHieu' AND idProduct != '$productId' ORDER BY RAND() LIMIT $limit";
        $result = $this->data->select($sql);
        
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }

    // Lấy khoảng giá sản phẩm (min và max)
    public function getPriceRange() {
        $sql = "SELECT MIN(gia) as min_price, MAX(gia) as max_price FROM product";
        $result = $this->data->select($sql);
        
        if ($row = $result->fetch_assoc()) {
            return [
                'min' => (int)$row['min_price'],
                'max' => (int)$row['max_price']
            ];
        }
        
        return ['min' => 0, 'max' => 19500000]; // Giá trị mặc định
    }

    // Lấy các khoảng giá phổ biến dựa trên dữ liệu sản phẩm
    public function getPopularPriceRanges() {
        $priceRange = $this->getPriceRange();
        $min = $priceRange['min'];
        $max = $priceRange['max'];
        
        // Tạo các khoảng giá phổ biến dựa trên dữ liệu thực tế
        $ranges = [];
        
        // Khoảng giá dưới 1 triệu
        if ($min < 1000000) {
            $ranges[] = [
                'label' => 'Dưới 1tr',
                'min' => $min,
                'max' => 1000000
            ];
        }
        
        // Các khoảng giá từ 1tr đến 5tr
        $steps = [1000000, 1500000, 2000000, 3000000, 5000000];
        for ($i = 0; $i < count($steps) - 1; $i++) {
            if ($steps[$i] <= $max) {
                $ranges[] = [
                    'label' => number_format($steps[$i] / 1000000, 1, 'tr', '') . ' - ' . number_format($steps[$i+1] / 1000000, 1, 'tr', ''),
                    'min' => $steps[$i],
                    'max' => $steps[$i+1]
                ];
            }
        }
        
        // Khoảng giá trên 5 triệu
        if ($max > 5000000) {
            $ranges[] = [
                'label' => 'Trên 5tr',
                'min' => 5000000,
                'max' => $max
            ];
        }
        
        return $ranges;
    }
    public function getNumberProduct()
   {
        $sql = "SELECT COUNT(*) AS total FROM product";
        $result = $this->data->select($sql);
        if ($result && $row = $result->fetch_assoc()) 
        {
            return $row['total'];
        }
        return 0;
   }
}
?>
