<?php 
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
if(isset($_SESSION['idUser_admin']))
{
    session_unset();
    session_destroy();
}
header("Location: login.php"); // Hoặc trang nào bạn muốn chuyển về
exit();
?>