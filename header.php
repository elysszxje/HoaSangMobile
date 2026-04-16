<style>
    .member {
        position: relative;
    }

    .menuMember {
        position: absolute;
        top: 100%;
        left: 0;
        display: none;
        background: white;
        border: 1px solid #ccc;
        min-width: 180px;
        padding: 10px 0;
        z-index: 99;
    }

    .menuMember a {
        display: block;
        padding: 8px 12px;
        white-space: nowrap;
    }

    .member:hover .menuMember {
        display: block;
    }
</style>
<div class="header group">
    <div class="logo">
        <a href="index.php">
            <img src="img/hoasang.jpg" alt="Trang chủ Smartphone Store" title="Trang chủ Smartphone Store">
        </a>
    </div> <!-- End Logo -->

    <div class="content">
        <div class="search-header" style="position: relative; left: 162px; top: 1px;">
            <form class="input-search" method="get" action="products.php">
                <div class="autocomplete">
                    <input id="search-box" name="search" autocomplete="off" type="text" placeholder="Nhập từ khóa tìm kiếm...">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                        Tìm kiếm
                    </button>
                </div>
            </form> <!-- End Form search -->
        </div> <!-- End Search header -->

        <div class="tools-member">
            <div class="member">
                <a>
                    <i class="fa fa-user"></i>
                    Tài khoản
                </a>

                <div class="menuMember">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="login.php">Đăng nhập</a>
                        <a href="register.php">Đăng ký</a>
                    <?php else: ?>
                        <a href="doimatkhau.php">Đổi mật khẩu</a>
                        <a href="lichsudonhang.php">Lịch sử đơn hàng</a>
                        <a href="logout.php" onclick="return confirm('Xác nhận đăng xuất?')">Đăng xuất</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="cart">
                    <a href="giohang.php">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                        <span class="cart-number"></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div> <!-- End Content -->
</div>