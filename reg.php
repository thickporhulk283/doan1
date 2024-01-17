<?php
session_start();
include './config/db.php';
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
            <div style="line-height: 200px;color: #ffffff;">
                <a id="reg-now" href="log.php">Đăng nhập</a>
            </div>
        </div>
        <div id="lr-page">
            <form class="flex-direction" action="reg.php" method="post">
                <div class="form-box">
                    <label for="fullname"><i class="fa-regular fa-pen-to-square"></i> Họ tên</label><br>
                    <input type="text" name="fullname" id="fullname" placeholder="Nhập họ tên đầy đủ">
                </div>
                <div class="form-box">
                    <label for="email"><i class="fa-regular fa-envelope"></i> Email</label><br>
                    <input type="email" name="email" id="email" placeholder="Nhập địa chỉ email">
                </div>
                <div class="form-box">
                    <label for="username-r"> <i class="fa-regular fa-user"></i> Tên đăng nhập</label><br>
                    <input type="text" name="username" id="username-r" placeholder="Nhập tên đăng nhập của bạn">
                </div>
                <div class="form-box">
                    <label for="password-r"><i class="fa-solid fa-key"></i> Mật khẩu</label><br>
                    <input type="password" name="password" id="password-r" placeholder="Nhập mật khẩu">
                </div>
                <div class="form-box">
                    <label for="confirm-password"><i class="fa-regular fa-square-check"></i> Xác nhận mật khẩu</label><br>
                    <input type="password" name="confirm-password" id="confirm-password" placeholder="Xác nhận mật khẩu">
                </div>
                <div style="margin-top: 6px;" class="form-box">
                    <input id="btn-reg" type="submit" name="btn-reg" value="Đăng kí">
                </div>
                <?php
                if (isset($_POST['btn-reg'])) {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $fullname = $_POST['fullname'];
                    $password = $_POST['password'];
                    $check_username_query = "SELECT * FROM users WHERE username='$username'";
                    $result = $conn->query($check_username_query);


                    if (!empty($username) && !empty($email) && !empty($fullname) && !empty($password)) {
                        if ($result->num_rows > 0) {
                            echo '<div class="text-align" style="color: #ffffff;"><i class="fa-solid fa-xmark" style="color: #fc0303;"></i> Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác!</div>';
                        } else {
                            $hashed_password = md5($password); // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
                            $sql = "INSERT INTO users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$hashed_password')";
                            if ($conn->query($sql) === TRUE) {
                                $_SESSION['users'] = $username;
                                $_SESSION['fullname'] = $fullname;
                                $_SESSION['user_id'] = $conn->insert_id; // ID của người dùng vừa được thêm

                                header("Location: index.php");
                                exit();
                            } else {
                                echo "Lỗi: " . $conn->error;
                            }
                        }
                    } else {
                        echo '<div class="text-align" style="color: #ffffff;"><i class="fa-solid fa-xmark" style="color: #fc0303;"></i> Vui lòng nhập đầy đủ thông tin!</div>';
                    }
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordInput = document.getElementById("password-r");
        const confirmPasswordInput = document.getElementById("confirm-password");
        const registerButton = document.getElementById("btn-reg");

        registerButton.addEventListener("click", function(e) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                e.preventDefault();
                alert("Mật khẩu không trùng khớp.");
            }
        });
    });
</script>