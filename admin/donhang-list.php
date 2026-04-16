<?php
require 'connect.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if (isset($_GET['change_status']) && isset($_GET['id'])) {
    $orderId = intval($_GET['id']);
    $newStatus = $_GET['change_status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$newStatus, $orderId]);

    header("Location: donhang-list.php");
    exit;
}


$stmt = $pdo->query("
    SELECT o.*, u.HoTen, u.Email, u.DienThoai, u.DiaChi
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.id DESC
");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Quản Lý Đơn Hàng</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../vendors/images/favicon-32x32.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
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

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">

            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Quản Lý Đơn Hàng</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Danh sách đơn hàng</h4>
                    </div>
                    <div class="pb-20">

                        <table class="data-table table hover stripe">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Khách hàng</th>
                                    <th>Email</th>
                                    <th>Tổng tiền</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th class="datatable-nosort">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>DH<?= $order['id'] ?></td>

                                        <td><?= htmlspecialchars($order['HoTen']) ?></td>

                                        <td><?= htmlspecialchars($order['Email']) ?></td>

                                        <td><strong><?= number_format($order['total'], 0, ',', '.') ?>₫</strong></td>

                                        <td><?= strtoupper($order['payment_method']) ?></td>

                                        <td>
                                            <?php
                                            $colors = [
                                                'pending' => 'warning',
                                                'processing' => 'primary',
                                                'completed' => 'success',
                                                'canceled' => 'danger'
                                            ];
                                            ?>
                                            <span class="badge badge-<?= $colors[$order['status']] ?? 'secondary' ?>">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </td>

                                        <td><?= $order['created_at'] ?></td>

                                        <td>
                                            <a href="donhang-detail.php?id=<?= $order['id'] ?>" class="btn btn-info btn-sm mb-1">
                                                Xem
                                            </a>

                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-toggle="dropdown">
                                                    Đổi trạng thái
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="?change_status=pending&id=<?= $order['id'] ?>">Chờ xử lý</a>
                                                    <a class="dropdown-item" href="?change_status=processing&id=<?= $order['id'] ?>">Đang xử lý</a>
                                                    <a class="dropdown-item" href="?change_status=completed&id=<?= $order['id'] ?>">Hoàn thành</a>
                                                    <a class="dropdown-item" href="?change_status=canceled&id=<?= $order['id'] ?>">Hủy</a>
                                                </div>
                                            </div>
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

    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                responsive: true,
                autoWidth: false,
            });
        });
    </script>

</body>

</html>