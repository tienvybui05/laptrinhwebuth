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
</head>
<body>
    <div class="wrapper">
        <?php include '../includes/header.php'; ?>
        <main class="main">
            <div class="main-account">
                <h3>Cập nhật thông tin</h3>
                <form action="" method="post" class="info-user">
                    <div class="form-group">
                        <label for="infoname" class="form-label">Họ và tên</label>
                        <input class="form-control" type="text" name="infoname" id="infoname" value="<?php echo htmlspecialchars($hoTen); ?>">
                    </div>
                    <div class="form-group">
                        <label for="infoSoDienThoai" class="form-label">Số điện thoại</label>
                        <input class="form-control" type="text" name="infoSoDienThoai" id="infoSoDienThoai" value="<?php echo htmlspecialchars($soDienThoai); ?>">
                    </div>
                    <div class="form-group">
                        <label for="infoaddress" class="form-label">Địa chỉ</label>
                        <input class="form-control" type="text" name="infoaddress" id="infoaddress" value="<?php echo htmlspecialchars($diaChi); ?>">
                    </div>
                    <button id="save-info-user" name="information">
                        <i class="fa-regular fa-floppy-disk"></i> Lưu thay đổi
                    </button>
                </form>

                <?php if ($msgInformation): ?>
                    <p style="color: green;"><?php echo $msgInformation; ?></p>
                <?php endif; ?>

            </div>
        </main>
        <?php include '../includes/footer.php'; ?>
    </div>
</body>
</html>
