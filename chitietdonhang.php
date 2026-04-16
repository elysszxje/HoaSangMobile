<?php
session_start();
require 'connect.php';

if (!isset($_GET['order_id'])) {
	die("Thiếu mã đơn hàng!");
}

$orderId = intval($_GET['order_id']);

$stmt = $pdo->prepare("
    SELECT o.*, u.HoTen, u.Email, u.DiaChi, u.DienThoai
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ?
");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
	die("Không tìm thấy đơn hàng.");
}

$stmtItems = $pdo->prepare("
    SELECT oi.*, p.name, p.img
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmtItems->execute([$orderId]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
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

</head>

<body>
	<?php include 'nav.php'; ?>

	<section>
		<?php include 'header.php'; ?>

		<section class="container my-5">
			<div class="invoice-box mt-5">

				<!-- HEADER -->
				<div class="d-flex justify-content-between mb-4">
					<div>
						<div class="title">HÓA ĐƠN MUA HÀNG</div>
						<div class="header-info">Mã đơn hàng: <strong>#<?= $orderId ?></strong></div>
						<div class="header-info">Ngày đặt: <?= date("d/m/Y H:i", strtotime($order['created_at'])) ?></div>
					</div>

					<div class="text-end">
						<h5><strong>HoaSang Store</strong></h5>
						<div>Email: support@hoasang.vn</div>
						<div>Hotline: 0937940243</div>
					</div>
				</div>

				<!-- CUSTOMER INFO -->
				<h5 class="mt-4">Thông tin khách hàng</h5>
				<table class="table table-bordered">
					<tr>
						<th style="width: 200px;">Họ tên</th>
						<td><?= htmlspecialchars($order['HoTen']) ?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?= htmlspecialchars($order['Email']) ?></td>
					</tr>
					<tr>
						<th>Địa chỉ</th>
						<td><?= htmlspecialchars($order['DiaChi'] ?? "Không có") ?></td>
					</tr>
					<tr>
						<th>Số điện thoại</th>
						<td><?= htmlspecialchars($order['DienThoai'] ?? "Không có") ?></td>
					</tr>
				</table>

				<h5 class="mt-4">Chi tiết đơn hàng</h5>
				<table class="table table-bordered text-center">
					<thead>
						<tr>
							<th>Hình</th>
							<th>Sản phẩm</th>
							<th>Giá</th>
							<th>SL</th>
							<th>Thành tiền</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($items as $item): ?>
							<tr>
								<td><img src="<?= $item['img'] ?>" width="60"></td>
								<td><?= $item['name'] ?></td>
								<td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
								<td><?= $item['quantity'] ?></td>
								<td><strong><?= number_format($item['total_price'], 0, ',', '.') ?>₫</strong></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<div class="text-end mt-4">
					<h4>Tổng cộng:
						<strong class="text-success">
							<?= number_format($order['total'], 0, ',', '.') ?>₫
						</strong>
					</h4>

					<p>Phương thức thanh toán:
						<strong><?= strtoupper($order['payment_method']) ?></strong>
					</p>
				</div>

				<hr>

				<div class="text-center mt-3">
					<p>Cảm ơn bạn đã mua hàng tại <strong>HoaSang Store</strong>!</p>
					<a href="lichsudonhang.php" class="btn btn-primary mt-2">Quay lại trang lịch sử</a>
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