<style>
    /* General styling for the top navigation */
    .top-nav {
        padding: 10px 0;
        font-family: Arial, sans-serif;
    }

    /* Styling for the social media icons in the navigation */
    .social-top-nav a {
        color: #ffffff;
        /* White color for social media icons */
        margin: 0 10px;
        font-size: 18px;
        transition: color 0.3s ease;
    }


    /* Styling for the quick links in the navigation */
    .top-nav-quicklink {
        list-style: none;
        display: flex;
        justify-content: center;
        margin: 0;
        padding: 0;
    }

    .top-nav-quicklink li {
        margin: 0 15px;
    }

    .top-nav-quicklink a {
        text-decoration: none;
        color: #ffffff;
        /* White text color */
        font-size: 16px;
        display: flex;
        align-items: center;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .top-nav-quicklink a i {
        margin-right: 8px;
        /* Space between icon and text */
    }

    /* Hover effect for quick links */
    .top-nav-quicklink a:hover {
        color: #ffffff;
        /* Keep text white */
        border-radius: 4px;
        padding: 5px 10px;
    }
</style>
<div class="top-nav group">
    <section>
        <ul class="top-nav-quicklink flexContain">
            <li><a href="index.php"><i class="fa fa-home"></i> Trang chủ</a></li>
            <li><a href="products.php"><i class="fa fa-mobile"></i> Sản phẩm</a></li>
            <li><a href="tintuc.php"><i class="fa fa-newspaper-o"></i> Tin tức</a></li>
            <li><a href="gioithieu.php"><i class="fa fa-info-circle"></i> Giới thiệu</a></li>
            <li><a href="trungtambaohanh.php"><i class="fa fa-wrench"></i> Bảo hành</a></li>
            <li><a href="lienhe.php"><i class="fa fa-phone"></i> Liên hệ</a></li>
        </ul>
    </section>
</div>