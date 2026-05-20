<?php
require 'connect.php';
session_start();

$stmt = $pdo->query("
    SELECT p.id, p.name, p.created_at, p.updated_at, p.img, p.price, b.name AS brand_name, p.star, p.rateCount
    FROM products p
    JOIN brands b ON p.company_id = b.id
    WHERE p.status = 1
    ORDER BY p.star DESC 
    LIMIT 5
");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("
    SELECT p.id, p.name, p.created_at, p.updated_at, p.img, p.price, b.name AS brand_name, p.star, p.rateCount
    FROM products p
    JOIN brands b ON p.company_id = b.id
    WHERE p.status = 1
    ORDER BY p.created_at DESC 
    LIMIT 5
");

$newestProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);


$brandStmt = $pdo->query("SELECT id, name, logo FROM brands ORDER BY name ASC");
$brands = $brandStmt->fetchAll(PDO::FETCH_ASSOC);

$bannerStmt = $pdo->query("SELECT * FROM banners ORDER BY id DESC");
$banners = $bannerStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>HoaSang Store</title>
	<link rel="shortcut icon" href="img/favicon.ico" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Load font awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
		crossorigin="anonymous">

	<!-- owl carousel libraries -->
	<link rel="stylesheet" href="js/owlcarousel/owl.carousel.min.css">
	<link rel="stylesheet" href="js/owlcarousel/owl.theme.default.min.css">
	<script src="js/Jquery/Jquery.min.js"></script>
	<script src="js/owlcarousel/owl.carousel.min.js"></script>

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/topnav.css">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/banner.css">
	<link rel="stylesheet" href="css/taikhoan.css">
	<link rel="stylesheet" href="css/trangchu.css">
	<link rel="stylesheet" href="css/home_products.css">
	<link rel="stylesheet" href="css/pagination_phantrang.css">
	<link rel="stylesheet" href="css/footer.css">
	<script src="data/products.js"></script>
	<script src="js/classes.js"></script>
	<script src="js/dungchung.js"></script>
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

	<!-- Owl Carousel JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

	<!-- Script của bạn -->

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

		.banner-slider {
			position: relative;
			width: 100%;
			max-width: 1100px;
			margin: 20px auto;
			overflow: hidden;
			border-radius: 10px;
		}

		.slide {
			position: absolute;
			width: 100%;
			opacity: 0;
			transition: opacity 0.8s ease-in-out;
		}

		.slide.active {
			opacity: 1;
			position: relative;
		}

		.banner-slider img {
			width: 100%;
			display: block;
		}

		/* Nút điều hướng */
		.nav {
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
			font-size: 40px;
			color: white;
			cursor: pointer;
			padding: 10px;
			transition: 0.3s;
			user-select: none;
		}

		.nav:hover {
			color: #ffcc00;
		}

		.prev {
			left: 10px;
		}

		.next {
			right: 10px;
		}

		/* Dots */
		.dots {
			position: absolute;
			bottom: 12px;
			left: 50%;
			transform: translateX(-50%);
			display: flex;
			gap: 8px;
		}

		.dots span {
			width: 12px;
			height: 12px;
			border-radius: 50%;
			background: #ddd;
			cursor: pointer;
			transition: 0.3s;
		}

		.dots span.active {
			background: #ff6600;
		}

		.brand-card {
			width: 100px;
			height: 100px;
			display: flex;
			align-items: center;
			justify-content: center;
		}
	</style>

</head>

