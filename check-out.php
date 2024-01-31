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
    <script src="jsu/app.js"></script>
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
            <div class="container d-flex">
                <div class="check-out-box">
                    <?php
                    if (isset($_SESSION['users'])) {
                        if ($_GET['action'] === 'buy' && isset($_POST['selected_products'])) {
                            echo '<div class="check-out-title">ĐƠN HÀNG CỦA BẠN <img src="./img/order.png" alt=""></div>';
                            echo '<table>';
                            echo '<tr>';
                            echo '<th>Mã sản phẩm</th>';
                            echo '<th>Tên sản phẩm</th>';
                            echo '<th>Hình ảnh</th>';
                            echo '<th>Số lượng</th>';
                            echo '<th>Giá tiền</th>';
                            echo '<th>Thành tiền</th>';
                            echo '</tr>';

                            $selectedProducts = $_POST['selected_products'];
                            $user_id = $_SESSION['user_id'];

                            $totalPrice = 0;

                            foreach ($selectedProducts as $productId) {
                                $sql = "SELECT products.prd_id, products.prd_name, products.price, products.img, carts.quantity
                            FROM carts
                            INNER JOIN products ON carts.product_id = products.prd_id
                            WHERE carts.user_id = $user_id AND products.prd_id = $productId";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row['prd_id'] . '</td>';
                                        echo '<td>' . $row['prd_name'] . '</td>';
                                        echo '<td><img src="img/' . $row['img'] . '" alt=""></td>';
                                        echo '<td>' . $row['quantity'] . '</td>';
                                        echo '<td><span style="font-weight: bold; color: #EE4D2D;">' . number_format($row['price'], 0, ',', '.') . ' VND</span></td>';
                                        echo '<td style="font-weight: bold; color: #EE4D2D;">' . number_format($row['quantity'] * $row['price'], 0, ',', '.') . ' VND</td>';
                                        echo '</tr>';

                                        // Tính tổng số tiền
                                        $totalPrice += $row['quantity'] * $row['price'];
                                    }
                                } else {
                                    echo 'Không tìm thấy thông tin sản phẩm có ID: ' . $productId;
                                }
                            }

                            // Hiển thị tổng số tiền
                            echo '<tr>';
                            echo '<td colspan="6"><strong>Tổng cộng: <span style="font-weight: bold; color: #EE4D2D;">' . number_format($totalPrice, 0, ',', '.') . ' VND</span></strong></td>';
                            echo '</tr>';

                            echo '</table>';
                            $conn->close();
                        } else {
                        }
                    } else {
                        echo '<div class="text-align"><h1>Đăng nhập để xem giỏ hàng của bạn</h1><img style="width: 150px;" src="./img/View-cart.png" alt=""></div>';
                    }
                    ?>
                </div>
                <div class="check-out-box">
                    <?php
                    include './config/db.php';
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];

                        $sql = "SELECT id, fullname, email FROM users WHERE id = $user_id";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $id = $row['id'];
                            $fullname = $row['fullname'];
                            $email = $row['email'];
                        } else {
                            // Xử lý khi không tìm thấy thông tin người dùng
                            // Ví dụ: gán giá trị mặc định cho các biến
                            $id = '';
                            $fullname = '';
                            $email = '';
                        }
                    } else {
                        // Xử lý khi không có phiên người dùng
                        $id = '';
                        $fullname = '';
                        $email = '';
                    }

                    $selectedProducts = $_POST['selected_products']; // ID của các sản phẩm đã chọn

                    if (!empty($selectedProducts)) {
                        $productInfo = array(); // Mảng lưu thông tin sản phẩm

                        foreach ($selectedProducts as $productId) {
                            // Truy vấn để lấy thông tin chi tiết sản phẩm và số lượng từ cơ sở dữ liệu
                            $sql = "SELECT products.prd_id, products.prd_name, products.price, products.img, carts.quantity
                        FROM carts
                        INNER JOIN products ON carts.product_id = products.prd_id
                        WHERE carts.user_id = $user_id AND products.prd_id = $productId";

                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Lưu thông tin sản phẩm vào mảng
                                    $productInfo[] = $row;
                                }
                            } else {
                                echo 'Không tìm thấy thông tin sản phẩm có ID: ' . $productId;
                            }
                        }
                        
                        echo '<div class="check-out-title">THÔNG TIN THANH TOÁN</div>';
                        echo '<div id="form-box">';
                        echo '<form id="order-form" action="order.php" method="post">';

                        echo '<div style="display:none;">';
                        echo '<input type="text" id="client_id" name="client_id" value="' . $id . '"><br><br>';
                        echo '</div>';

                        echo '<label for="client_name"><i class="fa-regular fa-user"></i> Tên người nhận</label><br>';
                        echo '<input type="text" id="client_name" name="client_name" value="' . $fullname . '"><br><br>';

                        // lấy dữ liệu tỉnh/huyện/xã

                        $sqlProvince = "SELECT province_id, name FROM province";
                        $resultProvince = $conn->query($sqlProvince);
                        echo '<label for="phone"><i class="fa-regular fa-address-book"></i> Địa chỉ</label><br>';
                        echo '    <select id="province" name="province" class="form-control">';
                        echo '        <option value="">Tỉnh/Thành phố</option>';
                        
                        // Lặp qua kết quả của truy vấn tỉnh/thành phố
                        while ($rowProvince = mysqli_fetch_assoc($resultProvince)) {
                            echo '        <option value="' . $rowProvince['province_id'] . '">' . $rowProvince['name'] . '</option>';
                        }
                        
                        echo '    </select><br><br>';     
                        echo '    <select id="district" name="district" class="form-control">';
                        echo '        <option value="">Quận/huyện</option>';
                        echo '    </select><br><br>';
                        echo '    <select id="wards" name="ward" class="form-control">';
                        echo '        <option value="">Phường/xã</option>';
                        echo '    </select><br><br>';
                       
                        echo '<label for="phone"><i class="fa-solid fa-phone"></i> Số điện thoại</label><br>';
                        echo '<input type="number" id="phone" name="phone"><br><br>';

                        echo '<label for=email"email"><i class="fa-regular fa-envelope"></i> Email</label><br>';
                        echo '<input type="email" id="email" name="email" value="' . $email . '"><br><br>';

                        foreach ($productInfo as $product) {
                            echo '<div style="display:none;">';
                            echo '<label>ID Sản phẩm</label><br>';
                            echo '<input type="text" name="product_id[]" value="' . $product['prd_id'] . '"><br>';
                            echo '<label>Số lượng </label>';
                            echo '<input type="text" name="quantity[]" value="' . $product['quantity'] . '"><br>';
                            echo '<label>Tổng cộng </label>';
                            echo '<input type="text" name="total[]" value="' . $product['quantity'] * $product['price'] . '"><br><br>';
                            echo '</div>';
                        }

                        echo '<input id="order-btn" type="submit" value="Đặt hàng">';
                        echo '</form>';
                        echo "</div>";
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
    document.addEventListener("DOMContentLoaded", function () {
        var orderForm = document.getElementById("order-form");

        orderForm.onsubmit = function () {
            // Kiểm tra các trường thông tin cần nhập
            var clientName = document.getElementById("client_name").value;
            var province = document.getElementById("province").value;
            var district = document.getElementById("district").value;
            var wards = document.getElementById("wards").value;
            var phone = document.getElementById("phone").value;
            var email = document.getElementById("email").value;

            // Kiểm tra nếu có ít nhất một trường không được điền
            if (
                clientName === "" ||
                province === "" ||
                district === "" ||
                wards === "" ||
                phone === "" ||
                email === ""
            ) {
                alert("Hãy điền đầy đủ thông tin trước khi đặt hàng.");
                return false; // Ngăn chặn việc submit form
            }

            // Nếu mọi thứ đã được điền đầy đủ, tiếp tục submit form
            return true;
        };
    });
</script>
