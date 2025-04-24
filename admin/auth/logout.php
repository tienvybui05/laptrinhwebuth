<?php 
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
if(isset($_SESSION['idUser_admin']))
{
    unset( $_SESSION['idUser_admin']);
    unset( $_SESSION['hoTen_admin']);
}
header("Location: login.php"); // Hoặc trang nào bạn muốn chuyển về
exit();
?>