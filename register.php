<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'register') {
	$ho = htmlspecialchars($_POST['ho']);
	$ten = htmlspecialchars($_POST['ten']);
	$email = htmlspecialchars($_POST['email']);
	$username = htmlspecialchars($_POST['newUser']);
	$password = htmlspecialchars($_POST['newPass']);
	$dienThoai = htmlspecialchars($_POST['dienThoai']);
	$diaChi = htmlspecialchars($_POST['diaChi']);

	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$role = 'User';

	$stmt = $pdo->prepare("SELECT id FROM users WHERE Username = :username OR Email = :email");
	$stmt->execute(['username' => $username, 'email' => $email]);
	if ($stmt->rowCount() > 0) {
		echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại!'); window.location.href='register.php';</script>";
		exit;
	}

	$sql = "INSERT INTO users (Username, Password, HoTen, Email, DienThoai, DiaChi, Role) 
            VALUES (:username, :password, :hoTen, :email, :dienThoai, :diaChi, :role)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		'username' => $username,
		'password' => $hashedPassword,
		'hoTen' => $ho . ' ' . $ten,
		'email' => $email,
		'dienThoai' => $dienThoai,
		'diaChi' => $diaChi,
		'role' => $role
	]);

	echo "<script>alert('Đăng ký thành công!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng ký tài khoản</title>
	<link rel="stylesheet" href="css/auth.css">
</head>

<body>
	<div class="login-container">
		<div class="login-card">
			<div class="login-header">
				<h2>Đăng ký tài khoản</h2>
				<p>Chào mừng bạn đến với hệ thống</p>
			</div>

			<form class="login-form" id="registerForm" method="POST" novalidate>
				<div class="form-group">
					<div class="input-wrapper">
						<input type="text" name="ho" required autocomplete="off">
						<label for="ho" style="color: white">Họ</label>
						<span class="focus-border"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-wrapper">
						<input type="text" name="ten" required autocomplete="off">
						<label for="ten" style="color: white">Tên</label>
						<span class="focus-border"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-wrapper">
						<input type="email" name="email" required autocomplete="off">
						<label for="email" style="color: white">Địa chỉ Email</label>
						<span class="focus-border"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-wrapper">
						<input type="text" name="newUser" required autocomplete="off">
						<label for="newUser" style="color: white">Tên đăng nhập</label>
						<span class="focus-border"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-wrapper">
						<input type="password" name="newPass" required autocomplete="off">
						<label for="newPass" style="color: white">Mật khẩu</label>
						<span class="focus-border"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-wrapper">
						<input type="text" name="dienThoai" required autocomplete="off">
						<label for="dienThoai" style="color: white">Điện thoại</label>
						<span class="focus-border"></span>
						<span id="dienThoaiError" class="text-danger" style="font-size: 0.9em; color: red"></span>
					</div>
				</div>


				<div class="form-group">
					<div class="input-wrapper">
						<input type="text" name="diaChi" required autocomplete="off">
						<label for="diaChi" style="color: white">Địa chỉ</label>
						<span class="focus-border"></span>
					</div>
				</div>

				<button type="submit" name="submit" value="register" class="login-btn btn">
					<span class="btn-text">Đăng ký</span>
					<span class="btn-loader"></span>
				</button>
			</form>

			<div class="divider">
				<span>Hoặc</span>
			</div>

			<div class="social-login">
				<a href="index.php" class="social-btn google-btn">

					Quay lại trang chủ
				</a>
			</div>

			<div class="signup-link">
				<p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
			</div>
		</div>
	</div>

	<script>
		document.getElementById('registerForm').addEventListener('submit', function(e) {
			const dienThoaiInput = this.querySelector('input[name="dienThoai"]');
			const dienThoai = dienThoaiInput.value.trim();
			const errorLabel = document.getElementById('dienThoaiError');

			errorLabel.textContent = '';

			const phoneRegex = /^0\d{9}$/;
			if (!phoneRegex.test(dienThoai)) {
				e.preventDefault(); 
				errorLabel.textContent = 'Số điện thoại không hợp lệ! Phải có 10 chữ số và bắt đầu bằng 0.';
				dienThoaiInput.focus();
				return false;
			}
		});
	</script>


	<script src="script.js"></script>
</body>

</html>