<?php 
include_once __DIR__ . '/../auth/checkLogin.php';
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
        header("location: index.php?pageAd=user&crud=index&msg=edit_user");
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
                        <button class="quay-ve" type="button" onclick="window.location.href='index.php?pageAd=user&crud=index'">Quay về</button>
                            <input class="cap-nhat-sql"type="submit" value="Chỉnh sửa" name="chinhsua">
                        </div>
                    </form>
                </div>
            