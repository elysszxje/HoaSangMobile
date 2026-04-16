<?php
require 'connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'changePassword') {
	$currentPassword = $_POST['currentPass'] ?? '';
	$newPassword = $_POST['newPass'] ?? '';
	$confirmPassword = $_POST['confirmPass'] ?? '';

	$stmt = $pdo->prepare("SELECT Password FROM users WHERE id = :id");
	$stmt->execute(['id' => $userId]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$user || !password_verify($currentPassword, $user['Password'])) {
		echo "<script>alert('Mật khẩu hiện tại không đúng!');</script>";
	} elseif ($newPassword !== $confirmPassword) {
		echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');</script>";
	} else {
		$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
		$stmt = $pdo->prepare("UPDATE users SET Password = :password WHERE id = :id");
		$stmt->execute(['password' => $hashedPassword, 'id' => $userId]);
		echo "<script>alert('Đổi mật khẩu thành công!');</script>";
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đổi mật khẩu</title>
	<link rel="stylesheet" href="css/auth.css">

	<!-- Load font awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap JS Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
	<div class="login-container">
		<div class="login-card">
			<div class="login-header">
				<h2>Đổi mật khẩu</h2>
			</div>

			<form method="POST">
				<div class="form-group">
					<div class="input-wrapper">
						<input type="password" name="currentPass" required autocomplete="off">
						<label for="currentPass" style="color: white">Mật khẩu hiện tại</label>
						<span class="focus-border"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-wrapper">
						<input type="password" name="newPass" required autocomplete="off">
						<label for="newPass" style="color: white">Mật khẩu mới</label>
						<span class="focus-border"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-wrapper">
						<input type="password" name="confirmPass" required autocomplete="off">
						<label for="confirmPass" style="color: white">Nhập lại mật khẩu</label>
						<span class="focus-border"></span>
					</div>
				</div>
				<button type="submit" name="submit" value="changePassword" class="btn btn-danger w-100">Đổi mật khẩu</button>
			</form>

			<div class="divider">
				<span>Hoặc</span>
			</div>

			<div class="social-login">
				<a href="index.php" class="social-btn google-btn">
					Quay lại trang chủ
				</a>
			</div>
		</div>
	</div>

	<script src="script.js"></script>
</body>

</html>