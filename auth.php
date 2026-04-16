<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'login') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['pass']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = :username AND TrangThai = 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu.'); window.location.href='login.php';</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] == 'register') {
    $ho = htmlspecialchars($_POST['ho']);
    $ten = htmlspecialchars($_POST['ten']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['newUser']);
    $password = htmlspecialchars($_POST['newPass']);
    $dienThoai = htmlspecialchars($_POST['dienThoai']);
    $diaChi = htmlspecialchars($_POST['diaChi']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $role = 'User';

    $stmt = $pdo->prepare("SELECT id FROM users WHERE Username = :username OR Email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại!'); window.location.href='signup.php';</script>";
        exit;
    }

    $sql = "INSERT INTO users (Username, Password, HoTen, Email, DienThoai, DiaChi, Role) 
            VALUES (:username, :password, :hoTen, :email, :dienThoai, :diaChi, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'password' => $hashedPassword,
        'hoTen' => $ho . ' ' . $ten,
        'email' => $email,
        'dienThoai' => $dienThoai,
        'diaChi' => $diaChi,
        'role' => $role
    ]);

    echo "<script>alert('Đăng ký thành công!');</script>";
}
?>


<div class="containTaikhoan">
    <div class="taikhoan">

        <ul class="tab-group">
            <li class="tab active"><a href="#login">Đăng nhập</a></li>
            <li class="tab"><a href="#signup">Đăng kí</a></li>
        </ul> <!-- /tab group -->

        <div class="tab-content">
            <div id="login">
                <h1>Đăng nhập</h1>

                <form method="POST">
                    <div class="field-wrap">
                        <label>
                            Tên đăng nhập<span class="req">*</span>
                        </label>
                        <input name="username" type="text" required autocomplete="off" />
                    </div> <!-- /user name -->

                    <div class="field-wrap">
                        <label>
                            Mật khẩu<span class="req">*</span>
                        </label>
                        <input name="pass" type="password" required autocomplete="off" />
                    </div> <!-- /pass -->

                    <p class="forgot"><a href="#">Quên mật khẩu?</a></p>

                    <!-- Nút đăng nhập với giá trị "login" -->
                    <button type="submit" name="submit" value="login" class="button button-block">Tiếp tục</button>
                </form> <!-- /form -->
            </div> <!-- /login -->


            <div id="signup">
                <h1>Đăng kí miễn phí</h1>

                <form method="POST">

                    <div class="top-row">
                        <div class="field-wrap">
                            <label>
                                Họ<span class="req">*</span>
                            </label>
                            <input name="ho" type="text" required autocomplete="off" />
                        </div>

                        <div class="field-wrap">
                            <label>
                                Tên<span class="req">*</span>
                            </label>
                            <input name="ten" type="text" required autocomplete="off" />
                        </div>
                    </div> <!-- / ho ten -->

                    <div class="field-wrap">
                        <label>
                            Địa chỉ Email<span class="req">*</span>
                        </label>
                        <input name="email" type="email" required autocomplete="off" />
                    </div> <!-- /email -->

                    <div class="field-wrap">
                        <label>
                            Tên đăng nhập<span class="req">*</span>
                        </label>
                        <input name="newUser" type="text" required autocomplete="off" />
                    </div> <!-- /user name -->

                    <div class="field-wrap">
                        <label>
                            Mật khẩu<span class="req">*</span>
                        </label>
                        <input name="newPass" type="password" required autocomplete="off" />
                    </div> <!-- /pass -->

                    <div class="field-wrap">
                        <label>
                            Điện thoại<span class="req">*</span>
                        </label>
                        <input name="dienThoai" type="text" required autocomplete="off" />
                    </div> <!-- /phone -->

                    <div class="field-wrap">
                        <label>
                            Địa chỉ<span class="req">*</span>
                        </label>
                        <input name="diaChi" type="text" required autocomplete="off" />
                    </div> <!-- /address -->

                    <button type="submit" name="submit" value="register" class="button button-block">Tạo tài khoản</button>

                </form> <!-- /form -->

            </div> <!-- /sign up -->

        </div><!-- tab-content -->

    </div> <!-- /taikhoan -->
</div>