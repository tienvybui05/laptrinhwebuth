<?php
include '../admin/entities/user.php';
$user = new user();
$hoTen=$soDienThoai=$username=$password=$diaChi="";
$ErrUsername="";
if(isset($_POST['submit']))
{
$hoTen=test_input($_POST['fullname']);
$soDienThoai=test_input($_POST['soDienThoai']);
$diaChi=test_input($_POST['diaChi']);
$username = test_input($_POST['username']);
$password = test_input($_POST['password']);
if($user->isUsernameNotExist($username))
{
    $result = $user->addUser($hoTen,$soDienThoai,$username,$password,$diaChi,"customer");
    header("location: ../public/index.html");
    exit;
}
else
{
    $ErrUsername="Username của bạn đã tồn tại";
}
}
function test_input($data)
{
    $data= trim($data);
    $data=stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .main-signup {
            background-color: whitesmoke;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .formdangky {
            width: 25%;
            color: black;
            margin-bottom: 50px;
            text-align: center;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #ddd;
        }

        .formdangky h2 {
            font-size: 28px;
            margin-bottom: 40px;
        }

        .formdangky label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .formdangky input {
            width: 100%;
            padding: 10px 40px;
            border: 1px solid gray;
            background-color: white;
            color: black;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .formdangky .subm input {
            width: 100%;
            background-color: black;
            border: none;
            padding: 10px;
            color: whitesmoke;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .formdangky .subm input:hover {
            background-color: rgb(198, 193, 193);
            color: black;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 60%;
            transform: translateY(-50%);
            color: black;
        }
    </style>
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
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giới thiệu</a></li>
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
        <main class="main-signup">
            <div class="formdangky">
                <form id="signup" name="signup" method="post" action="#">
                    <h2>Đăng ký</h2>
                    
                    <div class="input-group">
                        <label for="fullname">Nhập tên tên của bạn</label>
                        <i class="fas fa-user"></i>
                        <input name="fullname" id="fullname" type="text" value="<?php echo($hoTen); ?>" required />
                    </div>
                    
                    <div class="input-group">
                        <label for="email">Nhập số điện thoại của bạn</label>
                        <i class="fas fa-user"></i>
                        <input name="soDienThoai" id="soDienThoai" type="text" value="<?php echo($soDienThoai); ?>" required />
                    </div>
                    <div class="input-group">
                        <label for="email">Nhập số địa chỉ của bạn</label>
                        <i class="fas fa-user"></i>
                        <input name="diaChi" id="diaChi" type="text" value="<?php echo($diaChi); ?>" required />
                    </div>
                    <div class="input-group">
                        <label for="fullname">Nhập username</label>
                        <i class="fas fa-user"></i>
                        <input name="username" id="username" type="text" value="<?php echo($username); ?>" required />
                    </div>
                    <div class="input-group">
                        <label for="password">Mật khẩu</label>
                        <i class="fas fa-lock"></i>
                        <input name="password" id="password" type="password" required />
                    </div>
                    
                    <div class="input-group">
                        <label for="confirm-password">Nhập lại mật khẩu</label>
                        <i class="fas fa-lock"></i>
                        <input name="confirm-password" id="confirm-password" type="password" required />
                    </div>
                    <div class="hong-bao-loi">
                                <p><?php echo($ErrUsername)?></p>
                    </div>
                    <div class="subm">
                        <input type="submit" name="submit" id="submit" value="Đăng ký" />
                    </div>
                </form>
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