<body>
	<?php include 'nav.php'; ?>

	<section>
		<?php include 'header.php'; ?>

		<?php
		$filtered = array_filter($banners, function ($b) {
			return !empty($b['thumbnail']); // chỉ lấy banner có ảnh
		});
		$filtered = array_values($filtered); // reset index
		?>

		<div class="banner-slider">

			<?php foreach ($filtered as $index => $b): ?>
				<a href="detail.php?id=<?php echo $b['product_id']; ?>">
					<div class="slide <?php echo $index === 0 ? 'active' : ''; ?>">
						<img src="<?php echo htmlspecialchars($b['thumbnail']); ?>"
							alt="Banner <?php echo $index + 1; ?>">
					</div>
				</a>
			<?php endforeach; ?>

			<div class="nav prev">❮</div>
			<div class="nav next">❯</div>

			<div class="dots">
				<?php foreach ($filtered as $index => $b): ?>
					<span class="dot <?php echo $index === 0 ? 'active' : ''; ?>"
						data-index="<?php echo $index; ?>"></span>
				<?php endforeach; ?>
			</div>

		</div>



		<img src="img/banners/blackFriday.gif" alt="" style="width: 100%;">

		<br>
		<div class="container my-4">
			<div class="row g-3">

				<?php foreach ($brands as $brand): ?>
					<div class="col-4 col-sm-3 col-md-2 col-lg-2">
						<a href="products.php?brand_id=<?= $brand['id'] ?>"
							class="text-decoration-none d-block brand-item">

							<div class="card shadow-sm border-0 rounded-3 p-2 text-center brand-card">
								<img src="<?= $brand['logo'] ?>"
									class="img-fluid brand-logo"
									alt="<?= $brand['name'] ?>">
							</div>

						</a>
					</div>
				<?php endforeach; ?>

			</div>
		</div>



		</div>
		<hr>

		<div class="contain-khungSanPham">
			<div class="khungSanPham" style="border-color: #ff5733;">
				<h3 class="tenKhung" style="background-image: linear-gradient(120deg, #ff5733 0%, #ff9c33 50%, #ff5733 100%);">* Nổi Bật Nhất *</h3>
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
								<div class="tooltip">
									<button class="themvaogio" onclick="themVaoGioHang('<?= $product['id']; ?>', '<?= $product['name']; ?>'); return false;">
										<span class="tooltiptext" style="font-size: 15px;">Thêm vào giỏ</span>
										+
									</button>
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</div>
				<a class="xemTatCa" href="products.php" style="border-left: 2px solid #ff5733; border-right: 2px solid #ff5733;">
					Xem thêm
				</a>
			</div>
			<hr>

			<!-- Khung 2 -->
			<div class="khungSanPham" style="border-color: #28a745;">
				<h3 class="tenKhung" style="background-image: linear-gradient(120deg, #28a745 0%, #56d22a 50%, #28a745 100%);">* Mới Về Hàng *</h3>
				<div class="listSpTrongKhung flexContain">
					<?php foreach ($newestProducts as $product): ?>
						<li class="sanPham">
							<a href="detail.php?id=<?= urlencode($product['id']) ?>">
								<img src="<?= htmlspecialchars($product['img']) ?>" alt="">
								<h3><?= htmlspecialchars($product['name']) ?></h3>
								<div class="price">
									<strong><?= number_format($product['price'], 0, ',', '.') ?>&#8363;</strong>
								</div>
								<div class="ratingresult">
									<?php for ($i = 0; $i < 5; $i++): ?>
										<i class="fa fa-star <?= $i < $product['star'] ? '' : 'fa-star-o' ?>"></i>
									<?php endfor; ?>
									<span><?= number_format($product['rateCount'], 0, ',', '.') ?> đánh giá</span>
								</div>
								<div class="tooltip">
									<button class="themvaogio" onclick="themVaoGioHang('<?= $product['id'] ?>', '<?= htmlspecialchars($product['name']) ?>'); return false;">
										<span class="tooltiptext" style="font-size: 15px;">Thêm vào giỏ</span>
										+
									</button>
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</div>
				<a class="xemTatCa" href="products.php" style="border-left: 2px solid #28a745; border-right: 2px solid #28a745;">
					Xem thêm
				</a>
			</div>

			<hr>

		</div>

	</section> <!-- End Section -->



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

		document.addEventListener("DOMContentLoaded", function() {
			const slides = document.querySelectorAll(".slide");
			const dotsContainer = document.querySelector(".dots");
			let index = 0;
			let autoSlide;

			const dots = document.querySelectorAll(".dots span");

			function showSlide(i) {
				slides.forEach(s => s.classList.remove("active"));
				dots.forEach(d => d.classList.remove("active"));

				slides[i].classList.add("active");
				dots[i].classList.add("active");
			}

			function nextSlide() {
				index = (index + 1) % slides.length;
				showSlide(index);
			}

			function prevSlide() {
				index = (index - 1 + slides.length) % slides.length;
				showSlide(index);
			}

			// Auto slide
			function startAuto() {
				autoSlide = setInterval(nextSlide, 3500);
			}

			function stopAuto() {
				clearInterval(autoSlide);
			}

			// Gán sự kiện nút
			document.querySelector(".next").onclick = () => {
				stopAuto();
				nextSlide();
				startAuto();
			};

			document.querySelector(".prev").onclick = () => {
				stopAuto();
				prevSlide();
				startAuto();
			};

			// Gán sự kiện cho dots
			dots.forEach(dot => {
				dot.onclick = () => {
					stopAuto();
					index = parseInt(dot.dataset.index);
					showSlide(index);
					startAuto();
				};
			});

			// Khởi động slider
			showSlide(index);
			startAuto();
		});
	</script>
</body>
</html>