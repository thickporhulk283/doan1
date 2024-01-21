<?php
session_start();
include './config/db.php';

if (isset($_GET['xoa'])) {
    $prd_id = $_GET['xoa'];
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($user_id !== null) {
        // Sử dụng Prepared Statement để tránh SQL Injection
        $delete_query = "DELETE FROM carts WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("ii", $user_id, $prd_id);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: cart.php');
    exit();
}

if (isset($_POST['add-to-cart'])) {
    $id = $_GET['prd_id'];
    $quantity = $_POST['quantity'];


    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($user_id !== null) {
        // Kiểm tra xem size đã được chọn hay chưa
        if (isset($_POST['size'])) {
            $size = $_POST['size'];

            // Sử dụng Prepared Statement để tránh SQL Injection
            $check_query = "SELECT * FROM carts WHERE user_id = ? AND product_id = ? AND size = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("iis", $user_id, $id, $size);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result && $result->num_rows > 0) {
                // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
                $update_query = "UPDATE carts SET quantity = quantity + ? WHERE user_id = ? AND product_id = ? AND size = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("iiis", $quantity, $user_id, $id, $size);
                $stmt->execute();
                $stmt->close();
            } else {
                // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới vào giỏ hàng của người dùng
                $insert_query = "INSERT INTO carts (user_id, product_id, quantity, size) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("iiis", $user_id, $id, $quantity, $size);
                $stmt->execute();
                $stmt->close();
            }

            header('Location: cart.php');
            exit();
        } else {
            // Nếu size không được chọn, xử lý theo ý bạn (ví dụ: thông báo lỗi)
            echo "Vui lòng chọn size.";
        }
    } else {
        header('Location: cart.php');
        exit();
    }
}
?>
