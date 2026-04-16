<?php
require 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);

	$stmt = $pdo->prepare("SELECT * FROM users WHERE Username = :username AND TrangThai = 1");
	$stmt->bindParam(':username', $username);
	$stmt->execute();

	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user && password_verify($password, $user['Password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['Username'];
		$_SESSION['role'] = $user['Role'];

		if ($user['Role'] === 'Admin') {
			echo "<script>
                alert('Đăng nhập thành công! Chuyển đến trang Admin');
                setTimeout(function() {
                    window.location.href = 'admin/index.php';
                }, 300);
              </script>";
		} else {
			echo "<script>
                alert('Đăng nhập thành công!');
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 300);
              </script>";
		}
		exit;
	} else {
		echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!');</script>";
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng nhập</title>
	<link rel="stylesheet" href="css/auth.css">
</head>

<body>
	<div class="login-container">
		<div class="login-card">
			<div class="login-header">
				<h2>Chào mừng</h2>
				<p>Đăng nhập tài khoản</p>
			</div>

			<form class="login-form" id="loginForm" method="post">
				<div class="form-group">
					<div class="input-wrapper">
						<input type="text" id="username" name="username" required placeholder=" ">
						<label for="username" style="color: white">Tên tài khoản</label>
						<span class="focus-border"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-wrapper password-wrapper">
						<input type="password" id="password" name="password" required placeholder=" ">
						<label for="password" style="color: white">Mật khẩu</label>
						<button type="button" class="password-toggle" id="passwordToggle">
							<span class="eye-icon"></span>
						</button>
						<span class="focus-border"></span>
					</div>
				</div>

				<div class="form-options">
					<a href="#" class="forgot-password">Quên mật khẩu?</a>
				</div>

				<button type="submit" class="login-btn btn">
					<span class="btn-text">Đăng nhập</span>
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
				<p>Không có tài khoản? <a href="register.php">Đăng ký</a></p>
			</div>
		</div>
	</div>
</body>

<script>
	const toggleButton = document.getElementById('passwordToggle');
	const passwordInput = document.getElementById('password');

	if (toggleButton && passwordInput) {
		toggleButton.addEventListener('click', () => {
			const isPassword = passwordInput.type === 'password';
			const eyeIcon = toggleButton.querySelector('.eye-icon');

			passwordInput.type = isPassword ? 'text' : 'password';

			if (eyeIcon) {
				eyeIcon.classList.toggle('show-password', isPassword);
			}

			toggleButton.style.transform = 'scale(0.9)';
			setTimeout(() => {
				toggleButton.style.transform = 'scale(1)';
			}, 150);

			passwordInput.focus();
		});
	}
</script>

</html>