<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$error = '';
$success = '';

$blogId = $_GET['id'];

if (!$blogId) {
    header("Location: tintuc-list.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$blogId]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    $error = "Bài viết không tồn tại!";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $imagePath = $blog['thumbnail'];

        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/hoasang/img/blogs/';
            $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
            $fileName = $_FILES['thumbnail']['name'];
            $fileType = $_FILES['thumbnail']['type'];

            $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileType, $allowedFileTypes)) {
                $newFileName = time() . '_' . basename($fileName);
                $uploadPath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    $imagePath = 'img/blogs/' . $newFileName;
                } else {
                    $error = "Có lỗi khi tải ảnh lên!";
                }
            } else {
                $error = "Chỉ cho phép tải lên các tệp hình ảnh (JPG, PNG, GIF).";
            }
        }

        if (!$error) {
            $stmt = $pdo->prepare("UPDATE blogs 
                                    SET title = ?, thumbnail = ?, content = ?, updated_at = CURRENT_TIMESTAMP
                                    WHERE id = ?");
            $stmt->execute([$title, $imagePath, $content, $blogId]);

            $success = "Cập nhật tin tức thành công!";
            header("Location: tintuc-list.php");
            exit();
        }
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
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>Admin</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css" />
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'right.php'; ?>
    <?php include 'left.php'; ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4> Cập nhật tin tức</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Cập nhật tin tức
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Cập nhật tin tức</h4>
                    </div>
                    <div class="pb-20">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="title" class="col-form-label">Tiêu Đề</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($blog['title']) ?>" placeholder="Nhập tiêu đề tin tức" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-12">
                                    <label for="content" class="col-form-label">Nội Dung</label>
                                    <textarea name="content" id="content" class="form-control" placeholder="Nhập nội dung tin tức" required><?= htmlspecialchars($blog['content']) ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="thumbnail" class="col-form-label">Hình Ảnh</label>
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" />
                                    <small>Chỉ cho phép tải lên hình ảnh (JPG, PNG, GIF).</small>
                                    <?php if ($blog['thumbnail']): ?>
                                        <br><img src="<?= $blog['thumbnail'] ?>" width="100" height="100" alt="Current Image">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                            <a href="tintuc-list.php" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendors/scripts/core.js"></script>
    <script src="../vendors/scripts/script.min.js"></script>
    <script src="../vendors/scripts/process.js"></script>
    <script src="../vendors/scripts/layout-settings.js"></script>
    <script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <!-- buttons for Export datatable -->
    <script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="../src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="../src/plugins/datatables/js/vfs_fonts.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>


</body>

</html>