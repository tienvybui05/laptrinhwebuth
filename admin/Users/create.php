<?php 
include_once __DIR__ . '/../auth/checkLogin.php';
$user = new user();
$hoTen = $soDienThoai = "";
$password = $username = "";
$diaChi = $vaiTro="";
$ErrUsername=""; 
if(isset($_POST['taomoi'])){

$hoTen = test_input($_POST['hoten']);
$soDienThoai = test_input($_POST['sodienthoai']);
$username = test_input($_POST['username']);
$password = test_input($_POST['password']);
$diaChi = test_input($_POST['diachi']);
$vaiTro = test_input($_POST['vaitro']);

if($user->isUsernameNotExist($username))
{
    $result = $user->addUser($hoTen,$soDienThoai,$username,$password,$diaChi,$vaiTro);
    header("location: index.php?pageAd=user&crud=index&msg=create_user");
    exit;
}
else
{
    $ErrUsername = "Tên username của bạn đã tồn tại!";
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
                <div>
                    <h2>Thêm tài khoản</h2>
                </div>
                <div class="form-tao">
                    <form action="" method="post" enctype="multipart/form-data" class="form-create-user">
                        <div class="form-group">
                            <label for="">Họ và tên:</label>
                            <input type="text" name="hoten">
                        </div>
                        <div class="form-group">
                            <label for="">Số điện thoại:</label>
                            <input type="text" name="sodienthoai">
                        </div>
                        <div class="form-group">
                            <label for="">Username:</label>
                            <input type="text" name="username">
                        </div>
                        <div class="form-group">
                            <label for="">Password:</label>
                            <input type="text" name="password">
                        </div>
                        <div class="form-group">
                            <label for="">Địa chỉ:</label>
                            <input type="text" name="diachi">
                        </div>
                        <div class="form-group">
                            <label for="">Vai trò:</label>
                            <select name="vaitro">
                                <option value="admin">Admin</option>
                                <option value="customer">Customer</option>
                            </select>
                        </div>
                        <div class="message-product" style="color: red; margin-bottom: 10px;"><?php echo($ErrUsername); ?></div>
                        <div class="button-group">
                        <button class="quay-ve" type="button" onclick="window.location.href='index.php?pageAd=user&crud=index'">Quay về</button>
                            <input class="cap-nhat-sql"type="submit" value="Tạo mới" name="taomoi">
                        </div>
                    </form>
                </div>
            