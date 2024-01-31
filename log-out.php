<?php
session_start();
// Hủy phiên (session) để đăng xuất người dùng
session_destroy();
// Điều hướng người dùng về trang chính hoặc trang đăng nhập
$previousPage = isset($_SESSION['previousPage']) ? $_SESSION['previousPage'] : 'index.php';
header("Location: $previousPage");
$_SESSION['previousPage'] = $_SERVER['HTTP_REFERER'];
?>
