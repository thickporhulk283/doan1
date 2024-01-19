<?php
session_start();
include './config/db.php';

if (isset($_GET['xoa'])) {
    // Xử lý xóa sản phẩm khỏi giỏ hàng của người dùng trong cơ sở dữ liệu
    $prd_id = $_GET['xoa'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Kiểm tra xem user_id đã được thiết lập không

    if ($user_id !== null) {
        $delete_query = "DELETE FROM carts WHERE user_id = $user_id AND product_id = $prd_id";
        $conn->query($delete_query);
    }

    header('Location: cart.php');
    exit();
}

if (isset($_POST['add-to-cart'])) {
    $id = $_GET['prd_id'];
    $quantity = $_POST['quantity'];

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Kiểm tra xem user_id đã được thiết lập không

    if ($user_id !== null) {
        $check_query = "SELECT * FROM carts WHERE user_id = $user_id AND product_id = $id";
        $result = $conn->query($check_query);

        if ($result && $result->num_rows > 0) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            $update_query = "UPDATE carts SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $id";
            $conn->query($update_query);
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng của người dùng
            $insert_query = "INSERT INTO carts (user_id, product_id, quantity) VALUES ($user_id, $id, $quantity)";
            $conn->query($insert_query);
        }
    }

    header('Location: cart.php');
    exit();
}
?>
