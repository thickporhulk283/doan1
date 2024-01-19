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
<style>
    #poster {
        position: relative;
        width: 100%;
        height: 635px;
        background: url('./img/test.webp') no-repeat;
        background-size: 100%;
    }

    .background-gr {
        width: 100%;
        height: 100%;
        background-image: linear-gradient(rgba(88, 37, 123, 0),
                rgb(-25, -6, 11));
    }

    #poster-ctn {
        position: absolute;
        bottom: 0;
        width: 40%;
        padding: 70px 50px;
        color: #ffffff;
    }
</style>

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
            <div id="header-end" class="text-align">
                <ul id="main-menu">
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a style="border-bottom: 5px solid #c70101" href="">Nam</a></li>
                    <li><a href="women.php">Nữ</a></li>
                    <li><a href="children.php">Trẻ em</a></li>
                </ul>
            </div>
        </div>
        <div id="content">
            <div id="poster">
                <div class="background-gr">
                    <div id="poster-ctn">
                        <h1>Lorem ipsum dolor sit amet</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque enim ex, consectetur quis diam et, condimentum varius quam. Vivamus porttitor erat vel nunc pellentesque cursus.</p>
                    </div>
                </div>
            </div>
            <div class="container d-flex">
                <div class="content-box">
                    <?php
                    $sql = "SELECT * FROM products WHERE type = 'nam'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo '<ul class="list-product list-style d-flex flex-wrap">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<li style="padding: 10px;width: 20%;">';
                            echo '<a href="" data-product-id="' . $row['prd_id'] . '">';
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
                        echo "Không có sản phẩm nào.";
                    }
                    ?>
                </div>
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