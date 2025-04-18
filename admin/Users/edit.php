<?php 
include '../auth/checkLogin.php';
include '../entities/user.php';
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $user = new user();
    $row = $user->getUserById($id);
    $hoTen = $row['hoTen'];
    $soDienThoai = $row['soDienThoai'];
    $password = $row['password'];
    $username = $row['username'];
    $diaChi = $row['diaChi'];
    $vaiTro= $row['vaiTro'];
    $ErrUsername="";
    if(isset($_POST['chinhsua']))
    {
        if(!empty($_POST['hoten']))
        {
            $hoTen = test_input($_POST['hoten']);
        }
        if(!empty($_POST['sodienthoai']))
        {
            $soDienThoai = test_input($_POST['sodienthoai']);
        }
        if(!empty($_POST['username']))
        {
            $username = test_input($_POST['username']);
        }
        if(!empty($_POST['password']))
        {
            $password = test_input($_POST['password']);
        }
        if(!empty($_POST['diaChi']))
        {
            $diaChi = test_input($_POST['diaChi']);
        }
        if(!empty($_POST['vaitro']))
        {
            $vaiTro = test_input($_POST['vaitro']);
        }
        $result = $user->updateUser($id,$hoTen,$soDienThoai,$username,$password,$diaChi,$vaiTro);
        header("location: index.php?msg=edit_user");
        exit;

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
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../../public/themify-icons/themify-icons.css">
</head>
<body>
    <div id="admin-container">
        <div id="sidebar">
            <div id="logo" >
                <a href="#">
                  <img src="../../public/images/logo.png" alt="">  
                </a>
            </div>
            <div id="sidebar-menu">
                <ul class="de-muc">
                    <li class="muc">
                        <i class="nav-arrow-down ti-user"></i>
                        <a href="#"> Tải khoản</a>
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
               <div class="search-admin">
                    <i class="nav-arrow-down ti-search"></i>
                   <input class="tim-kiem" type="text" placeholder="Tìm kiếm..">
               </div>
               <div class="login-admin">
                    <div class="login">
                        <a href="#">Login</a>
                    </div>
               </div>
            </div>
            <div id="content">
                
                <div>
                    <h2>Chỉnh sửa tài khoản</h2>
                </div>
                <div class="form-tao">
                    <form action="" method="post" enctype="multipart/form-data" class="form-edit-user">
                        <div class="form-group">
                            <label for="">Họ và tên:</label>
                            <input type="text" name="hoten" value ="<?php echo($row['hoTen']); ?>" >
                        </div>
                        <div class="form-group">
                            <label for="">Số điện thoại:</label>
                            <input type="text" name="sodienthoai" value ="<?php echo($row['soDienThoai']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Username:</label>
                            <input type="text" name="username" value ="<?php echo($row['username']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Password:</label>
                            <input type="text" name="password" >
                        </div>
                        <div class="form-group">
                            <label for="">Địa chỉ:</label>
                            <input type="text" name="diachi" value ="<?php echo($row['diaChi']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Vai trò:</label>
                            <select name="vaitro">
                            <option value="admin" <?php if(isset($vaiTro) && $vaiTro == "admin"){ echo "selected"; } ?>>Admin</option>
                            <option value="customer" <?php if(isset($vaiTro) && $vaiTro == "customer"){ echo "selected"; } ?>>Customer</option>
                            </select>
                        </div>
                        <div class="message-product" style="color: red; margin-bottom: 10px;"><?php echo($ErrUsername); ?></div>
                        <div class="button-group">
                        <button class="quay-ve" type="button" onclick="window.location.href='index.php'">Quay về</button>
                            <input class="cap-nhat-sql"type="submit" value="Chỉnh sửa" name="chinhsua">
                        </div>
                    </form>
                </div>
            </div>
            <div id="footer">
                <p>Bản quyền thuộc <a href="https://github.com/tienvybui05/laptrinhwebuth" > Vợt cầu lông</a></p>
            </div>
        </div>
    </div>
    <script src="../main.js"></script>
</body>
</html>