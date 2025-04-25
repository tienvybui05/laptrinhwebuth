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

if (isset($_POST['information'])) {
    // Xử lý cập nhật thông tin
    if (!empty($_POST['infoname'])) {
        $hoTen = test_input($_POST['infoname']);
    } else {
        $hoTen = ''; // Hoặc giá trị mặc định
    }

    if (!empty($_POST['infoSoDienThoai'])) {
        $soDienThoai = test_input($_POST['infoSoDienThoai']);
    } else {
        $soDienThoai = ''; // Hoặc giá trị mặc định
    }

    if (!empty($_POST['infoaddress'])) {
        $diaChi = test_input($_POST['infoaddress']);
    } else {
        $diaChi = ''; // Hoặc giá trị mặc định
    }

    // Không thay đổi mật khẩu khi cập nhật thông tin
    $result = $user->updateUser($id, $hoTen, $soDienThoai, $username, $password, $diaChi, "customer");

    if ($result) {
        $msgInformation = 'Cập nhật thông tin thành công!';
    } else {
        $msgInformation = 'Cập nhật thông tin thất bại!';
    }
}

if (isset($_POST['savePassword'])) {
    // Xử lý cập nhật mật khẩu
    $passwordOld = test_input($_POST['passwordOld']);
    $result = $user->isAccount($username, $passwordOld); // Kiểm tra mật khẩu cũ

    if ($result === false) {
        $msgPassword = "Nhập sai mật khẩu!";
    } else {
        $passwordNew = test_input($_POST['passwordNew']);

        // Mã hóa mật khẩu mới trước khi lưu
        $passwordNewHash = password_hash($passwordNew, PASSWORD_DEFAULT);

        // Chỉ cập nhật mật khẩu mới
        $result = $user->updateUser($id, $hoTen, $soDienThoai, $username, $passwordNewHash, $diaChi, "customer");

        if ($result) {
            $msgPassword = 'Cập nhật mật khẩu thành công!';
        } else {
            $msgPassword = 'Cập nhật mật khẩu thất bại!';
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
<script src="../public/js/main.js"></script>
<script src="../public/js/info.js"> </script>
</body>

</html>