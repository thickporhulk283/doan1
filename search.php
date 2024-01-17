<?php
session_start();
include './config/db.php';

// Xử lý từ khóa tìm kiếm
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $sql = "SELECT * FROM products WHERE prd_name LIKE '%$keyword%'";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    
        // Kiểm tra xem từ khóa có giá trị hay không
        if (!empty($keyword)) {
            $sql = "SELECT * FROM products WHERE prd_name LIKE '%$keyword%'"; // Thêm điều kiện sắp xếp
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<div id="q-prd" >';
                echo '<p>Tìm thấy <span style="color: red;">' . $result->num_rows . '</span> sản phẩm cho từ khóa "' . $keyword . '"</p>';
                echo '</div>';
                echo '<ul id="list-product" class="list-style d-flex flex-wrap">';
                while ($row = $result->fetch_assoc()) {
                    echo '<li style="padding: 10px;width: 20%;">';
                    echo '<a href="">';
                    echo '<div class="product">';
                    echo '<div class="img-prd">';
                    echo '<img style="width: 100%;height: 150px;" src="img/' . $row['img'] . '" alt="' . $row['prd_name'] . '">';
                    echo '</div>';
                    echo '<div class="infor-prd">';
                    echo '<a style="margin: 0;">' . $row['prd_name'] . '</a>';
                    echo '<span style="font-weight: bold; color: #EE4D2D;">' . number_format($row['price'], 0, ',', '.') . ' đ</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<div id="q-prd" >';
                echo '<p>Tìm thấy <span style="color: red;">' . $result->num_rows . '</span> sản phẩm cho từ khóa "' . $keyword . '"</p>';
                echo '<p>Xin lỗi, không có kết quả bạn cần tìm</p>';
                echo '</div>';
            }
        } else {
            echo '<div id="q-prd" >';
            echo '<p style="color: red;">Bạn phải nhập từ khóa để thực hiện tìm kiếm!</p>';
            echo '</div>';
        }
    }
    ?>
</body>

</html>