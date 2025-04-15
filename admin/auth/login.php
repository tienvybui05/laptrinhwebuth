<?php 

session_start();
include '../entities/user.php';
$user = new user();

$username = $password ="";
$ErrAccount="";
if(isset($_POST['login_admin']))
{
    $username =test_input($_POST['username']);
    $password =test_input($_POST['password']);
    $result = $user->isAccount($username,$password);
     if( $result != false)
     {
        if($result[1]=="admin")
        {
            $_SESSION['idUser'] =  $result[0];
                header("location:../index.html");
                exit;
        }
        else{
            $ErrAccount ="*Bạn không đủ quyền hạn";
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
    <title>Login</title>
    <style>
        body{
            background-color: rgb(23, 24, 33);
            align-items: center;
            justify-content: center;
            display: flex;
            font-size: 16px;
            margin: 0;
            height: 100vh;
        }
        .login-container{
            background-color: rgb(33, 34, 45);
            height: auto;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            width: 25%;
            min-width: 100px;
        }
        .login-container h2{
            font-family: Inter, sans-serif;
            font-size: 32px;
            color: rgb(232, 232, 232);
        }
        .form-login input{
            margin: 20px 0;
            height: 50px;
            width: 90%;
            background-color: rgb(29, 30, 38);
           color: rgb(135,136,140);
           border: none;
           border-radius: 5px;
           padding: 5px 10px;
        }
        .form-login input:hover{
            background-color:rgb(23, 24, 33);
        }
        .form-login hr{
            width: 90%;
            border-color: rgb(169, 223, 216);
        }
        .form-login .login{
            background-color: rgb(169, 223, 216);
            color: rgba(0,0,0,0.87);
            width: 90%;
            height: 50px;
            margin-top: 30px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
        }
        .form-login .login:hover{
            background-color:rgb(116, 212, 200);
        }
        .message{
            color: white;
        }
    </style>
   
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form class="form-login" action="" method="post" >
            <input type="text" class="username" placeholder="Tên người dùng" name="username"><br/>
            <input type="password" class="password" placeholder="Mật khẩu" name="password"><br/>
            <p class="message"><?php echo($ErrAccount); ?></p>
            <hr>
            <!-- <button type="submit" name="login">Đăng nhập</button> -->
            <input class="login" type="submit" name="login_admin" value="Tạo mới"/>
        </form>

    </div>
  <script src="../main.js"></script>
 
</body>
</html>