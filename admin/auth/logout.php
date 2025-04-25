<?php 
session_start();
include '../entities/user.php';
$user = new user();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
if(isset($_SESSION['idUser_admin']))
{
    unset( $_SESSION['idUser_admin']);
    unset( $_SESSION['hoTen_admin']);
}
$cookie = $_COOKIE['remember_token'];
setcookie('remember_token', '', time() - 3600, "/", "", true, true);
$result = $user->deleteToken($cookie);
header("Location: login.php"); 
exit();
?>