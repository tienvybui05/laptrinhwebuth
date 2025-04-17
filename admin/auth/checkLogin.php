<?php 
session_start();
if(!isset($_SESSION['idUser_admin']))
{
    header("location:../auth/login.php");
    exit;
}
?>