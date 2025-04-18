<?php
session_start();
session_unset(); // Xóa tất cả biến trong session
session_destroy(); // Hủy toàn bộ session

// Chuyển hướng về trang chủ hoặc trang đăng nhập
header("Location: index.php"); 
exit();
?>