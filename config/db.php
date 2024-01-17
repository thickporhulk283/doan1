<?php
$conn = mysqli_connect('localhost','root','','doan1');
if($conn) {
    mysqli_query($conn, "SET NAMES 'UTF8'");
}else{
    echo 'ket noi that bai';
}
?>