<?php
session_start();
include './config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="./assets/slider/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="./assets/slider/owlcarousel/assets/owl.theme.default.css">
    <link rel="icon" href="./img/favicon.png" type="image/png">
    <script src="./assets/slider/jquery.min.js"></script>
    <script src="./assets/slider/owlcarousel/owl.carousel.min.js"></script>
    <title>DUM</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];
    $ward = $_POST['ward'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];
    $totals = $_POST['total'];

    // Lặp qua danh sách sản phẩm để thêm vào cơ sở dữ liệu
    for ($i = 0; $i < count($product_ids); $i++) {
        $product_id = $product_ids[$i];
        $quantity = $quantities[$i];
        $total = $totals[$i];

        // Thực hiện câu truy vấn để thêm thông tin vào bảng orders
        $sql = "INSERT INTO orders (client_id, client_name, ward, district, province, phone, email, product_id, quantity, total)
                VALUES ('$client_id', '$client_name', '$ward', '$district', '$province', '$phone', '$email', '$product_id', '$quantity', '$total')";

        // Thực thi truy vấn và kiểm tra kết quả
        if ($conn->query($sql) !== TRUE) {
            echo "Lỗi khi thêm đơn hàng: " . $conn->error;
        }
    }

    // Đóng kết nối sau khi thực hiện xong
    $conn->close();
    echo '<div style="font-size:30px;">';
    echo '<div id="thank-box">
    <p>Cảm ơn bạn đã mua hàng</p>
    <a href="">Xem đơn hàng</a><br>
    <a href="index.php">Tiếp tục mua sắm</a>
    </div>';
}
?>
</body> 
</html>
