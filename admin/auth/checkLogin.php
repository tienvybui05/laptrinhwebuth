<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['idUser_admin']))
{
    header("location:../auth/login.php");
    exit;
}
?>