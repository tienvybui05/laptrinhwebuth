<?php
include 'database.php';
class user{
   private $data;
   public function __construct()
   {
      $this->data = new database();
   }
   public function getUser()
   {
     $sql = "SELECT * FROM User ";
     return $this->data->select($sql);
   }
   public function getUserById($id)
   {
    $sql = "SELECT * FROM User WHERE idUSer = $id ";
    $result =  $this->data->select($sql);// thực thi truy vấn rồi trả về kết quả truy vấn (1 danh sách);
    return $this->data->fetch();
   }
   public function getUserFetch()
   {
     return $this->data->fetch();
   }
}
?>