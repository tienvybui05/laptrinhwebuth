<?php 
session_start();
if(!isset($_SESSION['idUser']))
{
    header("location: login.php");
    exit;
}
include '../admin/entities/user.php';
$user = new user();
$id = $_SESSION['idUser'];
$row = $user->getUserById($id);
$hoTen = $row['hoTen'];
$soDienThoai= $row['soDienThoai'];
$diaChi= $row['diaChi'];
$password = $row['password'];
$username = $row['username'];
$msgInformation="";
$msgPassword ="";
if(isset($_POST['information']))
{
    if(!empty($_POST['infoname']))
    {
        $hoTen=test_input($_POST['infoname']);
    }
    if(!empty($_POST['infoSoDienThaoi']))
    {
    
        $soDienThoai=test_input($_POST['infoSoDienThaoi']);
    }
    if(!empty($_POST['infoaddress']))
    {
 
        $diaChi=test_input($_POST['infoaddress']);
    }
        $result = $user->updateUser($id,$hoTen,$soDienThoai,$username,$password,$diaChi,"customer");   
        if ($result) 
        {
            $msgInformation='Cập nhật thông tin thành công!';
        } 
}
if(isset($_POST['savePassword']))
{
    $passwordOld = test_input($_POST['passwordOld']); 
    $result = $user->isAccount($username,$passwordOld);
    if($result===false)
    {
        $msgPassword="Nhập sai mật khẩu!";
    }
    else{
        $passwordNew =test_input($_POST['passwordNew']);
        $result = $user->updateUser($id,$hoTen,$soDienThoai,$username, $passwordNew,$diaChi,"customer");  
        if ($result) 
        {
            $msgPassword='Cập nhật mật khẩu thành công!';
        }  
    }
}
function test_input($data)
{
    $data =trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../public/css/style.css">


</head>

<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <!--Thanh menu  -->
                <nav class="navbar">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <ul id="main-menu">
                        <li><a href="../public/index.html" class="active">Trang chủ</a></li>
                        <li><a href="../pages/about.html" class="">Giới thiệu</a></li>
                        <li><a href="#">Sản phẩm</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                    <!--Thanh tìm kiếm  -->
                    <div class="search-bar">
                        <input type="text" placeholder="Tìm kiếm..." />
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="right-icons">
                        <a href="#" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>
                        <a href="#" class="user-icon"><i class="fas fa-user"></i></a>
                    </div>
                </nav>
            </div>
        </header>
        <main class="main">
            <div class="main-account">
                <div class="main-account-header">
                    <h3>Thông tin tài khoản của bạn</h3>
                    <p>Quản lý thông tin để bảo mật tài khoản</p>
                </div>
                <div class="main-account-body">
                    <div class="main-account-body-col">
                        <form action="" class="info-user" method = "post">
                            <div class="form-group">
                                <label for="infoname" class="form-label">Họ và tên</label>
                                <input class="form-control" type="text" name="infoname" id="infoname" placeholder="" value="<?php echo($hoTen);?>">
                            </div>
                            <div class="form-group">
                                <label for="infoSoDienThaoi" class="form-label">Số điện thoại</label>
                                <input class="form-control" type="text" name="infoSoDienThaoi" id="infoemail"
                                    placeholder="Thêm số điện thoại của bạn" value="<?php echo($soDienThoai);?>">
                                <span class="inforemail-error form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="infoaddress" class="form-label">Địa chỉ</label>
                                <input class="form-control" type="text" name="infoaddress" id="infoaddress"
                                    placeholder="Thêm địa chỉ của bạn" value="<?php echo($diaChi);?>">
                            </div>
                            <div>
                                <p><?php echo($msgInformation); ?></p>
                                <button id="save-info-user" onclick="changeInformation()" name = "information">
                                    <i class="fa-regular fa-floppy-disk"></i> Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="main-account-body-col">
                        <form action="" class="change-password" method="post">
                            <div class="form-group">
                                <label for="" class="form-label w60">Mật khẩu hiện tại</label>
                                <input class="form-control" type="password" name="passwordOld" id="password-cur-info"
                                    placeholder="Nhập mật khẩu hiện tại">
                                <span class="password-cur-info-error form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label w60">Mật khẩu mới </label>
                                <input class="form-control" type="password" name="passwordNew" id="password-after-info"
                                    placeholder="Nhập mật khẩu mới">
                                <span class="password-after-info-error form-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label w60">Xác nhận mật khẩu mới</label>
                                <input class="form-control" type="password" name="confirmPassword" id="password-comfirm-info"
                                    placeholder="Nhập lại mật khẩu mới">
                                <span class="password-after-comfirm-error form-message"></span>
                            </div>
                            <div>
                                <p><?php echo($msgPassword); ?></p>
                                <button id="save-password" onclick="changePassword()" name ="savePassword">
                                    <i class="fa-regular fa-key"></i> Đổi mật khẩu
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </main>
        <footer class="footer">
            <div class="container">
                <div class="footer-left">
                    <a href="#" id="logo">
                        <img src="../public/images/logo.png" alt="logo">
                    </a>
                    <h3>Thông tin liên hệ</h3>
                    <p>Địa chỉ: 123 đường ABC, TP.HCM</p>
                    <p>Email:
                </div>
                <div class="footer-center">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Sản phẩm</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-right">
                    <h3>Theo dõi chúng tôi</h3>
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook-f"></i>Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i>Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i>Instagram</a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i>Linkedin</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>