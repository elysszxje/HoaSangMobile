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
    $productName = $_POST['ProductName'];
    $brandId = $_POST['BrandId'];
    $price = $_POST['Price'];
    $screen = $_POST['Screen'];
    $os = $_POST['OS'];
    $camera = $_POST['Camera'];
    $cameraFront = $_POST['CameraFront'];
    $cpu = $_POST['CPU'];
    $ram = $_POST['RAM'];
    $rom = $_POST['ROM'];
    $battery = $_POST['Battery'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/hoasang/img/products/';  
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
                $imagePath = 'img/products/' . $newFileName;

                $stmt = $pdo->prepare("INSERT INTO products (name, company_id, img, price, screen, os, camera, cameraFront, cpu, ram, rom, battery) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$productName, $brandId, $imagePath, $price, $screen, $os, $camera, $cameraFront, $cpu, $ram, $rom, $battery]);

                $success = "Thêm sản phẩm thành công!";
                header("Location: sanpham-list.php");
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
                                <h4> Thêm Sản Phẩm</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Thêm Sản Phẩm
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Thêm Sản Phẩm mới</h4>
                    </div>
                    <div class="pb-20">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="ProductName" class="col-form-label">Tên Sản Phẩm</label>
                                    <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Nhập tên sản phẩm" required />
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="BrandId" class="col-form-label">Thương Hiệu</label>
                                    <select class="form-control" id="BrandId" name="BrandId" required>
                                        <option value="">Chọn Thương Hiệu</option>
                                        <?php
                                        $stmt = $pdo->query("SELECT * FROM brands");
                                        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($brands as $brand): ?>
                                            <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="image" class="col-form-label">Hình Ảnh</label>
                                    <input type="file" class="form-control" id="image" name="image" required />
                                    <small>Chỉ cho phép tải lên hình ảnh (JPG, PNG, GIF).</small>
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="Price" class="col-form-label">Giá</label>
                                    <input type="number" class="form-control" id="Price" name="Price" placeholder="Nhập giá sản phẩm" required />
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="Screen" class="col-form-label">Màn Hình</label>
                                    <input type="text" class="form-control" id="Screen" name="Screen" placeholder="Màn hình sản phẩm" required />
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="OS" class="col-form-label">Hệ Điều Hành</label>
                                    <input type="text" class="form-control" id="OS" name="OS" placeholder="Hệ điều hành sản phẩm" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="Camera" class="col-form-label">Camera Chính</label>
                                    <input type="text" class="form-control" id="Camera" name="Camera" placeholder="Camera chính sản phẩm" required />
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="CameraFront" class="col-form-label">Camera Trước</label>
                                    <input type="text" class="form-control" id="CameraFront" name="CameraFront" placeholder="Camera trước sản phẩm" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="CPU" class="col-form-label">CPU</label>
                                    <input type="text" class="form-control" id="CPU" name="CPU" placeholder="Thông tin CPU sản phẩm" required />
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="RAM" class="col-form-label">RAM</label>
                                    <input type="text" class="form-control" id="RAM" name="RAM" placeholder="Thông tin RAM sản phẩm" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="ROM" class="col-form-label">ROM</label>
                                    <input type="text" class="form-control" id="ROM" name="ROM" placeholder="Thông tin ROM sản phẩm" required />
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <label for="Battery" class="col-form-label">Pin</label>
                                    <input type="text" class="form-control" id="Battery" name="Battery" placeholder="Thông tin dung lượng pin" required />
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="sanpham-list.php" class="btn btn-secondary">Quay lại</a>
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