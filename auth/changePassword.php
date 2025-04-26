<?php 
session_start();
if(!isset($_SESSION['idUser'])) {
    header("location: login.php");
    exit;
}
include '../admin/entities/user.php';
$user = new user();
$id = $_SESSION['idUser'];
$row = $user->getUserById($id);
$username = $row['username'];

// --- Đoạn này xử lý session thông báo ---
$msgPassword = "";
if (isset($_SESSION['msgPassword'])) {
    $msgPassword = $_SESSION['msgPassword'];
    unset($_SESSION['msgPassword']); // Hiển thị xong rồi xóa luôn
}
// --- Kết thúc đoạn xử lý ---

if(isset($_POST['savePassword'])) {
    $passwordOld = htmlspecialchars(trim($_POST['passwordOld'])); 
    $passwordNew = htmlspecialchars(trim($_POST['passwordNew']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword']));

    // Kiểm tra nhập đủ
    if ($passwordOld && $passwordNew && $confirmPassword) {
        $checkAccount = $user->isAccount($username, $passwordOld); // Kiểm tra mật khẩu cũ

        if($checkAccount === false) {
            $_SESSION['msgPassword'] = "Mật khẩu hiện tại không chính xác!";
        } else {
            if ($passwordNew === $confirmPassword) {
                $updateResult = $user->updatePasswordUser($id, $passwordNew); // Gọi updatePasswordUser()

                if ($updateResult) {
                    $_SESSION['msgPassword'] = 'Đổi mật khẩu thành công!';
                } else {
                    $_SESSION['msgPassword'] = 'Cập nhật mật khẩu thất bại!';
                }
            } else {
                $_SESSION['msgPassword'] = "Xác nhận mật khẩu mới không khớp!";
            }
        }
    } else {
        $_SESSION['msgPassword'] = "Vui lòng nhập đầy đủ thông tin!";
    }

    header("Location: ".$_SERVER['PHP_SELF']); // Redirect về chính nó, để tránh POST lại
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/cart.css">



  
</head>
<body>
    <div class="wrapper">
        <?php include '../includes/header.php'; ?>
        <main class="main">
            <div class="main-account">
                <h2>Đổi mật khẩu</h2>
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

                <?php if ($msgPassword): ?>
                    <p style="color: red;"><?php echo $msgPassword; ?></p>
                <?php endif; ?>

            </div>
        </main>
        
        <?php include '../includes/footer.php'; ?>
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
    <script src="../public/js/info.js"> </script>
    <script src="../public/js/cart.js"></script>
    <script src="../public/js/main.js"></script>

</body>
</html>
