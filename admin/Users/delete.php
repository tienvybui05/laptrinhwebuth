<?php
include '../entities/user.php';
if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $user = new user();
    $result = $user->deleteUser($id);
    header("location: index.php?msg=delete_user");
    exit;
}
?>