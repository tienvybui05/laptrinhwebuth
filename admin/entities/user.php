<?php
include_once 'database.php';
class user{
   private $data;
   public function __construct()
   {
      $this->data = new database();
   }
   public function getUser($keyword)
   {
     $sql = "SELECT * FROM User WHERE hoTen LIKE '%$keyword%' ORDER BY idUser DESC";
     return $this->data->select($sql);
   }
   public function getPaginatedUserOfAdmin($currentPage, $usersPerPage,$keyword,$role)
   {
      $offset =($currentPage - 1) * $usersPerPage;
      // Lấy tổng số người dùng
      if($role =="tatca")
      {
         $sqlCount = "SELECT COUNT(*) as total FROM user WHERE hoTen LIKE '%$keyword%' ";
      }
      else
      {
         $sqlCount = "SELECT COUNT(*) as total FROM user WHERE vaiTro = '$role' and hoTen LIKE '%$keyword%'";
      }
      $resultCount = $this->data->select($sqlCount);
      $totalUsers = 0;
      if ($row =  $resultCount->fetch_assoc()) 
      {
         $totalUsers = $row['total'];
      }
      $totalPages = ceil($totalUsers/$usersPerPage);
      if($role=="tatca")
      {
         $sql = "SELECT * FROM user WHERE hoTen LIKE '%$keyword%' ORDER BY idUser ASC LIMIT $offset, $usersPerPage";
      }
      else
      {
         $sql = "SELECT * FROM user WHERE vaiTro = '$role' and hoTen LIKE '%$keyword%' ORDER BY idUser ASC LIMIT $offset, $usersPerPage";
      }
      $result = $this->data->select($sql);
      $users = [];
      while($row = $result->fetch_assoc() )
      {
         $users[] = $row;
      }
      return [$users, $totalPages];
   }
   public function getUserById($id)
   {
    $sql = "SELECT * FROM User WHERE idUSer = $id ";
    $result =  $this->data->select($sql);
    return $this->data->fetch();
   }
   public function getUserFetch()
   {
     return $this->data->fetch();
   }
   public function addUser($hoTen,$soDienThoai,$username,$password,$diaChi,$vaiTro)
   {
    $password = password_hash($password,PASSWORD_DEFAULT);
    $sql = "INSERT INTO user(hoTen,soDienThoai,username,password,diaChi,vaiTro)
            VALUES ('$hoTen','$soDienThoai','$username','$password','$diaChi','$vaiTro')";
      return $this->data->insert($sql);
   }
   public function isUsernameNotExist($username)
   {
    $sql = "SELECT username FROM User WHERE username = '$username'";
    $result = $this->data->select($sql);
    $row = $this->data->fetch();
    if($row==null)
    {
      return true;
    }
    return false;
   }
   public function updateUser($id,$hoTen,$soDienThoai,$username,$password,$diaChi,$vaiTro)
   {
    $password = password_hash($password,PASSWORD_DEFAULT);
    $sql = "UPDATE user SET hoTen = '$hoTen', soDienThoai = '$soDienThoai' , username = '$username',
                            password = '$password' ,diaChi='$diaChi',vaiTro ='$vaiTro'
                            WHERE idUser = '$id'";
    return $this->data->update($sql);
   }
   public function deleteUser($id)
   {
      $sql = "DELETE FROM user WHERE idUser = '$id'";
      return $this->data->delete($sql);
   }
   public function isAccount($username,$password)
   {
      $sql = "SELECT * FROM user WHERE user.username='$username'";
      $result = $this->data->select($sql);
      if($this->data->numRows() == 1)
      {
         $row = $this->data->fetch();
         if(password_verify($password,$row['password']))
         {
            return [$row['idUser'],$row['vaiTro'],$row['hoTen']];
         }
         return false;
      }
      return false;
      
   }
   
}
?>