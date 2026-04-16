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
    $brandName = $_POST['BrandName'];

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../img/company/'; 
        $fileTmpPath = $_FILES['logo']['tmp_name'];
        $fileName = $_FILES['logo']['name'];
        $fileSize = $_FILES['logo']['size'];
        $fileType = $_FILES['logo']['type'];

        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedFileTypes)) {
            $error = "Chỉ cho phép tải lên các tệp hình ảnh (JPG, PNG, GIF).";
        } else {
            $newFileName = time() . '_' . basename($fileName);
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $logoPath = 'img/company/' . $newFileName;  

                $stmt = $pdo->prepare("INSERT INTO brands (name, logo) VALUES (?, ?)");
                $stmt->execute([$brandName, $logoPath]);

                $success = "Thêm thương hiệu thành công!";
                header("Location: thuonghieu-list.php");  
                exit();
            } else {
                $error = "Có lỗi khi tải ảnh lên!";
            }
        }
    } else {
        $error = "Vui lòng chọn ảnh tải lên!";
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
                                <h4> Thêm Thương Hiệu</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Thêm thương hiệu
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Thêm thương hiệu mới</h4>
                    </div>
                    <div class="pb-20">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="BrandName" class="col-sm-12 col-md-2 col-form-label">Tên thương hiệu</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" id="BrandName" name="BrandName" placeholder="Nhập tên thương hiệu" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="logo" class="col-sm-12 col-md-2 col-form-label">Ảnh thương hiệu</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="file" class="form-control" id="logo" name="logo" required />
                                    <small>Chỉ cho phép tải lên hình ảnh (JPG, PNG, GIF).</small>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="thuonghieu-list.php" class="btn btn-secondary">Quay lại</a>
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
</body>

</html>