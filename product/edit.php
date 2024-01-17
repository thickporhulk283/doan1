<?php
$id = $_GET['id'];

$sql_up = "SELECT * FROM products WHERE prd_id = $id";
$query_up = mysqli_query($conn, $sql_up);
$row_up = mysqli_fetch_assoc($query_up);

if (isset($_POST['sbm'])) {
    $prd_name = $_POST['prd_name'];

    if ($_FILES['img']['name'] != '') {
        $img = $_FILES['img']['name'];
        $img_tmp = $_FILES['img']['tmp_name'];
        move_uploaded_file($img_tmp, 'img/' . $img);
    } else {
        $img = $row_up['img'];
    }
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];

    $sql = "UPDATE products SET prd_name = '$prd_name', img = '$img', price = '$price', quantity = '$quantity', description = '$description', brand = '$brand', type = '$type'  WHERE prd_id = $id";
    $query = mysqli_query($conn, $sql);
    header('location: prd-management.php?page_layout=danhsach');
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
    .form-group {
        color: #ffffff;
    }
</style>

<body style="background-color: #1a1a1a; padding-top: 30px;">
    <div class="container">
        <div class="container-fluid">
            <div class="card-header text-align">
                <h2 style="color: #ffffff;">CẬP NHẬT SẢN PHẨM</h2>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prd-name">Tên sản phẩm</label>
                        <input type="text" name="prd_name" id="prd-name" class="form-control" required value="<?php echo $row_up['prd_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="prd-img">Ảnh sản phẩm</label><br>
                        <input id="prd-img" type="file" name="img">
                    </div>
                    <div class="form-group">
                        <label for="prd-pri">Giá sản phẩm</label>
                        <input type="number" name="price" id="prd-pri" class="form-control" required value="<?php echo $row_up['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="prd-q">Số lượng sản phẩm</label>
                        <input type="number" name="quantity" id="prd-q" class="form-control" required value="<?php echo $row_up['quantity']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="prd-des">Mô tả sản phẩm</label>
                        <textarea name="description" id="prd-des" class="form-control" cols="30" rows="10" required value="<?php echo $row_up['description']; ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prd-br">Thương hiệu</label>
                        <input type="text" name="brand" id="prd-br" class="form-control"  required value="<?php echo $row_up['brand']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="prd-br">Loại</label>
                        <input type="text" name="type" id="prd-ty" class="form-control"  required value="<?php echo $row_up['type']; ?>">
                    </div>
                    <button name="sbm" class="btn btn-success" type="submit">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>