<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$stmt = $pdo->query("SELECT p.id, p.name, p.created_at,  p.import_price, p.updated_at, p.img, p.price, b.name AS brand_name, p.quantity, p.status  
                     FROM products p 
                     JOIN brands b ON p.company_id = b.id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['change_status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $new_status = $_GET['change_status'] == 1 ? 0 : 1;

    $update_stmt = $pdo->prepare("UPDATE products SET status = ? WHERE id = ?");
    $update_stmt->execute([$new_status, $id]);

    header("Location: sanpham-list.php");
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admin</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../vendors/images/favicon-16x16.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
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
                                <h4> Danh sách</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Danh sách
                                    </li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                </div>
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Danh sách</h4>
                    </div>
                    <div class="pb-20">
                        <table class="data-table table stripe hover nowrap">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Hình Ảnh</th>
                                    <th>Giá nhập</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Thương Hiệu</th>
                                    <th class="datatable-nosort">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>SP<?= $product['id'] ?></td>
                                        <td><?= htmlspecialchars($product['name']) ?></td>
                                        <td><img src="../<?= htmlspecialchars($product['img']) ?>" width="50" height="50" /></td>
                                        <td><?= number_format($product['import_price'], 2) ?> VND</td>
                                        <td><?= number_format($product['price'], 2) ?> VND</td>
                                        <td><?= htmlspecialchars($product['quantity']) ?></td>
                                        <td>
                                            <a href="sanpham-list.php?change_status=<?= $product['status'] ?>&id=<?= $product['id'] ?>"
                                                class="btn <?= $product['status'] == 1 ? 'btn-success' : 'btn-danger' ?>">
                                                <?= $product['status'] == 1 ? 'Khoá' : 'Mở khoá' ?>
                                            </a>
                                        </td>

                                        <td><?= htmlspecialchars($product['brand_name']) ?></td>
                                        <td><?= htmlspecialchars($product['created_at']) ?></td>
                                        <td><?= htmlspecialchars($product['updated_at']) ?></td>
                                        <td>
                                            <a href="sanpham-edit.php?id=<?= $product['id'] ?>" class="btn btn-warning">Cập nhật</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
    <script src="../src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="../src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="../src/plugins/datatables/js/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('.data-table')) {
                $('.data-table').DataTable().destroy();
            }

            $('.data-table').DataTable({
                responsive: true,
                autoWidth: false,
            });
        });
    </script>

</body>

</html>