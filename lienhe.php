<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Không xử lý gửi mail, chỉ hiển thị thông báo thành công cho có luồng giao diện
    echo "<script>alert('Gửi thông tin liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất!');</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liên hệ - HoaSang Store</title>
    <link rel="shortcut icon" href="img/favicon.ico" />

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        crossorigin="anonymous">

    <!-- our files -->
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/taikhoan.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/lienhe.css">

    <!-- js -->
    <script src="data/products.js"></script>
    <script src="js/dungchung.js"></script>
    <script src="js/lienhe.js"></script>
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
</head>

<body>
    <?php include 'nav.php'; ?>

    <section style="min-height: 85vh">
        <?php include 'header.php'; ?>

        <div class="body-lienhe">
            <div class="lienhe-header">Liên hệ</div>
            <div class="lienhe-info">
                <div class="info-left">
                    <p>
                    <h2 style="color: gray"> CÔNG TY CỔ PHẦN HoaSang </h2><br />
                    <b>Địa chỉ:</b> 109 Cộng Hoà, Phường 12, Tân Bình, TP. Hồ Chí Minh<br /><br />
                    <b>Hotline:</b> 0937940243<br /><br />
                    <b>E-mail:</b> hoasanginfotech@gmail.com<br /><br />
                    <b>Mã số thuế:</b> 0314868012 <br /><br />
                    <b>Tài khoản ngân hàng :</b><br /><br />
                    <b>Số TK:</b> 0937940243 <br /><br />
                    <b>Tại Ngân hàng:</b> Agribank Chi nhánh TP. Hồ Chí Minh<br /><br /><br /><br />
                    <b>Quý khách có thể gửi liên hệ tới chúng tôi bằng cách hoàn tất biểu mẫu dưới đây. Chúng tôi
                        sẽ trả lời thư của quý khách, xin vui lòng khai báo đầy đủ. Hân hạnh phục vụ và chân thành
                        cảm ơn sự quan tâm, đóng góp ý kiến đến HoaSang Store.</b>
                    </p>
                </div>
                <div class="info-right">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.1312235073538!2d106.64974957586892!3d10.801260258733413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529c4ccb8f037%3A0x9244a933a1570b9a!2zQ8O0bmcgdHkgVE5ISCBDw7RuZyBOZ2jhu4cgSG9hIFPDoW5n!5e0!3m2!1svi!2s!4v1776139026017!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <br />
                </div>
            </div>
            <div class="container my-5">
                <div class="card shadow-sm p-4">
                    <h2 class="mb-4 text-center">Liên hệ với chúng tôi</h2>
                    <form name="formlh" id="contactForm" method="POST" action="">
                        <div class="mb-3">
                            <label for="ht" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="ht" name="ht" maxlength="40" placeholder="Họ tên" required>
                        </div>

                        <div class="mb-3">
                            <label for="sdt" class="form-label">Điện thoại liên hệ</label>
                            <input type="text" class="form-control" id="sdt" name="sdt" maxlength="11" minlength="10" placeholder="Điện thoại" required>
                        </div>

                        <div class="mb-3">
                            <label for="em" class="form-label">Email</label>
                            <input type="email" class="form-control" id="em" name="em" placeholder="Email" required>
                        </div>

                        <div class="mb-3">
                            <label for="tde" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="tde" name="tde" maxlength="100" placeholder="Tiêu đề" required>
                        </div>

                        <div class="mb-3">
                            <label for="nd" class="form-label">Nội dung</label>
                            <textarea class="form-control" id="nd" name="nd" rows="5" maxlength="500" placeholder="Nội dung liên hệ" required></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn btn-danger w-100">Gửi thông tin liên hệ</button>
                    </form>
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