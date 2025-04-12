<?php
include '../entities/user.php';
if(isset($_GET['idUser']))
{
    $id = $_GET['idUser'];
    $user = new user();
    $row = $user->getUserById($id);
    echo($row['hoTen']);
}
?>