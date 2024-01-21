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
                    <a href=""><img src="./img/logo.png" alt=""></a>
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
                if (isset($_SESSION['users'])) {
                    echo '<form action="check-out.php?action=buy" method="post">';
                    echo '<table id=cart-table>';
                    echo '<tr>';
                    echo '<th>Chọn</th>';
                    echo '<th>Tên sản phẩm</th>';
                    echo '<th>Hình ảnh</th>';
                    echo '<th>Size</th>';
                    echo '<th>Số lượng</th>';
                    echo '<th>Giá tiền</th>';
                    echo '<th>Thành tiền</th>';
                    echo '<th>Xóa sản phẩm</th>';
                    echo '</tr>';

                    $user_id = $_SESSION['user_id'];
                    $sql = "SELECT products.prd_name, products.price, products.img, carts.size, carts.quantity, carts.product_id
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
                            echo '<td>' . $row['size'] . '</td>';
                            echo '<td>' . $row['quantity'] . '</td>';
                            echo '<td><span style="font-weight: bold; color: #EE4D2D;">' . number_format($row['price'], 0, ',', '.') . ' VND</span></td>';
                            echo '<td  style="font-weight: bold; color: #EE4D2D;">' . number_format($row['quantity'] * $row['price'], 0, ',', '.') . ' VND</td>';
                            echo '<td><a href="add-to-cart.php?xoa=' . $row['product_id'] . '">xóa</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8">Giỏ hàng của bạn đang trống.</td></tr>';
                    }
                    echo '</table>';
                    echo '<div style="padding: 30px 0;"><button id="buy-btn" type="submit">MUA NGAY</button></div>';
                    echo '</form>';

                    $conn->close();
                } else {
                    echo '<div class="text-align"><h1>Đăng nhập để xem giỏ hàng của bạn</h1><img style="width: 150px;" src="./img/View-cart.png" alt=""></div>';
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