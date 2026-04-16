<?php
require 'connect.php';
session_start();

$productId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, name, price, img, quantity FROM products WHERE id = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<script>alert('Sản phẩm không tồn tại');</script>";
        exit;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $currentQty = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId]['quantity'] : 0;

    if ($currentQty + 1 > $product['quantity']) {
        echo "<script>
            alert('Số lượng sản phẩm trong kho chỉ còn " . $product['quantity'] . "!');
            window.location.href='giohang.php';
        </script>";
        exit;
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity']++;
    } else {
        $_SESSION['cart'][$productId] = [
            'id' => $productId,
            'name' => $product['name'],
            'price' => $product['price'],
            'img' => $product['img'],
            'quantity' => 1,
            'total' => $product['price']
        ];
    }

    $_SESSION['cart'][$productId]['total'] = $_SESSION['cart'][$productId]['price'] * $_SESSION['cart'][$productId]['quantity'];

    echo "<script>
        alert('Thêm vào giỏ thành công!');
        window.location.href='giohang.php';
    </script>";
    exit;
}


$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $productId, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    SELECT p.id, p.name, p.created_at, p.updated_at, p.img, p.price, b.name AS brand_name, p.star, p.rateCount
    FROM products p
    JOIN brands b ON p.company_id = b.id
    WHERE p.id != :id
    ORDER BY p.star DESC 
    LIMIT 5
");

$stmt->bindParam(':id', $productId, PDO::PARAM_INT);
$stmt->execute();


$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


$userId = $_SESSION['user_id'] ?? null;
$hasBought = false;

