<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

if (isset($_SESSION['idUser'])) {
   unset($_SESSION['idUser']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đăng xuất...</title>
    <script>
        // Xóa localStorage & sessionStorage trước khi chuyển trang
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = '../public/index.php'; // Redirect bằng JS
    </script>
</head>     
<body>
    <p>Đang đăng xuất...</p>
</body>
</html>
