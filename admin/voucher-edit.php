<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$error = '';
$success = '';

if (isset($_GET['id'])) {
    $voucherId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM vouchers WHERE id = ?");
    $stmt->execute([$voucherId]);
    $voucher = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$voucher) {
        $error = "Voucher không tồn tại.";
    }
} else {
    $error = "Không tìm thấy ID của voucher.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $discount_value = $_POST['discount_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (!empty($name) && !empty($code) && !empty($discount_value) && !empty($start_date) && !empty($end_date)) {
        $stmt = $pdo->prepare("UPDATE vouchers SET name = ?, code = ?, discount_value = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->execute([$name, $code, $discount_value, $start_date, $end_date, $voucherId]);

        $success = "Cập nhật voucher thành công!";
        header("Location: voucher-list.php");
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
                                <h4> Cập nhật voucher</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Cập nhật voucher
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Cập nhật voucher mới</h4>
                    </div>
                    <div class="pb-20">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="name" class="col-sm-12 col-md-2 col-form-label">Tên Voucher</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($voucher['name']) ?>" placeholder="Nhập tên voucher" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="code" class="col-sm-12 col-md-2 col-form-label">Mã Voucher</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text" class="form-control" id="code" name="code" value="<?= htmlspecialchars($voucher['code']) ?>" placeholder="Nhập mã voucher" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discount_value" class="col-sm-12 col-md-2 col-form-label">Giảm Giá</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="number" class="form-control" id="discount_value" name="discount_value" value="<?= htmlspecialchars($voucher['discount_value']) ?>" placeholder="Nhập giá trị giảm" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="start_date" class="col-sm-12 col-md-2 col-form-label">Ngày Bắt Đầu</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="<?= date('Y-m-d\TH:i', strtotime($voucher['start_date'])) ?>" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="end_date" class="col-sm-12 col-md-2 col-form-label">Ngày Kết Thúc</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="<?= date('Y-m-d\TH:i', strtotime($voucher['end_date'])) ?>" required />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="voucher-list.php" class="btn btn-secondary">Quay lại</a>
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