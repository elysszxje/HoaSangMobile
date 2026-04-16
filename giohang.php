<?php
session_start();
require 'connect.php';


if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

if (isset($_GET['remove'])) {
	$removeId = $_GET['remove'];
	if (isset($_SESSION['cart'][$removeId])) {
		unset($_SESSION['cart'][$removeId]);
	}
	header("Location: giohang.php");
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	foreach ($_POST['quantity'] as $id => $qty) {
		$id = (string)$id;
		$qty = max(1, intval($qty));

		$stmt = $pdo->prepare("SELECT quantity FROM products WHERE id = ?");
		$stmt->execute([$id]);
		$productStock = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($productStock) {
			if ($qty > $productStock['quantity']) {
				$qty = $productStock['quantity'];
				$_SESSION['cart'][$id]['warning'] = "Số lượng tối đa có sẵn: " . $productStock['quantity'];
			} else {
				unset($_SESSION['cart'][$id]['warning']);
			}
		}

		if (isset($_SESSION['cart'][$id])) {
			$_SESSION['cart'][$id]['quantity'] = $qty;
			$_SESSION['cart'][$id]['total'] = $_SESSION['cart'][$id]['price'] * $qty;
		}
	}
	session_write_close();
}


$totalAll = 0;
if (isset($_SESSION['cart'])) {
	foreach ($_SESSION['cart'] as $item) {
		$totalAll += $item['total'];
	}
}


$cartIds = isset($_SESSION['cart']) ? array_keys($_SESSION['cart']) : [];

if ($cartIds) {
	$placeholders = implode(',', array_fill(0, count($cartIds), '?'));
	$sql = "
        SELECT p.id, p.name, p.created_at, p.updated_at, p.img, p.price, b.name AS brand_name, p.star, p.rateCount
        FROM products p
        JOIN brands b ON p.company_id = b.id
        WHERE p.id NOT IN ($placeholders)
        ORDER BY p.star DESC 
        LIMIT 4
    ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute($cartIds);
} else {
	$stmt = $pdo->query("
        SELECT p.id, p.name, p.created_at, p.updated_at, p.img, p.price, b.name AS brand_name, p.star, p.rateCount
        FROM products p
        JOIN brands b ON p.company_id = b.id
        ORDER BY p.star DESC 
        LIMIT 4
    ");
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


	<!-- owl carousel libraries cho hình nhỏ -->
	<link rel="stylesheet" href="js/owlcarousel/owl.carousel.min.css">
	<link rel="stylesheet" href="js/owlcarousel/owl.theme.default.min.css">
	<script src="js/Jquery/Jquery.min.js"></script>
	<script src="js/owlcarousel/owl.carousel.min.js"></script>

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

		<section class="container my-5">
			<h1 class="text-center mb-4">Giỏ hàng của bạn</h1>

			<?php if (empty($_SESSION['cart'])): ?>
				<p class="text-center mt-5">Giỏ hàng trống. <a href="index.php">Quay lại mua sắm</a></p>
			<?php else: ?>
				<form method="POST">
					<div class="table-responsive">
						<table class="table table-bordered align-middle text-center">
							<thead class="table-light">
								<tr>
									<th>Hình</th>
									<th>Sản phẩm</th>
									<th>Giá</th>
									<th>Số lượng</th>
									<th>Thành tiền</th>
									<th>Xóa</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($_SESSION['cart'] as $item): ?>
									<tr>
										<td><img src="<?= htmlspecialchars($item['img']) ?>" class="img-fluid" style="max-width:80px;"></td>
										<td>
											<?= htmlspecialchars($item['name']) ?>
											<?php if (isset($item['warning'])): ?>
												<div class="text-danger small"><?= $item['warning'] ?></div>
											<?php endif; ?>
										</td>
										<td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
										<td>
											<input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control text-center" style="width:80px; margin:auto;">
										</td>
										<td><?= number_format($item['total'], 0, ',', '.') ?>₫</td>
										<td>
											<a class="btn btn-danger btn-sm" href="giohang.php?remove=<?= $item['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
												<i class="fa fa-trash"></i> Xóa
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>

					<div class="d-flex justify-content-end align-items-center mt-3 gap-3">
						<h4 class="mb-0">Tổng cộng: <?= number_format($totalAll, 0, ',', '.') ?>₫</h4>
						<button type="submit" class="btn btn-warning">Cập nhật giỏ hàng</button>
						<a href="thanhtoan.php" class="btn btn-success">Thanh toán</a>
					</div>
				</form>
			<?php endif; ?>

			<div class="contain-khungSanPham">
				<div class="khungSanPham" style="border-color: #ff5733;">
					<h3 class="tenKhung" style="background-image: linear-gradient(120deg, #ff5733 0%, #ff9c33 50%, #ff5733 100%);">* Sản Phẩm Khác *</h3>
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
				</div>
			</div>

		</section>
	</section>


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