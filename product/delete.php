<?php
$id = $_GET['id'];
$sql = "delete from products where prd_id = $id";
$query = mysqli_query($conn, $sql);
header('location: prd-management.php?page_layout=danhsach');
?>