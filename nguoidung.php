<!DOCTYPE html>
<html lang="vi">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>HoaSang Store</title>
	<link rel="shortcut icon" href="img/favicon.ico" />

	<!-- Load font awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
		crossorigin="anonymous">

	<script src="js/Jquery/Jquery.min.js"></script>

	<!-- our files -->
	<!-- css -->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/topnav.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/taikhoan.css">
	<link rel="stylesheet" href="css/gioHang.css">
	<link rel="stylesheet" href="css/nguoidung.css">
	<link rel="stylesheet" href="css/footer.css">
	<!-- js -->
	<script src="data/products.js"></script>
	<script src="js/classes.js"></script>
	<script src="js/dungchung.js"></script>
	<script src="js/nguoidung.js"></script>

</head>

<body>
	<?php include 'nav.php'; ?>

	<section>
		<?php include 'header.php'; ?>
		<img src="img/banners/blackFriday.gif" alt="" style="width: 100%;">

		<div class="infoUser">

		</div>

		<div class="listDonHang"> </div>
	</section> <!-- End Section -->

	<script>
		addContainTaiKhoan(); 
	</script>
	<div class="plc">
		<section>
			<ul class="flexContain">
				<li>Giao hàng hỏa tốc trong 1 giờ</li>
				<li>Thanh toán linh hoạt: tiền mặt, visa / master, trả góp</li>
				<li>Trải nghiệm sản phẩm tại nhà</li>
				<li>Lỗi đổi tại nhà trong 1 ngày</li>
				<li>Hỗ trợ suốt thời gian sử dụng.
					<br>Hotline:
					<a href="tel:12345678" style="color: #288ad6;">12345678</a>
				</li>
			</ul>
		</section>
	</div>

	<div class="footer">
		<?php include 'footer.php'; ?>
	</div>

	<i class="fa fa-arrow-up" id="goto-top-page" onclick="gotoTop()"></i>
	<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

	<script>
		function gotoTop() {
			if (window.jQuery) {
				jQuery('html,body').animate({
					scrollTop: 0
				}, 100);
			} else {
				document.getElementsByClassName('top-nav')[0].scrollIntoView({
					behavior: 'smooth',
					block: 'start'
				});
				document.body.scrollTop = 0; 
				document.documentElement.scrollTop = 0; 
			}
		}
	</script>
</body>
</html>