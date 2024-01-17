<?php
session_start();
include './config/db.php';
$error = '';

if (isset($_POST["submit"])) {
    if ($_POST["username"] != '' && $_POST["password"] != '') {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password = md5($password);

        // Sử dụng các biến để tránh tấn công SQL injection
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        // Thực hiện truy vấn SQL
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if ($username === "dumprovip" && $password === "5c9e1080b43767f06310e6e632c836e5") {
            header("location: management.php");
            exit();
        } else {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                $_SESSION['users'] = $user_data['username'];
                $_SESSION['fullname'] = $user_data['fullname'];
                $_SESSION['user_id'] = $user_data['id'];

                header("Location: index.php");
                exit(); 
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }
    } else {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/shaded.css">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.css">
    <link rel="icon" href="./img/logo.png" type="image/png">
    <title>DUM</title>
</head>
<body style="background-color: #1a1a1a; padding-top: 30px;">
    <div class="container">
        <div id="dum" class="d-flex justify-content-between">
            <a href="index.php"><img src="./img/logo.png" alt=""></a>
            <div style="line-height: 200px;color: #ffffff;width: 280px;">
                Bạn chưa đăng ký? 
                <a id="reg-now" href="reg.php">Đăng ký ngay</a>
            </div>
        </div>
        <div id="lr-page">
            <form action="" method="post">
                <div class="form-box">
                    <label for="username"><i class="fa-regular fa-user"></i> Tên đăng nhập</label><br>
                    <input type="text" name="username" id="username" placeholder="Nhập tên đăng nhập của bạn">
                </div>
                <div class="form-box">
                    <label for="password"><i class="fa-solid fa-key"></i> Mật khẩu</label><br>
                    <input type="password" name="password" id="password" placeholder="Nhập mật khẩu">
                </div>
                <div style="margin-top: 6px;" class="form-box">
                    <input id="btn-log" type="submit" name="submit" value="Đăng Nhập">
                </div>
                <?php if ($error != '') : ?>
                    <!-- Hiển thị thông báo lỗi -->
                    <div class="text-align" style="color: #ffffff;"><i class="fa-solid fa-xmark" style="color: #fc0303;"></i> <?php echo $error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>