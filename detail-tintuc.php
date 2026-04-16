<?php
require 'connect.php';

$blog_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$blog_id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    echo "Blog not found.";
    exit;
}

$stmt_related = $pdo->prepare("SELECT * FROM blogs WHERE id != ? ORDER BY created_at DESC LIMIT 3");
$stmt_related->execute([$blog_id]);
$related_blogs = $stmt_related->fetchAll(PDO::FETCH_ASSOC);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/taikhoan.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/tintuc.css">
    <link rel="stylesheet" href="css/detail-tintuc.css">
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
    <!-- js -->
    <script src="data/products.js"></script>
    <script src="js/dungchung.js"></script>
</head>

<body>
    <?php include 'nav.php'; ?>

    <section style="min-height: 85vh;">
        <?php include 'header.php'; ?>

        <div class="body-tintuc">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="title mb-4"><?php echo $blog['title']; ?></h1>

                        <div class="meta mb-3">
                            <span class="text-muted"><?php echo date("d/m/Y", strtotime($blog['created_at'])); ?></span>
                        </div>

                        <div class="thumbnail mb-4 text-center">
                            <img src="<?php echo $blog['thumbnail']; ?>" alt="<?php echo $blog['title']; ?>" class="img-fluid rounded shadow">
                        </div>

                        <div class="content-body">
                            <p><?php echo nl2br($blog['content']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
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