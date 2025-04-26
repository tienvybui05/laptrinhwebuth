<?php
session_start();

include '../admin/entities/user.php';
$user = new user();
if(isset($_COOKIE['remember_token_customer'])&&!empty($_COOKIE['remember_token_customer']))
{
    $token = $_COOKIE['remember_token_customer'];
    $result = $user->getUserByToken($token);
    if($result && $result['vaiTro']==="customer")
    {
        $_SESSION['idUser'] = $result['idUser'];
        $_SESSION['hoTen'] = $result['hoTen'];
        
        header("location:../public/index.php");
        exit;
    }
}
if(isset($_SESSION['idUser']))
{
    header("location: ../public/index.php");
    exit;
}
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
                $_SESSION['hoTen'] = $result[2];
                if(isset($_POST['luudangnhap']))
                {
                    $token = bin2hex(random_bytes(32));
                    $expiry = date("Y-m-d H:i:s", time() + (86400*7));
                    setcookie('remember_token_customer', $token, time() + (86400*7), "/", "", true, true);
                    $user->saveRememberToken($result[0], $token, $expiry);
                }
                header("location: ../public/index.php");
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
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">


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
        .luu-dang-nhap{
            display:flex;
        }
        .luu-dang-nhap input{
            width: auto;
           
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
    <?php
    include '../includes/header.php';
?>
        <main class="main-signin">
            <div class="formdangnhap">
                <form id="signin" name="signin" method="post" action="#">
                    <h2>Đăng nhập</h2>
                    <div class="input-group">
                        <label for="account">Tài khoản</label>
                        <i class="ti-user"></i>
                        <input name="username" id="account" type="text" required/>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Mật khẩu</label>
                        <i class="ti-lock"></i>
                        <input name="password" id="password" type="password" required/>
                    </div> 
                    <div class="luu-dang-nhap">
                    <input type="checkbox" class="luudangnhap" name="luudangnhap" value="luudangnhap">
                    <label for="luudangnhap">Ghi nhớ đăng nhập.</label>
                    </div>
                    <div>
                        <p><?php echo($ErrAccount);?></p>
                    </div>                   
                    <div class="subm"><input type="submit" name="sub" id="sub" value="Đăng nhập"/></div>
                </form>
                <div class="signup-link">
                    Chưa có tài khoản? <a href="./register.php">Đăng ký</a>
                </div>
            </div>              
        </main>
        <?php
    include '../includes/footer.php';
    ?>
    </div>
</body>
</html>