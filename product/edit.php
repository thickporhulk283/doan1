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
    if ($_FILES['dt_img1']['name'] != '') {
        $dt_img1 = $_FILES['dt_img1']['name'];
        $img_tmp = $_FILES['dt_img1']['tmp_name'];
        move_uploaded_file($img_tmp, 'img/' . $dt_img1);
    } else {
        $dt_img1 = $row_up['dt_img1'];
    }
    if ($_FILES['dt_img2']['name'] != '') {
        $dt_img2 = $_FILES['dt_img2']['name'];
        $img_tmp = $_FILES['dt_img2']['tmp_name'];
        move_uploaded_file($img_tmp, 'img/' . $dt_img1);
    } else {
        $dt_img2 = $row_up['dt_img2'];
    }
    if ($_FILES['dt_img3']['name'] != '') {
        $dt_img3 = $_FILES['dt_img3']['name'];
        $img_tmp = $_FILES['dt_img3']['tmp_name'];
        move_uploaded_file($img_tmp, 'img/' . $dt_img1);
    } else {
        $dt_img3 = $row_up['dt_img3'];
    }
    if ($_FILES['dt_img4']['name'] != '') {
        $dt_img4 = $_FILES['dt_img4']['name'];
        $img_tmp = $_FILES['dt_img4']['tmp_name'];
        move_uploaded_file($img_tmp, 'img/' . $dt_img1);
    } else {
        $dt_img4 = $row_up['dt_img4'];
    }
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];

    $sql = "UPDATE products SET prd_name = '$prd_name', img = '$img', price = '$price', quantity = '$quantity',
    description = '$description', brand = '$brand', type = '$type', dt_img1 = '$dt_img1',
    dt_img2 = '$dt_img2', dt_img3 = '$dt_img3', dt_img4 = '$dt_img4'  WHERE prd_id = $id";
    
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
                        <label for="prd-img">dt1</label><br>
                        <input id="prd-img" type="file" name="dt_img1">
                    </div>
                    <div class="form-group">
                        <label for="prd-img">dt2</label><br>
                        <input id="prd-img" type="file" name="dt_img2">
                    </div>
                    <div class="form-group">
                        <label for="prd-img">dt3</label><br>
                        <input id="prd-img" type="file" name="dt_img3">
                    </div>
                    <div class="form-group">
                        <label for="prd-img">dt4</label><br>
                        <input id="prd-img" type="file" name="dt_img4">
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