<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Giới thiệu - HoaSang Store</title>
    <link rel="shortcut icon" href="img/favicon.ico" />

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- our files -->
    <!-- css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/taikhoan.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/gioithieu.css">

    <!-- js -->
    <script src="data/products.js"></script>
    <script src="js/dungchung.js"></script>
    <script>
        window.onload = function() {
            khoiTao();
            // thêm tags (từ khóa) vào khung tìm kiếm
            var tags = ["Samsung", "iPhone", "Huawei", "Oppo", "Mobi"];
            for (var t of tags) addTags(t, "index.php?search=" + t);
        }
    </script>

    <style>
        .page-gt {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
            font-family: "Segoe UI", sans-serif;
        }

        .page-gt .page-header {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            border-left: 4px solid #007bff;
            padding-left: 12px;
            margin-bottom: 20px;
        }

        .page-info p {
            font-size: 18px;
            line-height: 1.7;
            color: #555;
            margin-bottom: 15px;
        }

        .page-info br {
            margin-bottom: 10px;
        }

        .page-info {
            padding: 10px 5px;
        }
    </style>

</head>

<body>
    <?php include 'nav.php'; ?>

    <section style="min-height: 85vh">
        <?php include 'header.php'; ?>

        <div class="page-gt">
            <h4 class="page-header">
                Giới thiệu
            </h4>
            <div class="page-info">
                <p>Công ty TNHH Công nghệ Hoa Sáng là một doanh nghiệp hoạt động trong lĩnh vực công
                    nghệ thông tin, chuyên cung cấp các giải pháp phần mềm, thiết kế website và ứng dụng
                    di động hiện đại.
                </p>
                <br />
                <p>
                    Với bề dày gần 10 năm kinh nghiệm và uy tín đã tạo được trong những năm vừa qua, chúng tôi luôn đem
                    lại cho khách hàng sự hài lòng và thỏa mãn với tất cả các sản phẩm của mình.<br />
                    Bên cạnh đó là đội ngũ nhân viên nhiệt tình chu đáo và đầy kinh nghiệm của chúng tôi luôn đưa được
                    ra cho khách hàng những thông tin có giá trị và giúp khách hàng lựa chọn được những sản phẩm phù
                    hợp nhất.<br />
                    Để nâng cao thương hiệu của mình, mục tiêu của chúng tôi trong thời gian tới là cung cấp đến tận
                    tay khách hàng những sản phẩm chính hãng với chất lượng đảm bảo và uy tín cũng như giá cả hợp lý
                    nhất.<br />
                    Chúng tôi mong muốn sự đóng góp của khách hàng sẽ giúp chúng tôi ngày một phát triển để từ đó củng
                    cố thêm lòng tin của khách hàng với chúng tôi. Chúng tôi rất biết ơn sự tin tưởng của khách hàng
                    trong suốt gần 10 năm qua và chúng tôi luôn tâm niệm rằng cần phải cố gắng hơn nữa để xứng đáng với
                    phương châm đề ra “Nếu những gì chúng tôi không có, nghĩa là bạn không cần .<br />
                    Chúng tôi xin chân thành cảm ơn tất cả các khách hàng đã, đang và sẽ ủng hộ chúng tôi.
                </p>
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