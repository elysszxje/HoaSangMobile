<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $product_id = $_POST['product_id'] ?? null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/hoasang/img/banners/';
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = time() . '_' . $_FILES['image']['name'];

        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed)) {
            $error = "File không hợp lệ (chỉ JPG, PNG, GIF).";
        } else {
            if (!move_uploaded_file($fileTmpPath, $uploadDir . $fileName)) {
                $error = "Lỗi upload file!";
            } else {
                $imagePath = "img/banners/" . $fileName;
            }
        }
    } else {
        $imagePath = "";
    }

    if (!$error) {
        $stmt = $pdo->prepare("
            INSERT INTO banners (title, thumbnail, product_id)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$title, $imagePath, $product_id]);

        header("Location: banner-list.php");
        exit();
    }
}
?>


<?php if ($error): ?>
    <script type="text/javascript">
        alert("<?= $error ?>");
    </script>
<?php endif; ?>

<?php if ($success): ?>
    <script type="text/javascript">
        alert("<?= $success ?>");
    </script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="../vendors/styles/core.css" />
    <link rel="stylesheet" href="../vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" href="../vendors/styles/style.css" />
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'right.php'; ?>
    <?php include 'left.php'; ?>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="page-header">
                <h4>Thêm banner</h4>
            </div>
            <div class="pd-20 card-box mb-30">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="title" class="col-sm-12 col-md-2 col-form-label">Tiêu Đề</label>
                        <div class="col-sm-12 col-md-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề banner" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="product_id" class="col-sm-12 col-md-2 col-form-label">Liên kết Sản phẩm</label>
                        <div class="col-sm-12 col-md-10">
                            <select class="form-control" name="product_id" id="product_id">
                                <option value="">Không liên kết</option>
                                <?php
                                $stmt = $pdo->query("SELECT id, name FROM products where products.status = 1");
                                while ($p = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-12 col-md-6">
                            <label for="image" class="col-form-label">Hình Ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" required />
                            <small>Chỉ cho phép tải lên hình ảnh (JPG, PNG, GIF).</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="banner-list.php" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
</body>

</html>