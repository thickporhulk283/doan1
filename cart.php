<?php
session_start();
include './config/db.php';

if (isset($_SESSION['users'])) {
    echo '<div style="padding-bottom: 10px;font-size: 25px;font-weight:bold;color:#004fac;">
                    <img id="trolley" src="./img/trolley.png" alt="">Xin chào <span style="color: #ee4d2d;">' . $_SESSION['fullname'] . '!</span> hãy mua sắm vui vẻ.<img id="hi" src="./img/hi.png" alt=""></div>';

    echo '<form action="check-out.php?action=buy" method="post">';
    echo '<table>';
    echo '<tr>';
    echo '<th style="width: 70px;"></th>';
    echo '<th>Tên sản phẩm</th>';
    echo '<th>Hình ảnh</th>';
    echo '<th>Số lượng</th>';
    echo '<th>Giá tiền</th>';
    echo '<th>Thành tiền</th>';
    echo '<th>Xóa sản phẩm</th>';
    echo '</tr>';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT products.prd_name, products.price, products.img, carts.quantity, carts.product_id
            FROM carts
            INNER JOIN products ON carts.product_id = products.prd_id
            WHERE carts.user_id = $user_id";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td><input type="checkbox" name="selected_products[]" value="' . $row['product_id'] . '"></td>';
            echo '<td>' . $row['prd_name'] . '</td>';
            echo '<td><img src="img/' . $row['img'] . '" alt=""></td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td><span style="font-weight: bold; color: #EE4D2D;">' . number_format($row['price'], 0, ',', '.') . ' VND</span></td>';
            echo '<td  style="font-weight: bold; color: #EE4D2D;">' . number_format($row['quantity'] * $row['price'], 0, ',', '.') . ' VND</td>';
            echo '<td><a href="add-to-cart.php?xoa=' . $row['product_id'] . '">xóa</a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="7">Giỏ hàng của bạn đang trống.</td></tr>';
    }

    echo '</table>';
    echo '<div style="padding: 30px 0;"><button id="buy-btn" type="submit">MUA NGAY</button></div>';
    echo '</form>';

    $conn->close();
} else {
    echo '<div class="text-align"><h1>Đăng nhập để xem giỏ hàng của bạn</h1><img style="width: 150px;" src="./img/View-cart.png" alt=""></div>';
}
