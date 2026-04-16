<?php
require 'connect.php';


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;

$priceMin = isset($_GET['priceMin']) ? (int)$_GET['priceMin'] : 0;
$priceMax = isset($_GET['priceMax']) ? (int)$_GET['priceMax'] : PHP_INT_MAX;
$star     = isset($_GET['star']) ? (int)$_GET['star'] : null;
$search   = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$brand_id = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : null;

$sort  = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

$validSortColumns = ['price', 'star', 'rateCount', 'name', 'created_at'];
$validOrderDirections = ['ASC', 'DESC'];

if (!in_array($sort, $validSortColumns)) $sort = 'created_at';
if (!in_array(strtoupper($order), $validOrderDirections)) $order = 'DESC';

$offset = ($page - 1) * $perPage;


$query = "
    SELECT p.id, p.name, p.created_at, p.updated_at, p.img, p.price, 
           b.name AS brand_name, p.star, p.rateCount
    FROM products p
    JOIN brands b ON p.company_id = b.id
    WHERE p.status = 1
      AND p.price BETWEEN :priceMin AND :priceMax
";

if ($star !== null)      $query .= " AND p.star = :star";
if ($search !== '')       $query .= " AND p.name LIKE :search";
if ($brand_id !== null)   $query .= " AND p.company_id = :brand_id";

$query .= " ORDER BY $sort $order
            LIMIT $perPage OFFSET $offset";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':priceMin', $priceMin);
$stmt->bindParam(':priceMax', $priceMax);

if ($star !== null) {
	$stmt->bindParam(':star', $star, PDO::PARAM_INT);
}
if ($search !== '') {
	$stmt->bindValue(':search', "%$search%");
}
if ($brand_id !== null) {
	$stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


$countQuery = "
    SELECT COUNT(*) AS total
    FROM products p
    JOIN brands b ON p.company_id = b.id
    WHERE p.status = 1
      AND p.price BETWEEN :priceMin AND :priceMax
";

if ($star !== null)      $countQuery .= " AND p.star = :star";
if ($search !== '')       $countQuery .= " AND p.name LIKE :search";
if ($brand_id !== null)   $countQuery .= " AND p.company_id = :brand_id";

$totalStmt = $pdo->prepare($countQuery);

$totalStmt->bindParam(':priceMin', $priceMin);
$totalStmt->bindParam(':priceMax', $priceMax);

if ($star !== null) {
	$totalStmt->bindParam(':star', $star);
}
if ($search !== '') {
	$totalStmt->bindValue(':search', "%$search%");
}
if ($brand_id !== null) {
	$totalStmt->bindParam(':brand_id', $brand_id);
}

$totalStmt->execute();
$total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

$totalPages = ceil($total / $perPage);

$queryString = http_build_query([
	'priceMin' => $priceMin,
	'priceMax' => $priceMax,
	'star'     => $star,
	'sort'     => $sort,
	'order'    => $order,
	'search'   => $search,
	'brand_id' => $brand_id
]);


$brandStmt = $pdo->query("SELECT id, name, logo FROM brands ORDER BY name ASC");
$brands = $brandStmt->fetchAll(PDO::FETCH_ASSOC);
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

	<style>
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
		<div class="flexContain">
			<div class="pricesRangeFilter dropdown">
				<button class="dropbtn">Giá tiền</button>
				<div class="dropdown-content">
					<a href="products.php?priceMin=0&priceMax=5000000">0 - 5 triệu</a>
					<a href="products.php?priceMin=5000000&priceMax=15000000">5 triệu - 15 triệu</a>
					<a href="products.php?priceMin=15000000&priceMax=30000000">15 triệu - 30 triệu</a>
					<a href="products.php?priceMin=30000000">Trên 30 triệu</a>
				</div>
			</div>

			<div class="sortFilter dropdown">
				<button class="dropbtn">Sắp xếp</button>
				<div class="dropdown-content">
					<a href="products.php?sort=price&order=ASC">Giá tăng dần</a>
					<a href="products.php?sort=price&order=DESC">Giá giảm dần</a>
					<a href="products.php?sort=name&order=ASC">Tên A-Z</a>
					<a href="products.php?sort=name&order=ASC">Tên Z-A</a>
				</div>
			</div>

		</div>
		<hr>

		<div class="contain-khungSanPham">
			<div class="khungSanPham">
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
			</div>
			<hr>
		</div>

		<div class="pagination">
			<?php if ($page > 1): ?>
				<a href="products.php?<?= $queryString ?>&page=1">&laquo; Đầu</a>
				<a href="products.php?<?= $queryString ?>&page=<?= $page - 1 ?>">Trước</a>
			<?php endif; ?>

			<?php for ($i = 1; $i <= $totalPages; $i++): ?>
				<a href="products.php?<?= $queryString ?>&page=<?= $i ?>"
					<?= $i == $page ? 'class="active"' : '' ?>>
					<?= $i ?>
				</a>
			<?php endfor; ?>

			<?php if ($page < $totalPages): ?>
				<a href="products.php?<?= $queryString ?>&page=<?= $page + 1 ?>">Sau</a>
				<a href="products.php?<?= $queryString ?>&page=<?= $totalPages ?>">Cuối &raquo;</a>
			<?php endif; ?>
		</div>

		<br>
		<br>
		<br>
		<br>
		<hr>
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
	</script>
</body>
</html>