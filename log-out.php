<?php
session_start();
// Hủy phiên (session) để đăng xuất người dùng
session_destroy();
// Điều hướng người dùng về trang chính hoặc trang đăng nhập
header("Location: index.php");
?>
