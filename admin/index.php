<?php
session_start();
if(!isset($_SESSION['idUser_admin']))
{
    header("location: auth/login.php");
    exit;
}
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
        <div id="sidebar">
            <div id="logo">
                <a href="#">
                    <img src="../public/images/logo.png" alt="">
                </a>
            </div>
            <div id="sidebar-menu">
                <ul class="de-muc">
                    <li class="muc">
                        <i class="nav-arrow-down ti-user"></i>
                        <a href="#"> Tài khoản</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-briefcase"></i>
                        <a href="#"> Sản phẩm</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-shopping-cart"></i>
                        <a href="#"> Đơn hàng</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-comment"></i>
                        <a href="#"> Đánh giá</a>
                    </li>
                    <li class="muc">
                        <i class="nav-arrow-down ti-drupal"></i>
                        <a href="#"> Khách hàng</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="main-content">
            <div id="header">
                <div class="datetime-glass-header"> 
                    <i class="ti-alarm-clock"></i>  
                    <div id="datetime" class="datetime-glass"></div>
                </div>
                <div class="login-admin">
                    <p><?php echo($hoTenAdmin); ?></p>
                    <div class="login">
                        <a href="auth/logout.php">Logout</a>
                    </div>
                </div>
            </div>
            <div id="content">
                <div class="row-dau">
                    <div class="row-thong-tin">
                        <div class="tai-khoan thong-tin">
                            <p><i class="nav-arrow-down ti-user"></i></p>
                            <p>Số lượng tài khoản</p>
                            <p style="font-size: 30px;">10</p>
                            <button>
                                <a href="#">Tài khoản</a>
                            </button>
                        </div>
                        <div class="san-pham thong-tin">
                            <p><i class="nav-arrow-down ti-gift"></i></p>
                            <p>Số lượng sản phẩm</p>
                            <p style="font-size: 30px;">10</p>
                            <button>
                                <a href="#">Sản phẩm</a>
                            </button>
                        </div>
                        <div class="don-hang thong-tin">
                            <p><i class="nav-arrow-down ti-shopping-cart-full"></i></p>
                            <p>Số lượng đơn hàng</p>
                            <p style="font-size: 30px;">10</p>
                            <button>
                                <a href="#">Đơn hàng</a>
                            </button>
                        </div>
                        <div class="khach-hang thong-tin">
                            <p><i class="nav-arrow-down ti-shopping-cart-full"></i></p>
                            <p>Số lượng đơn hàng</p>
                            <p style="font-size: 30px;">10</p>
                            <button>
                                <a href="#">Đơn hàng</a>
                            </button>
                        </div>
                        <div class="marquee-box">
                            <marquee behavior="scroll" direction="left" scrollamount="6">
                                🎉 Chào mừng bạn đến với trang quản trị! Cập nhật đơn hàng và sản phẩm mỗi ngày để giữ cho cửa hàng luôn hoạt động tốt nhé! 🚀
                            </marquee>
                        </div>
                    </div>
                    <div class="row-thong-ke">
                        <div class="gioi-thieu">
                            <h3>Giới thiệu</h3>
                            <p>Chào mừng bạn đến với trang thống kê doanh thu.</p>
                            <p> Tại đây, bạn có thể theo dõi các chỉ số kinh doanh quan trọng.</p>
                        </div>
                        <div class="doanh-thu">
                            <p>Doanh thu: 1000k </p>
                            <i class="nav-arrow-down ti-stats-up"></i>
                        </div>
                    </div>
                </div>
                <div class="row-hai">


                </div>

            </div>
            <div id="footer">
                <p>Bản quyền thuộc <a href="https://github.com/tienvybui05/laptrinhwebuth" target="_blank"> Vợt cầu lông</a></p>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
        
</body>

</html>