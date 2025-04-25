<?php
session_start();
if (!isset($_SESSION['idUser_admin'])) {
    header(("location: auth/checkCookie.php"));
    exit;
}
define('ALLOW_INCLUDE', true);
$hoTenAdmin = $_SESSION['hoTen_admin'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
</head>

<body>
    <div id="admin-container">
        <!-- sidebar -->
        <div id="sidebar">
            <?php include_once  'sidebar.php' ?>
        </div>
        <div id="main-content">
            <!-- header -->
            <?php include_once 'header.php' ?>
            <div id="content">
                <!-- content -->
                <?php
                include 'entities/user.php';
                include 'entities/product.php';
                include_once 'entities/orders.php';
                include_once 'entities/cart.php';
                if (isset($_GET['pageAd']) && isset($_GET['crud'])) 
                {
                    $page = $_GET['pageAd'];
                    $crud = $_GET['crud'];
                    if ($page == "user" && $crud == "index") 
                    {
                        include 'Users/index.php';
                    } 
                    else if ($page == "user" && $crud == "create") 
                    {
                        include 'Users/create.php';
                    } 
                    else if ($page == "user" && $crud == "edit") 
                    {
                        include 'Users/edit.php';
                    } 
                    else if ($page == "user" && $crud == "delete") 
                    {
                        include 'Users/delete.php';
                    } 
                    else if ($page == "product" && $crud == "index") 
                    {
                        include 'products/index.php';
                    } 
                    else if ($page == "product" && $crud == "create") 
                    {
                        include 'products/create.php';
                    } 
                    else if ($page == "product" && $crud == "edit") 
                    {
                        include 'products/edit.php';
                    } 
                    else if ($page == "product" && $crud == "detail") 
                    {
                        include 'products/detail.php';
                    } 
                    else if ($page == "product" && $crud == "delete") 
                    {
                        include 'products/delete.php';
                    } 
                    else if ($page == "orders" && $crud == "index") 
                    {
                        include 'orders/index.php';
                    } 
                    else if ($page == "orders" && $crud == "detail") 
                    {
                        include 'orders/detail.php';
                    } 
                    else if ($page == "cart" && $crud == "index") 
                    {
                        include 'carts/index.php';
                    } 
                    else {
                        echo ("Trang này không tồn tại");
                    }
                } else 
                {
                    include_once "main.php";
                }
                ?>
            </div>
            <!-- footer -->
            <div id="footer">
                <?php include_once  'footer.php'; ?>
            </div>
        </div>
    </div>
    <script src="main.js"></script>

</body>

</html>