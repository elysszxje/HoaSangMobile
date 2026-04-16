<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$stmt = $pdo->query("SELECT i.id, i.created_at, i.total, s.name AS supplier_name
                     FROM imports i
                     JOIN suppliers s ON i.supplier_id = s.id
                     ORDER BY i.created_at DESC");
$imports = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $delete_details_stmt = $pdo->prepare("DELETE FROM import_details WHERE import_id = ?");
    $delete_details_stmt->execute([$id]);

    $delete_stmt = $pdo->prepare("DELETE FROM imports WHERE id = ?");
    $delete_stmt->execute([$id]);

    header("Location: phieunhap-list.php");
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
                                    <th>Nhà Cung Cấp</th>
                                    <th>Ngày Tạo</th>
                                    <th>Tổng Tiền</th>
                                    <th class="datatable-nosort">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($imports as $import): ?>
                                    <tr>
                                        <td>PN<?= $import['id'] ?></td>
                                        <td><?= htmlspecialchars($import['supplier_name']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($import['created_at'])) ?></td>
                                        <td><?= number_format($import['total'], 2) ?> VND</td>
                                        <td>
                                            <a href="phieunhap-detail.php?id=<?= $import['id'] ?>" class="btn btn-info">Chi tiết</a>
                                            <a href="phieunhap-list.php?delete_id=<?= $import['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa phiếu nhập này?')">Xóa</a>
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