<?php
if (!defined('ALLOW_INCLUDE')) {
    header("location: auth/accessDenied.php");
}
?>
<div id="logo">
    <a href="index.php">
        <img src="../public/images/logo.png" alt="">
    </a>
</div>
<div id="sidebar-menu">
    <ul class="de-muc">
        <li class="muc">
            <i class="nav-arrow-down ti-user"></i>
            <a href="index.php?pageAd=user&crud=index"> Tài khoản</a>
        </li>
        <li class="muc">
            <i class="nav-arrow-down ti-briefcase"></i>
            <a href="index.php?pageAd=product&crud=index"> Sản phẩm</a>
        </li>
        <li class="muc">
            <i class="nav-arrow-down ti-shopping-cart"></i>
            <a href="index.php?pageAd=orders&crud=index"> Đơn hàng</a>
        </li>
        <li class="muc">
            <i class="nav-arrow-down ti-comment"></i>
            <a href="index.php?pageAd=cart&crud=index"> Giỏ hàng</a>
        </li>
    </ul>
</div>