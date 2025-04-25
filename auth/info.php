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
    // Cập nhật các thông tin khác ngoài mật khẩu
    if(!empty($_POST['infoname']))
    {
        $hoTen = test_input($_POST['infoname']);
    }
    if(!empty($_POST['infoSoDienThoai']))
    {
        $soDienThoai = test_input($_POST['infoSoDienThoai']);
    }
    if(!empty($_POST['infoaddress']))
    {
        $diaChi = test_input($_POST['infoaddress']);
    }

    // Chỉ cập nhật mật khẩu khi người dùng thay đổi mật khẩu trong form đổi mật khẩu
    // Nếu không thay đổi mật khẩu, giữ nguyên mật khẩu cũ
    $result = $user->updateUser($id, $hoTen, $soDienThoai, $username, $password, $diaChi, "customer");

    if ($result) 
    {
        $msgInformation = 'Cập nhật thông tin thành công!';
    }
}

if(isset($_POST['savePassword']))
{
    $passwordOld = test_input($_POST['passwordOld']); 
    $result = $user->isAccount($username, $passwordOld);
    
    if($result === false)
    {
        $msgPassword = "Mật khẩu hiện tại không chính xác!";
    }
    else{
        $passwordNew = test_input($_POST['passwordNew']);
        // Kiểm tra mật khẩu mới và xác nhận mật khẩu
        if ($passwordNew === $_POST['confirmPassword']) {
            // Cập nhật mật khẩu mới
            $result = $user->updateUser($id, $hoTen, $soDienThoai, $username, $passwordNew, $diaChi, "customer");  
            if ($result) 
            {
                $msgPassword = 'Cập nhật mật khẩu thành công!';
            }  
        } else {
            $msgPassword = "Xác nhận mật khẩu mới không khớp!";
        }
    }
}




// Hàm xử lý đầu vào
function test_input($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!-- Nếu có thông báo thì dùng JavaScript để hiển thị -->
<?php if ($msgInformation != ''): ?>
    <script>
        window.onload = function() {
            showNotification("<?php echo $msgInformation; ?>");
        };
    </script>
<?php endif; ?>

<?php if ($msgPassword != ''): ?>
    <script>
        window.onload = function() {
            showNotification("<?php echo $msgPassword; ?>");
        };
    </script>
<?php endif; ?>

<!-- JavaScript để hiển thị thông báo -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const passwordOldInput = document.querySelector('#password-cur-info');
    const passwordNewInput = document.querySelector('#password-after-info');
    const confirmPasswordInput = document.querySelector('#password-comfirm-info');
    const savePasswordButton = document.querySelector('#save-password');

    const errorPasswordOld = document.createElement('span');
    const errorPasswordNew = document.createElement('span');
    const errorConfirmPassword = document.createElement('span');

    // Thêm các phần tử hiển thị lỗi vào DOM
    passwordOldInput.parentElement.appendChild(errorPasswordOld);
    passwordNewInput.parentElement.appendChild(errorPasswordNew);
    confirmPasswordInput.parentElement.appendChild(errorConfirmPassword);

    // Đặt class và style cho các thông báo lỗi
    [errorPasswordOld, errorPasswordNew, errorConfirmPassword].forEach(error => {
        error.classList.add('error-message');
        error.style.color = 'red';
        error.style.fontSize = '14px';
        error.style.marginTop = '5px';
        error.style.display = 'block';
    });

    // Hàm kiểm tra mật khẩu
    function validatePassword() {
        let isValid = true;

        // Kiểm tra mật khẩu cũ không được để trống
        if (!passwordOldInput.value.trim()) {
            errorPasswordOld.innerText = 'Mật khẩu hiện tại không được để trống.';
            isValid = false;
        } else {
            errorPasswordOld.innerText = '';
        }

        // Kiểm tra mật khẩu mới không được để trống
        if (!passwordNewInput.value.trim()) {
            errorPasswordNew.innerText = 'Mật khẩu mới không được để trống.';
            isValid = false;
        } else {
            errorPasswordNew.innerText = '';
        }

        // Kiểm tra xác nhận mật khẩu mới phải trùng với mật khẩu mới
        if (passwordNewInput.value.trim() !== confirmPasswordInput.value.trim()) {
            errorConfirmPassword.innerText = 'Xác nhận mật khẩu mới không khớp.';
            isValid = false;
        } else {
            errorConfirmPassword.innerText = '';
        }

        // Vô hiệu hóa nút submit nếu không hợp lệ
        savePasswordButton.disabled = !isValid;
    }

    // Gắn sự kiện `input` để kiểm tra khi người dùng nhập
    passwordOldInput.addEventListener('input', validatePassword);
    passwordNewInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);

    // Vô hiệu hóa nút submit ban đầu
    savePasswordButton.disabled = true;
});
</script>

