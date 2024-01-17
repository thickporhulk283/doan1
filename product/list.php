<?php
// Khởi tạo giá trị mặc định cho biến $selected_tables
$selected_tables = ['products']; // Bảng mặc định là 'products'
$query = mysqli_query($conn, "SELECT * FROM products");

// Kiểm tra nếu có dữ liệu được gửi đi từ form
if (isset($_POST['sbm'])) {
    // Xác minh rằng dữ liệu được gửi qua phương thức POST là an toàn và hợp lệ
    $selected_tables = isset($_POST['selected_tables']) ? $_POST['selected_tables'] : ['products']; // Cập nhật bảng dựa trên lựa chọn của người dùng
    // Xử lý dữ liệu đầu vào (để ngăn chặn các loại tấn công như SQL Injection hoặc XSS)
    $selected_tables = array_map('htmlspecialchars', $selected_tables);
    $selected_tables_str = implode(', ', $selected_tables);
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
<style>
    td a img {
        width: 40px;
    }
</style>

<body style="background-color: #1a1a1a; padding-top: 30px;">
    <div class="container">
        <div class="container-fluid">
            <div class="card-header text-align">
                <h2 style="color: #ffffff;">DANH SÁCH SẢN PHẨM</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh sản phẩm</th>
                            <th>Giá sản phẩm</th>
                            <th>Số lượng sản phẩm</th>
                            <th>Mô tả</th>
                            <th>Thương hiệu</th>
                            <th>Loại</th>
                            <th>Sửa</a></th>
                            <th>Xóa</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['prd_name']; ?></td>
                                <td>
                                    <img style="width: 100px;" src="img/<?php echo $row['img']; ?>">
                                </td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['brand']; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td><a href="prd-management.php?page_layout=sua&id=<?php echo $row['prd_id']; ?>"><img src="./img/edit.png" alt=""></a></td>
                                <td><a onclick="return del('<?php echo $row['prd_name']; ?>')" href="prd-management.php?page_layout=xoa&id=<?php echo $row['prd_id']; ?>"><img src="./img/delete.png" alt=""></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a class="btn btn-success" href="prd-management.php?page_layout=them">Thêm sản phẩm</a>
                <a href="index.php">trang chủ</a>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    function del(name) {
        return confirm("Bạn có chắc muốn xóa sản phẩm: " + name + " không?");
    }
</script>