<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}
$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$vouchers = $pdo->query("
    SELECT id, name, code, discount_value 
    FROM vouchers
    WHERE quantity > 0 
      AND start_date <= NOW()
      AND end_date >= NOW()
")->fetchAll(PDO::FETCH_ASSOC);


if (empty($_SESSION['cart'])) {
	header("Location: giohang.php");
	exit;
}

$totalAll = 0;
foreach ($_SESSION['cart'] as $item) {
	$totalAll += $item['total'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// 1. LẤY DỮ LIỆU TỪ FORM 
	$fullname = trim($_POST['fullname'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$address = trim($_POST['address'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$method = $_POST['payment_method'] ?? 'COD';

	$voucherId = !empty($_POST['voucher_id']) ? $_POST['voucher_id'] : NULL;

	// 2. TÍNH TOÁN VOUCHER 
	$discountPercent = 0;
	if ($voucherId) {
		$stm = $pdo->prepare("SELECT * FROM vouchers WHERE id = ? AND quantity > 0");
		$stm->execute([$voucherId]);
		$voucher = $stm->fetch(PDO::FETCH_ASSOC);

		if ($voucher) {
			$discountPercent = (int)$voucher['discount_value'];
		}
	}
	$discountAmount = ($totalAll * $discountPercent) / 100;
	$finalTotal = $totalAll - $discountAmount;


	// 3. XỬ LÝ LƯU ĐƠN HÀNG 
	if ($fullname == '' || $email == '' || $address == '' || $phone == '') {
		$error = "Vui lòng nhập đầy đủ thông tin.";
	} else {
		// Lưu đơn hàng vào DATABASE (Trạng thái ban đầu: pending)
		$stmt = $pdo->prepare("
			INSERT INTO orders (user_id, created_at, updated_at, status, sub_total, total, payment_method, voucher_id)
			VALUES (?, NOW(), NOW(), 'pending', ?, ?, ?, ?)
		");
		
		$paymentMethodDB = ($method == "vnpay") ? "vnpay" : "COD";
		
		$stmt->execute([
			$_SESSION['user_id'],
			$totalAll,    
			$finalTotal, 
			$paymentMethodDB,
			$voucherId
		]);

		$orderId = $pdo->lastInsertId();

		// Lưu chi tiết sản phẩm
		$stmtItem = $pdo->prepare("
			INSERT INTO order_items (order_id, product_id, quantity, price, total_price)
			VALUES (?, ?, ?, ?, ?)
		");

		foreach ($_SESSION['cart'] as $item) {
			$stmtItem->execute([
				$orderId,
				$item['id'],
				$item['quantity'],
				$item['price'],
				$item['total']
			]);
		}

		// Chuyển hướng theo phương thức thanh toán
		if ($method == "COD") {
			if ($voucherId) {
				$updateVoucher = $pdo->prepare("UPDATE vouchers SET quantity = quantity - 1 WHERE id = ? AND quantity > 0");
				$updateVoucher->execute([$voucherId]);
			}
			unset($_SESSION['cart']);
			header("Location: thanhcong.php?order_id=" . $orderId);
			exit;

		} elseif ($method == "vnpay") {
			date_default_timezone_set('Asia/Ho_Chi_Minh');

			$vnp_Version = "2.1.0";
			$vnp_Command = "pay";
			$vnp_TmnCode = "1A1WQ9ZN";
			$vnp_TxnRef = $orderId; 
			$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
			$amount = $finalTotal;
			$orderInfo = "Thanh toan don hang " . $orderId . " cua " . $fullname;

			$vnp_Params = [
				"vnp_Version" => $vnp_Version,
				"vnp_Command" => $vnp_Command,
				"vnp_TmnCode" => $vnp_TmnCode,
				"vnp_Amount" => $amount * 100,
				"vnp_CurrCode" => "VND",
				"vnp_TxnRef" => $vnp_TxnRef,
				"vnp_OrderInfo" => $orderInfo,
				"vnp_OrderType" => "other",
				"vnp_Locale" => "vn",
				"vnp_ReturnUrl" => "http://localhost/hoasang/vnpay_return.php",
				"vnp_IpAddr" => $vnp_IpAddr
			];

			$vnp_Params["vnp_CreateDate"] = date("YmdHis");
			$vnp_Params["vnp_ExpireDate"] = date("YmdHis", strtotime("+15 minutes"));

			ksort($vnp_Params);
			$hashData = "";
			$query = "";
			foreach ($vnp_Params as $key => $value) {
				if (!empty($value)) {
					$hashData .= $key . "=" . urlencode($value) . "&";
					$query .= urlencode($key) . "=" . urlencode($value) . "&";
				}
			}

			$hashData = rtrim($hashData, "&");
			$query = rtrim($query, "&");

			$secretKey = "HFWWS0H1PTNNWO8C114AIRI5CR1RA9DP";
			$vnp_SecureHash = hash_hmac("sha512", $hashData, $secretKey);

			$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?" . $query . "&vnp_SecureHash=" . $vnp_SecureHash;

			header("Location: " . $vnp_Url);
			exit;
		}
	}
}
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

			<h1 class="text-center mb-4">Thanh toán đơn hàng</h1>

			<div class="row">

				<!-- LEFT FORM -->
				<div class="col-md-6">
					<h4>Thông tin nhận hàng</h4>
					<form method="POST">

						<?php if (!empty($error)): ?>
							<div class="alert alert-danger"><?= $error ?></div>
						<?php endif; ?>

						<div class="mb-3">
							<label class="form-label">Họ và tên</label>
							<input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['HoTen']) ?>" required>
						</div>

						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['Email']) ?>" required>
						</div>

						<div class="mb-3">
							<label class="form-label">Địa chỉ nhận hàng</label>
							<input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['DiaChi']) ?>" required>
						</div>

						<div class="mb-3">
							<label class="form-label">Số điện thoại</label>
							<input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['DienThoai']) ?>" required>
						</div>

				</div>

				<!-- RIGHT CART SUMMARY -->
				<div class="col-md-6">
					<h4>Đơn hàng của bạn</h4>

					<ul class="list-group mb-3">
						<?php foreach ($_SESSION['cart'] as $item): ?>
							<li class="list-group-item d-flex justify-content-between lh-sm">
								<div>
									<h6 class="my-0"><?= htmlspecialchars($item['name']) ?></h6>
									<small class="text-body-secondary">SL: <?= $item['quantity'] ?></small>
								</div>
								<span><?= number_format($item['total'], 0, ',', '.') ?>₫</span>
							</li>
						<?php endforeach; ?>

						<h5 class="mt-4">Áp mã giảm giá</h5>
						<div class="mb-3">
							<select name="voucher_id" id="voucherSelect" class="form-select">
								<option value="">Không sử dụng</option>
								<?php foreach ($vouchers as $voucher): ?>
									<option value="<?= $voucher['id'] ?>" data-discount="<?= $voucher['discount_value'] ?>">
										<?= $voucher['code'] ?> - Giảm <?= $voucher['discount_value'] ?>%
									</option>
								<?php endforeach; ?>
							</select>

						</div>

						<li class="list-group-item d-flex justify-content-between">
							<strong>Tổng cộng</strong>
							<strong> <span id="totalAll" data-total="<?= $totalAll ?>">
									<?= number_format($totalAll, 0, ',', '.') ?>₫
								</span></strong>
						</li>
					</ul>

					<!-- PAYMENT METHOD -->
					<h5>Phương thức thanh toán</h5>

					<div class="form-check">
						<input class="form-check-input" type="radio" name="payment_method" value="COD" checked>
						<label class="form-check-label">
							Thanh toán khi nhận hàng (COD)
						</label>
					</div>

					<div class="form-check mb-3">
						<input class="form-check-input" type="radio" name="payment_method" value="vnpay">
						<label class="form-check-label">
							Thanh toán qua VNPay
						</label>
					</div>

					<button type="submit" class="btn btn-success w-100">Xác nhận đặt hàng</button>

					</form>
				</div>

			</div>
		</section>

	</section>
</body>
<script>
	document.getElementById('voucherSelect').addEventListener('change', function() {
		let total = parseFloat(document.getElementById('totalAll').dataset.total);
		let discount = parseInt(this.selectedOptions[0].dataset.discount || 0);

		let discountAmount = (total * discount) / 100;
		let finalTotal = total - discountAmount;

		document.getElementById('totalAll').innerText =
			finalTotal.toLocaleString('vi-VN') + '₫';
	});
</script>

</html>