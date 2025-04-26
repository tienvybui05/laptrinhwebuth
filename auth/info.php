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
$hoTen = $row['hoTen'];
$soDienThoai = $row['soDienThoai'];
$diaChi = $row['diaChi'];

// --- Đoạn này giữ ---
$msgInformation = "";
if (isset($_SESSION['msgInformation'])) {
    $msgInformation = $_SESSION['msgInformation'];
    unset($_SESSION['msgInformation']);
}
// --- Kết thúc ---

if(isset($_POST['information'])) {
    if(!empty($_POST['infoname'])) {
        $hoTen = htmlspecialchars(trim($_POST['infoname']));
    }
    if(!empty($_POST['infoSoDienThoai'])) {
        $soDienThoai = htmlspecialchars(trim($_POST['infoSoDienThoai']));
    }
    if(!empty($_POST['infoaddress'])) {
        $diaChi = htmlspecialchars(trim($_POST['infoaddress']));
    }

    // --- Chỗ này sửa: Gọi hàm updateInfoUser ---
    $result = $user->updateInfoUser($id, $hoTen, $soDienThoai, $diaChi);

    if ($result) {
        $_SESSION['msgInformation'] = 'Cập nhật thông tin thành công!';
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['msgInformation'] = 'Cập nhật thất bại!';
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../public/css/cart.css">


</head>
<body>
    <div class="wrapper">
        <?php include '../includes/header.php'; ?>
        <main class="main">
            <div class="main-account">
                <h2>Cập nhật thông tin</h2>
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

                <?php if ($msgInformation): ?>
                    <p style="color: green;"><?php echo $msgInformation; ?></p>
                <?php endif; ?>

            </div>
        </main>
        <?php include '../includes/footer.php'; ?>
    </div>
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
<script src="../public/js/info.js"> </script>

</body>
</html>
