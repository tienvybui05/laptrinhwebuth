<?php
include 'database.php';
class user{
    private $data;
    public function __construct()
    {
        $this->data
    }
    public function getUser($keyword)
    {
        $sql = "SELECT * FROM user WHERE hoTen LIKE '%$keyword%' ORDER BY idUser DESC";
        return $this->data->select($sql);
    }
}
?>