if ($userId) {
    $stmt = $pdo->prepare("
        SELECT 1 
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        WHERE o.user_id = :user_id AND oi.product_id = :product_id
        LIMIT 1
    ");
    $stmt->execute([
        ':user_id' => $userId,
        ':product_id' => $productId
    ]);
    $hasBought = $stmt->fetchColumn() ? true : false;
}

$stmt = $pdo->prepare("
    SELECT r.*, u.HoTen
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.product_id = :product_id
    ORDER BY r.review_date DESC
");
$stmt->execute([':product_id' => $productId]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HoaSang Store</title>
    <link rel="shortcut icon" href="img/favicon.ico" />

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- owl carousel libraries cho hình nhỏ -->
    <link rel="stylesheet" href="js/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="js/owlcarousel/owl.theme.default.min.css">
    <script src="js/Jquery/Jquery.min.js"></script>
    <script src="js/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoVZihp+N0D4CkK6aA7RfYF0HgR5hZqfv6tih5z0b5Vj2/0" crossorigin="anonymous"></script>

    <!-- our files -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/taikhoan.css">
    <link rel="stylesheet" href="css/trangchu.css">
    <link rel="stylesheet" href="css/home_products.css">
    <link rel="stylesheet" href="css/chitietsanpham.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .star-rating i {
            font-size: 25px;
            color: #e0e0e0;
            /* màu xám nhạt lúc chưa chọn */
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating i.text-warning {
            color: #ffc107;
            /* màu vàng khi chọn */
        }
    </style>
    <style>
        #goto-top-page {
            position: fixed;
            bottom: 15px;
            left: 15px;
            z-index: 100;
            background: rgba(0, 0, 0, .2);
            color: #fff;
            font-size: 18px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            cursor: pointer;
            transition-duration: .2s;
        }

        #goto-top-page:hover {
            background: rgba(0, 0, 0, .7);
            width: 50px;
            height: 50px;
            line-height: 50px;
        }
    </style>
</head>

<body>
    <?php include 'nav.php'; ?>

    <section>
        <?php include 'header.php'; ?>

        <link rel="stylesheet" href="css/detail.css">

        <div id="productNotFound" style="min-height: 50vh; text-align: center; margin: 50px; display: none;">
            <h1 style="color: red; margin-bottom: 10px;">Không tìm thấy sản phẩm</h1>
            <a href="index.php" style="text-decoration: underline;">Quay lại trang chủ</a>
        </div>

        <div class="chitietSanpham" style="margin-bottom: 100px">
            <!-- Tên sản phẩm -->
            <h1><?= htmlspecialchars($product['name']) ?></h1>

            <!-- Đánh giá sản phẩm -->
            <div class="rating">
                <?php
                $star = $product['star'];
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $star) {
                        echo '<i class="fa fa-star"></i>';
                    } else {
                        echo '<i class="fa fa-star-o"></i>';
                    }
                }
                ?>
                <span><?= $product['rateCount'] ?> đánh giá</span>
            </div>

            <!-- Chi tiết sản phẩm -->
            <div class="rowdetail group">
                <div class="picture">
                    <img src="<?= $product['img'] ?>" onclick="opencertain()">
                </div>

                <!-- Giá sản phẩm -->
                <div class="price_sale">
                    <div class="area_price">
                        <strong><?= number_format($product['price'], 0, ',', '.') ?>₫</strong>
                    </div>
                    <div class="ship" style="display: none;">
                        <img src="img/chitietsanpham/clock-152067_960_720.png">
                        <div>NHẬN HÀNG TRONG 1 GIỜ</div>
                    </div>
                    <div class="area_promo">
                        <strong>Khuyến mãi</strong>
                        <div class="promo">
                            <img src="img/chitietsanpham/icon-tick.png" alt="Promotion">
                            <div id="detailPromo">Miễn phí ship cho đơn hàng từ 2 triệu</div> <!-- Static Promo Text -->
                        </div>
                    </div>

                    <div class="policy">
                        <div>
                            <img src="img/chitietsanpham/box.png" alt="Box Contents">
                            <p>Trong hộp có: Sạc, cáp s, tai nghe, sách hướng dẫn</p> <!-- Static Box Contents -->
                        </div>
                        <div>
                            <img src="img/chitietsanpham/icon-baohanh.png" alt="Warranty Icon">
                            <p>Bảo hành chính hãng 12 tháng</p> <!-- Static Warranty -->
                        </div>
                        <div class="last">
                            <img src="img/chitietsanpham/1-1.jpg" alt="1-to-1 Replacement">
                            <p>1 đổi 1 trong 1 tháng nếu lỗi, đổi sản phẩm tại nhà trong 1 ngày.</p> <!-- Static Replacement Info -->
                        </div>
                    </div>

                    <div class="area_order">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <button type="submit" class="buy_now">
                                <b><i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng</b>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Thông số kỹ thuật -->
                <div class="info_product">
                    <h2>Thông số kỹ thuật</h2>
                    <ul class="info">
                        <li>Màn hình: <?= htmlspecialchars($product['screen']) ?></li>
                        <li>Hệ điều hành: <?= htmlspecialchars($product['os']) ?></li>
                        <li>Camera sau: <?= htmlspecialchars($product['camera']) ?></li>
                        <li>Camera trước: <?= htmlspecialchars($product['cameraFront']) ?></li>
                        <li>CPU: <?= htmlspecialchars($product['cpu']) ?></li>
                        <li>RAM: <?= htmlspecialchars($product['ram']) ?></li>
                        <li>Bộ nhớ trong: <?= htmlspecialchars($product['rom']) ?></li>
                        <li>Dung lượng pin: <?= htmlspecialchars($product['battery']) ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <h3 class="mb-4 text-danger">Đánh giá sản phẩm</h3>

            <?php if (empty($reviews)): ?>
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($review['HoTen']) ?></h5>
                            <p>
                                <?php
                                for ($i = 0; $i < 5; $i++) {
                                    echo $i < $review['rating'] ? '<i class="fa fa-star text-warning"></i>' : '<i class="fa fa-star text-secondary"></i>';
                                }
                                ?>
                            </p>
                            <p class="card-text"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                            <small class="text-muted"><?= date('d/m/Y H:i', strtotime($review['review_date'])) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>


        <div class="container my-5">
            <div class="card shadow-sm p-4">
                <h2 class="card-title text-center text-danger mb-4">Viết đánh giá</h2>

                <?php if (!$userId): ?>
                    <p class="text-center">Vui lòng <a href="login.php">đăng nhập</a> để viết đánh giá.</p>
                <?php elseif (!$hasBought): ?>
                    <p class="text-center text-warning">Bạn phải mua sản phẩm này mới có thể đánh giá.</p>
                <?php else: ?>
                    <form method="POST" action="submit_review.php">
                        <input type="hidden" name="product_id" value="<?= $productId ?>">

                        <div class="mb-3">
                            <label class="form-label">Đánh giá:</label>
                            <div class="star-rating">
                                <i class="fa fa-star" data-value="1"></i>
                                <i class="fa fa-star" data-value="2"></i>
                                <i class="fa fa-star" data-value="3"></i>
                                <i class="fa fa-star" data-value="4"></i>
                                <i class="fa fa-star" data-value="5"></i>
                                <input type="hidden" name="rating" id="rating">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Bình luận:</label>
                            <textarea class="form-control" name="comment" id="comment" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">Gửi đánh giá</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>




        <div class="contain-khungSanPham">
            <div class="khungSanPham" style="border-color: #ff5733;">
                <h3 class="tenKhung" style="background-image: linear-gradient(120deg, #ff5733 0%, #ff9c33 50%, #ff5733 100%);">* Sản Phẩm Liên Quan *</h3>
                <div class="listSpTrongKhung flexContain">
                    <?php foreach ($products as $product): ?>
                        <li class="sanPham">
                            <a href="detail.php?id=<?= urlencode($product['id']) ?>">
                                <img src="<?= htmlspecialchars($product['img']) ?>" width="50" height="50" />
                                <h3><?= $product['name']; ?></h3>
                                <div class="price">
                                    <strong><?= number_format($product['price'], 0, ',', '.'); ?>&#8363;</strong>
                                </div>
                                <div class="ratingresult">
                                    <?php
                                    for ($i = 0; $i < 5; $i++):
                                        $starClass = ($i < $product['star']) ? 'fa-star' : 'fa-star-o';
                                    ?>
                                        <i class="fa <?= $starClass; ?>"></i>
                                    <?php endfor; ?>
                                    <span><?= number_format($product['rateCount']); ?> đánh giá</span>
                                </div>

                            </a>
                        </li>
                    <?php endforeach; ?>
                </div>
                <a class="xemTatCa" href="index.php?filter=all" style="border-left: 2px solid #ff5733; border-right: 2px solid #ff5733;">
                    Xem thêm
                </a>
            </div>
        </div>
    </section>



    <div class="footer"><?php include 'footer.php'; ?></div>

    <script>
        const stars = document.querySelectorAll('.star-rating i');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));
                ratingInput.value = value;

                stars.forEach(s => s.classList.remove('text-warning'));

                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('text-warning');
                }
            });
        });
    </script>
    <script>
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items: 5,
            center: true,
            smartSpeed: 450,
        });
    </script>

</body>

</html>