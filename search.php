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
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                autoplayTimeout: 2000,
                responsive: {
                    1000: {
                        items: 2
                    },
                    430: {
                        items: 1
                    }
                }
            });
        });
    </script>
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
                    <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="container">
                <?php
                if (isset($_GET['keyword'])) {
                    $keyword = $_GET['keyword'];

                    // Kiểm tra xem từ khóa có giá trị hay không
                    if (!empty($keyword)) {
                        $sql = "SELECT * FROM products WHERE prd_name LIKE '%$keyword%'"; // Thêm điều kiện sắp xếp
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo '<div class="text-align" >';
                            echo '<p>Tìm thấy <span style="color: red;">' . $result->num_rows . '</span> sản phẩm cho từ khóa "' . $keyword . '"</p>';
                            echo '</div>';
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
                            echo '<div class="text-align" >';
                            echo '<p>Tìm thấy <span style="color: red;">' . $result->num_rows . '</span> sản phẩm cho từ khóa "' . $keyword . '"</p>';
                            echo '<p>Xin lỗi, không có kết quả bạn cần tìm</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="text-align" >';
                        echo '<p style="color: red;">Bạn phải nhập từ khóa để thực hiện tìm kiếm!</p>';
                        echo '</div>';
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