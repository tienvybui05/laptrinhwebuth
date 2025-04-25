<?php 
include '../entities/user.php';
$user = new user();
if(isset($_COOKIE['remember_token'])&&!empty($_COOKIE['remember_token']))
{
    $token = $_COOKIE['remember_token'];
    $result = $user->getUserByToken($token);
    if($result && $result['vaiTro']==="admin")
    {
        $_SESSION['idUser_admin'] = $result['idUser'];
        $_SESSION['hoTen_admin'] = $result['hoTen'];
        header("location:../index.php");
        exit;
    
    }
} 
header("location: login.php");
?>