<?php
session_start(); // Bắt đầu session

// Kiểm tra nếu đã đăng nhập
if (isset($_SESSION['idUser'])) {
    header("Location: ../public/index.php"); // Chuyển hướng đến trang index
    exit;
}

include '../admin/entities/user.php';
$user = new user();
$hoTen = $soDienThoai = $username = $password = $diaChi = "";

// Xử lý form đăng ký
if (isset($_POST['submit'])) {
    $hoTen = test_input($_POST['fullname']);
    $soDienThoai = test_input($_POST['soDienThoai']);
    $diaChi = test_input($_POST['diaChi']);
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    if ($user->isUsernameNotExist($username)) {
        $result = $user->addUser($hoTen, $soDienThoai, $username, $password, $diaChi, "customer");
        header("Location: ../public/index.php");
        exit;
    } else {
        $_SESSION['error'] = "Username của bạn đã tồn tại";
        header("Location: register.php"); // Tải lại trang
        exit;
    }
}

function test_input($data) {
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
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">

</head>

<body>
    <div class="wrapper">
        <?php
    include '../includes/header.php';
?>
        <main class="main-signup">
            <div class="formdangky">
                <form id="signup" name="signup" method="post" action="#">
                    <h2>Đăng ký</h2>

                    <div class="input-group">
                        <label for="fullname">Nhập tên của bạn</label>
                        <i class="ti-user"></i> <!-- Icon Themify -->
                        <input name="fullname" id="fullname" type="text" value="" required />
                        <span class="error-message" id="error-fullname" style="color: red; font-size: 14px;"></span>
                    </div>

                    <div class="input-group">
                        <label for="soDienThoai">Nhập số điện thoại của bạn</label>
                        <i class="ti-mobile"></i> <!-- Icon Themify -->
                        <input name="soDienThoai" id="soDienThoai" type="text" value="" required />
                        <span class="error-message" id="error-phone" style="color: red; font-size: 14px;"></span>
                    </div>

                    <div class="input-group">
                        <label for="diaChi">Nhập địa chỉ của bạn</label>
                        <i class="ti-location-pin"></i> <!-- Icon Themify -->
                        <input name="diaChi" id="diaChi" type="text" value="" required />
                        <span class="error-message" id="error-diaChi" style="color: red; font-size: 14px;"></span>
                    </div>

                    <div class="input-group">
                        <label for="username"><i class="ti-user"></i>Nhập username</label>
                        <i class="ti-user"></i> <!-- Icon Themify -->
                        <input name="username" id="username" type="text" value="" required />
                        <span class="error-message" id="error-username" style="color: red; font-size: 14px;"></span>
                    </div>

                    <div class="input-group">
                        <label for="password">Mật khẩu</label>
                        <i class="ti-lock"></i> <!-- Icon Themify -->
                        <input name="password" id="password" type="password" required />
                        <span class="error-message" id="error-password" style="color: red; font-size: 14px;"></span>
                    </div>

                    <div class="input-group">
                        <label for="confirm-password">Nhập lại mật khẩu</label>
                        <i class="ti-lock"></i> <!-- Icon Themify -->
                        <input name="confirm-password" id="confirm-password" type="password" required />
                        <span class="error-message" id="error-confirm-password"
                            style="color: red; font-size: 14px;"></span>
                    </div>

                    <div class="hong-bao-loi">
                        <p style="color: red; font-size: 14px;">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo $_SESSION['error'];
                                unset($_SESSION['error']); // Xóa lỗi sau khi hiển thị
                            }
                            ?>
                        </p>
                    </div>
                    <div class="subm">
                        <input type="submit" name="submit" id="submit" value="Đăng ký" />
                    </div>
                </form>

            </div>
        </main>
        <?php
    include '../includes/footer.php';
    ?>
    </div>
    <script src="../public/js/main.js"></script>
</body>

</html>