<?php
require 'connect.php';

$stmt = $pdo->query("SELECT * FROM blogs");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tin tức - HoaSang Store</title>
    <link rel="shortcut icon" href="img/favicon.ico" />

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        crossorigin="anonymous">

    <!-- our files -->
    <!-- css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/taikhoan.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/tintuc.css">

    <!-- js -->
    <script src="data/products.js"></script>
    <script src="js/dungchung.js"></script>
</head>

<body>
    <?php include 'nav.php'; ?>

    <section style="min-height: 85vh">
        <?php include 'header.php'; ?>

        <div class="body-tintuc">
            <?php foreach ($blogs as $blog): ?>
                <div class="tintuc-info">
                    <a href="detail-tintuc.php?id=<?php echo $blog['id']; ?>">
                        <img src="<?php echo $blog['thumbnail']; ?>" alt="<?php echo $blog['title']; ?>">
                        <h2><?php echo $blog['title']; ?></h2>
                    </a>
                    <br />
                    <h5>&emsp;<?php echo $blog['created_at']; ?></h5>
                </div>
            <?php endforeach; ?>
        </div>

    </section>

    

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