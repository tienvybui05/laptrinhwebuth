<?php
include_once 'database.php';
class news {
    private $data;
    
    public function __construct() {
        $this->data = new database();
    }
    public function getPaginatedNewsOfAdmin($currentPage, $soTinTuc, $keyword,$loaiTinTuc)
    {
      $offset =($currentPage - 1) * $soTinTuc;
      if($loaiTinTuc =="tatca")
      {
         $sqlCount = "SELECT COUNT(*) as total FROM news WHERE moTa LIKE '%$keyword%' ";
      }
      else
      {
         $sqlCount = "SELECT COUNT(*) as total FROM news WHERE tieuDe = '$loaiTinTuc' and moTa LIKE '%$keyword%'";
      }
      $resultCount = $this->data->select($sqlCount);
      $totalNews = 0;
      if ($row =  $resultCount->fetch_assoc()) 
      {
         $totalNews = $row['total'];
      }
      $totalPages = ceil($totalNews/$soTinTuc);
      if($loaiTinTuc=="tatca")
      {
         $sql = "SELECT * FROM news WHERE moTa LIKE '%$keyword%' ORDER BY idTinTuc ASC LIMIT $offset, $soTinTuc";
      }
      else
      {
         $sql = "SELECT * FROM news WHERE tieuDe = '$loaiTinTuc' and moTa LIKE '%$keyword%' ORDER BY idTinTuc ASC LIMIT $offset, $soTinTuc";
      }
      $result = $this->data->select($sql);
      $news = [];
      while($row = $result->fetch_assoc() )
      {
         $news[] = $row;
      }
      return [$news, $totalPages];
    }

    public function addNew($tieuDe,$moTa,$hinhAnh,$noiDung,$tacGia)
    {
        $sql = "INSERT INTO news(tieuDe,moTa,noiDung,hinhAnh,TacGia)
                VALUES('$tieuDe','$moTa','$noiDung','$hinhAnh','$tacGia')";
        return $this->data->insert($sql);
    }
 
    // Lấy tất cả tin tức
    public function getAllNews($limit = null) {
        $sql = "SELECT * FROM news ORDER BY idTinTuc DESC";
        
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        
        return $this->data->select($sql);
    }
    
    // Lấy tin tức theo ID
    public function getNewsById($id) {
        $sql = "SELECT * FROM news WHERE idTinTuc = '$id'";
        $result = $this->data->select($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
    
    // Lấy tin tức theo từ khóa tìm kiếm
    public function searchNews($keyword) {
        $sql = "SELECT * FROM news WHERE tieuDe LIKE '%$keyword%' OR moTa LIKE '%$keyword%' OR noiDung LIKE '%$keyword%' ORDER BY idTinTuc DESC";
        return $this->data->select($sql);
    }
    
    // Thêm tin tức mới
    public function addNews($tieuDe, $moTa, $noiDung, $hinhAnh, $tacGia) {
        $sql = "INSERT INTO news (tieuDe, moTa, noiDung, hinhAnh, tacGia, ngayDang) 
                VALUES ('$tieuDe', '$moTa', '$noiDung', '$hinhAnh', '$tacGia', NOW())";
        return $this->data->insert($sql);
    }
    
    // Cập nhật tin tức
    public function updateNews($id, $tieuDe, $moTa, $noiDung, $hinhAnh, $tacGia) {
        $sql = "UPDATE news SET 
                tieuDe = '$tieuDe', 
                moTa = '$moTa', 
                noiDung = '$noiDung', 
                hinhAnh = '$hinhAnh', 
                tacGia = '$tacGia' 
                WHERE idTinTuc = '$id'";
        return $this->data->update($sql);
    }
    
    // Xóa tin tức
    public function deleteNews($id) {
        $sql = "DELETE FROM news WHERE idTinTuc = '$id'";
        return $this->data->delete($sql);
    }
    
    // Lấy tin tức liên quan (cùng tác giả hoặc có từ khóa tương tự)
    public function getRelatedNews($id, $tacGia, $limit = 3) {
        $sql = "SELECT * FROM news WHERE idTinTuc != '$id' AND tacGia = '$tacGia' 
                ORDER BY idTinTuc DESC LIMIT $limit";
        $result = $this->data->select($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result;
        }
        
        // Nếu không có tin tức cùng tác giả, lấy tin tức mới nhất
        $sql = "SELECT * FROM news WHERE idTinTuc != '$id' 
                ORDER BY idTinTuc DESC LIMIT $limit";
        return $this->data->select($sql);
    }
    
    // Lấy tin tức nổi bật (có thể dựa vào lượt xem hoặc đánh dấu nổi bật)
    public function getFeaturedNews($limit = 3) {
        $sql = "SELECT * FROM news ORDER BY idTinTuc DESC LIMIT $limit";
        return $this->data->select($sql);
    }
    public function getNumberNews()
    {
         $sql = "SELECT COUNT(*) AS total FROM news";
         $result = $this->data->select($sql);
         if ($result && $row = $result->fetch_assoc()) 
         {
             return $row['total'];
         }
         return 0;
    }
}
?>
