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
    $content = $_POST['content'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/hoasang/img/blogs/';
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedFileTypes)) {
            $error = "Chỉ cho phép tải lên các tệp hình ảnh (JPG, PNG, GIF).";
        } else {
            $newFileName = time() . '_' . basename($fileName);
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $imagePath = 'img/blogs/' . $newFileName;
            } else {
                $error = 'Lỗi khi tải ảnh lên!';
            }
        }
    } else {
        $imagePath = '';
    }

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO blogs (title, content, thumbnail, created_at, updated_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
        $stmt->execute([$title, $content, $imagePath]);

        $success = "Thêm tin tức thành công!";
        header("Location: tintuc-list.php");
        exit();
    } else {
        $error = "Vui lòng điền đầy đủ thông tin!";
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
                <h4>Thêm tin tức</h4>
            </div>
            <div class="pd-20 card-box mb-30">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="title" class="col-sm-12 col-md-2 col-form-label">Tiêu Đề</label>
                        <div class="col-sm-12 col-md-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề tin tức" required />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="content" class="col-sm-12 col-md-2 col-form-label">Nội Dung</label>
                        <div class="col-sm-12 col-md-10">
                            <textarea name="content" id="content" class="form-control" placeholder="Nhập nội dung tin tức"></textarea>
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
                    <a href="tintuc-list.php" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>

    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>

</html>