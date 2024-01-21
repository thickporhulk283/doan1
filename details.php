<?php
session_start();
include './config/db.php';
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
    <link rel="stylesheet" href="./assets/slider/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="./assets/slider/owlcarousel/assets/owl.theme.default.css">
    <link rel="icon" href="./img/logo.png" type="image/png">
    <script src="./assets/slider/jquery.min.js"></script>
    <script src="./assets/slider/owlcarousel/owl.carousel.min.js"></script>
    <title>DUM</title>
</head>

<body>
    <div id="main">
        <div id="header">
            <div id="header-head">
                <div class="container d-flex justify-content-between">
                    <p>Uy tín, chất lượng, chính hãng</p>
                    <P><i class="fa-solid fa-phone"></i> 0977 977 777</P>
                    <?php
                    if (isset($_SESSION['users'])) {
                        // đã đăng nhập
                        echo '<div id="acc" style="padding-left: 80.82px;">';
                        echo '<div id="acc-btn">Tài khoản';
                        echo '<div style="padding-top: 5px;">';
                        echo '<div id="sub-acc">';
                        echo '<a href=""><i class="fa-solid fa-user"></i> Hồ sơ</a>';
                        echo '<a href="log-out.php"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        // chưa đăng nhập
                        echo '<div id="acc" class="d-flex justify-content-between">';
                        echo '<a href="./log.php">Đăng nhập</a>';
                        echo '<a href="./reg.php">Đăng kí</a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div id="header-body" class="d-flex justify-content-between">
                <div id="logo">
                    <a href="index.php"><img src="./img/logo.png" alt=""></a>
                </div>
                <form id="box-search" action="search.php" method="get">
                    <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm tại đây">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <div id="cart">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="container d-flex">
                <?php
                if (isset($_GET['id'])) {
                    $product_id = $_GET['id'];

                    // Thực hiện truy vấn với INNER JOIN để kết hợp dữ liệu từ cả hai bảng
                    $sql = "SELECT * FROM products WHERE prd_id = $product_id"; // Sửa từ $_id thành $product_id
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();

                        // Kiểm tra dữ liệu sản phẩm tồn tại
                        if ($row) {
                            echo '<div class="details-box text-align">';
                            echo '<div class="dt-img">';
                            echo '<img src="img/' . $row['dt_img1'] . '" alt="' . $row['prd_name'] . '">';
                            echo '</div>';
                            echo '<div class="dt-img">';
                            echo '<img src="img/' . $row['dt_img2'] . '" alt="' . $row['prd_name'] . '">';
                            echo '</div>';
                            echo '<div class="dt-img">';
                            echo '<img src="img/' . $row['dt_img3'] . '" alt="' . $row['prd_name'] . '">';
                            echo '</div>';
                            echo '<div class="dt-img">';
                            echo '<img src="img/' . $row['dt_img4'] . '" alt="' . $row['prd_name'] . '">';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="details-box">';
                            echo '<h2>' . $row['prd_name'] . '</h2><hr>';
                            echo '<h1 style="color: #EE4D2D;">' . number_format($row['price'], 0, ',', '.') . ' đ</h1><hr>';
                            echo '<h3>Mô tả</h3>';
                            echo '<p style="margin: 0;">' . $row['description'] . '</p>';
                            // form add-to-cart.
                            echo '<form id="" method="post" action="add-to-cart.php?prd_id=' . $row['prd_id'] . '">';
                            echo '<div id="size-box">';
                            echo '<label for="size38">
                                <input type="radio" id="size38" name="size" value="38"> 38
                            </label>';
                            echo '<label for="size39">
                                <input type="radio" id="size39" name="size" value="39"> 39
                            </label>';
                            echo '<label for="size40">
                                <input type="radio" id="size40" name="size" value="40"> 40
                            </label>';
                            echo '<label for="size41">
                                <input type="radio" id="size41" name="size" value="41"> 41
                            </label>';
                            echo '<label for="size42">
                                <input type="radio" id="size42" name="size" value="42"> 42
                            </label>';
                            echo '<label for="size43">
                                <input type="radio" id="size43" name="size" value="43"> 43
                            </label>';
                            echo '</div>';
                            echo '<div id="quantity-add">';
                            echo '    <button type="button" id="decrease-btn">-</button>';
                            echo '    <input type="text" name="quantity" id="quantity" value="1" readonly>';
                            echo '    <button type="button" id="increase-btn">+</button>';
                            echo '</div>';
                            echo '<button type="submit" name="add-to-cart" id="add-to-cart-btn">Thêm vào giỏ hàng <img style="width: 35px;" src="./img/cart.png" alt=""></button>';
                            echo '</form>';

                            // end form
                            echo '</div>';
                        } else {
                            // Không có dữ liệu sản phẩm
                            echo 'Không có sản phẩm nào.';
                        }
                    } else {
                        // Truy vấn không thành công
                        echo 'Lỗi trong quá trình truy vấn sản phẩm.';
                    }
                }
                ?>
            </div>
        </div>
        <div id="footer">
            <div class="container d-flex justify-content-between">
                <div class="footer-box">
                    <img src="./img/logo.png" alt="">
                </div>
                <div class="footer-box">
                    <h3>Contact</h3>
                    <p><i class="fa-solid fa-location-dot"></i> 28 - Tran Hung Dao - TP.Dong Hoi</p>
                    <p><i class="fa-solid fa-phone"></i> 0977 977 777</p>
                    <p><i class="fa-solid fa-envelope"></i> Dumsupport@gmail.com</p>
                </div>
                <div class="footer-box">
                    <h3>About the company</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et mauris id purus mattis semper.</p>
                    <div style="padding-top: 20px;">
                        <a href=""><i class="fa-brands fa-facebook"></i></a>
                        <a href=""><i class="fa-brands fa-instagram"></i></a>
                        <a href=""><i class="fa-brands fa-twitter"></i></a>
                        <a href=""><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div id="copy-right"><i class="fa-regular fa-copyright"></i> 2024 Nguyen Hoang Anh.</div>
        </div>
    </div>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const productLinks = document.querySelectorAll('.product a');

        productLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chuyển hướng mặc định
                window.location.href = "details.php?id=" + this.getAttribute("data-product-id");
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const decreaseBtn = document.getElementById('decrease-btn');
        const increaseBtn = document.getElementById('increase-btn');
        const quantityInput = document.getElementById('quantity');

        decreaseBtn.addEventListener('click', function() {
            let currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) {
                currentQuantity--;
                quantityInput.value = currentQuantity;
            }
        });

        increaseBtn.addEventListener('click', function() {
            let currentQuantity = parseInt(quantityInput.value);
            // Thay 10 bằng giới hạn số lượng sản phẩm tối đa nếu cần
            if (currentQuantity < 20) {
                currentQuantity++;
                quantityInput.value = currentQuantity;
            }
        });
    });
</script>