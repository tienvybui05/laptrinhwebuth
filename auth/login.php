<?php
session_start();
include '../admin/entities/user.php';
$user = new user();
$ErrAccount="";
$username=$password="";
if(isset($_POST['sub']))
{
    $username =test_input($_POST['username']);
    $password =test_input($_POST['password']);
    $result = $user->isAccount($username,$password);
    if( $result != false)
     {
        if($result[1]=="customer")
        {
                $_SESSION['idUser'] =  $result[0];
                header("location: ../public/index.html");
                exit;
        }
        else{
            $ErrAccount ="*Bạn không phải là khách hàng";
        }
        
       
     }
     else
     {
        $ErrAccount ="*Tài khoản không hợp lệ";
     }

}
function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlentities($data);
    return $data;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .main-signin{
            background-color: whitesmoke;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .formdangnhap{
            width: 25%;
            color: black;
            margin-bottom: 50px;
            text-align: center;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #ddd;
        }

        .formdangnhap h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .formdangnhap label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .formdangnhap input {
            width: 100%;
            padding: 10px;
            padding: 10px 40px;
            border: 1px solid gray;
            background-color: white;
            color: black;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .formdangnhap .subm input {
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

        .formdangnhap .subm input:hover {
            background-color: rgb(198, 193, 193);
            color: black;
        }

        .formdangnhap .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: black;
        }



        /* Định dạng icon */
        .input-group i {
            position: absolute;
            left: 15px; /* Đẩy icon sang trái */
            top: 60%;
            transform: translateY(-50%);
            color: black;
        }


        .formdangnhap .signup-link {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
        }
        .formdangnhap .signup-link a {
            color: black;
            font-weight: bold;
        }

        .formdangnhap .signup-link a:hover {
            color: gray;
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
        <main class="main-signin">
            <div class="formdangnhap">
                <form id="signin" name="signin" method="post" action="#">
                    <h2>Đăng nhập</h2>
                    <div class="input-group">
                        <label for="account">Tài khoản</label>
                        <i class="fas fa-user"></i>
                        <input name="username" id="account" type="text" required/>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Mật khẩu</label>
                        <i class="fas fa-lock"></i>
                        <input name="password" id="password" type="password" required/>
                    </div> 
                    <div>
                        <p><?php echo($ErrAccount);?></p>
                    </div>                   
                    <div class="subm"><input type="submit" name="sub" id="sub" value="Đăng nhập"/></div>
                </form>
                <div class="signup-link">
                    Chưa có tài khoản? <a href="./register.html">Đăng ký</a>
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
                    <p>Email:</p>
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