<!-- CSS để tùy chỉnh kiểu thông báo -->
<style>
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: green;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 1000;
        font-size: 16px;
    }
    .error-message {
    color: red;
    font-size: 14px;
    height: 20px; /* Cố định chiều cao */
    display: block; /* Đảm bảo hiển thị dưới dạng khối */
    margin-top: 5px; /* Khoảng cách giữa thông báo lỗi và ô nhập liệu */
}
</style>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>


    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/cart.css">


</head>

<body>
    <div class="wrapper">
        <?php
        include '../includes/header.php';
        ?>
        <main class="main">
            <div class="main-account">
                <div class="main-account-header">
                    <h3>Thông tin tài khoản của bạn</h3>
                    <p>Quản lý thông tin để bảo mật tài khoản</p>
                </div>
                <div class="main-account-body">
                    <div class="main-account-body-col">
                    <form action="" class="info-user" method="post">
    <div class="form-group">
        <label for="infoname" class="form-label">Họ và tên</label>
        <input class="form-control" type="text" name="infoname" id="infoname" placeholder="" value="<?php echo($hoTen); ?>">
        <span class="error-message" id="error-infoname" style="color: red; font-size: 14px;"></span>
    </div>
    <div class="form-group">
        <label for="infoSoDienThoai" class="form-label">Số điện thoại</label>
        <input class="form-control" type="text" name="infoSoDienThoai" id="infoemail" placeholder="Thêm số điện thoại của bạn" value="<?php echo($soDienThoai); ?>">
        <span class="error-message" id="error-infoemail" style="color: red; font-size: 14px;"></span>
    </div>
    <div class="form-group">
        <label for="infoaddress" class="form-label">Địa chỉ</label>
        <input class="form-control" type="text" name="infoaddress" id="infoaddress" placeholder="Thêm địa chỉ của bạn" value="<?php echo($diaChi); ?>">
        <span class="error-message" id="error-infoaddress" style="color: red; font-size: 14px;"></span>
    </div>
    <div>
        <button id="save-info-user" name="information">
            <i class="fa-regular fa-floppy-disk"></i> Lưu thay đổi
        </button>
    </div>
</form>
                    </div>
                    <div class="main-account-body-col">
                    <form action="" class="change-password" method="post">
    <div class="form-group">
        <label for="" class="form-label w60">Mật khẩu hiện tại</label>
        <input class="form-control" type="password" name="passwordOld" id="password-cur-info" placeholder="Nhập mật khẩu hiện tại">
    </div>
    <div class="form-group">
        <label for="" class="form-label w60">Mật khẩu mới</label>
        <input class="form-control" type="password" name="passwordNew" id="password-after-info" placeholder="Nhập mật khẩu mới">
    </div>
    <div class="form-group">
        <label for="" class="form-label w60">Xác nhận mật khẩu mới</label>
        <input class="form-control" type="password" name="confirmPassword" id="password-comfirm-info" placeholder="Nhập lại mật khẩu mới">
    </div>
    <div class="password-message" style="color: red; margin-bottom: 10px;"></div>
    <div>
        <button id="save-password" name="savePassword">
            <i class="fa-regular fa-key"></i> Đổi mật khẩu
        </button>
    </div>
</form>
                    </div>

                </div>
            </div>
        </main>
        <?php
    include '../includes/footer.php';
    ?>
    </div>
    <div class="cart-side">
        <div class="container-cart">
            <div class="header_cart-side">
                <div class="header_cart">
                    <h1>Giỏ hàng</h1>
                </div>
                <div class="close_cart-side">
                    <p>Đóng<img src="../public/themify-icons/SVG/close.svg"></p>
                </div>
            </div>
            <div class="detail-side">
            </div>
            <div class="total-cart-side">
                <div>TỔNG TIỀN:</div>
                <div class="productTotal"><span class="total-amount">0</span><span>đ</span></div>
            </div>
            <div class="cart-buttons">
                <button class="view-cart-btn">XEM GIỎ HÀNG</button>
                <button class="checkout-cart-btn">THANH TOÁN</button>
            </div>
        </div>
    </div>
    <script src="../public/js/main.js"></script>
    <script src="../public/js/cart.js"></script>
</body>

</html>