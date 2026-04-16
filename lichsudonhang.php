<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT id, created_at, total, status, payment_method
    FROM orders
    WHERE user_id = ?
    ORDER BY id DESC
");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

			<h2 class="mb-4">Lịch sử đơn hàng của bạn</h2>

			<?php if (empty($orders)): ?>
				<div class="alert alert-info text-center">
					Bạn chưa có đơn hàng nào.
					<a href="index.php">Mua ngay</a>
				</div>
			<?php else: ?>

				<table class="table table-bordered text-center align-middle">
					<thead>
						<tr>
							<th>Mã đơn hàng</th>
							<th>Ngày đặt</th>
							<th>Tổng tiền</th>
							<th>Thanh toán</th>
							<th>Trạng thái</th>
							<th>Chi tiết</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($orders as $order): ?>
							<tr>
								<td><strong>#<?= $order['id']; ?></strong></td>

								<td><?= date("d/m/Y H:i", strtotime($order['created_at'])); ?></td>

								<td><strong><?= number_format($order['total'], 0, ',', '.') ?>₫</strong></td>

								<td><?= strtoupper($order['payment_method']); ?></td>

								<td>
									<?php
									$statusColor = [
										"pending" => "warning",
										"processing" => "primary",
										"completed" => "success",
										"canceled" => "danger"
									];
									$color = $statusColor[$order['status']] ?? "secondary";
									?>
									<span class="badge bg-<?= $color ?> badge-status">
										<?= ucfirst($order['status']); ?>
									</span>
								</td>

								<td>
									<a href="chitietdonhang.php?order_id=<?= $order['id'] ?>"
										class="btn btn-sm btn-info">
										Xem
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

			<?php endif; ?>
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