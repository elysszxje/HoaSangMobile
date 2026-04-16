<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['id'])) {
	die("Thiếu mã đơn hàng!");
}

$orderId = intval($_GET['id']);

$stmt = $pdo->prepare("
    SELECT o.*, u.HoTen, u.Email, u.DiaChi, u.DienThoai
    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.id = ?
");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
	die("Không tìm thấy đơn hàng.");
}

$stmtItems = $pdo->prepare("
    SELECT oi.*, p.name, p.img
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmtItems->execute([$orderId]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
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
                        <h4 class="text-blue h4">Chi tiết đơn hàng</h4>
                    </div>
                    <div class="pb-20">

                        <section class="container my-5">
                            <div class="invoice-box mt-5">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <div class="title">HÓA ĐƠN MUA HÀNG</div>
                                        <div class="header-info">Mã đơn hàng: <strong>#<?= $orderId ?></strong></div>
                                        <div class="header-info">Ngày đặt: <?= date("d/m/Y H:i", strtotime($order['created_at'])) ?></div>
                                    </div>

                                    <div class="text-end">
                                        <h5><strong>HoaSang Store</strong></h5>
                                        <div>Email: support@hoasang.vn</div>
                                        <div>Hotline: 0937940243</div>
                                    </div>
                                </div>

                                <h5 class="mt-4">Thông tin khách hàng</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Họ tên</th>
                                        <td><?= htmlspecialchars($order['HoTen']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= htmlspecialchars($order['Email']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ</th>
                                        <td><?= htmlspecialchars($order['DiaChi'] ?? "Không có") ?></td>
                                    </tr>
                                    <tr>
                                        <th>Số điện thoại</th>
                                        <td><?= htmlspecialchars($order['DienThoai'] ?? "Không có") ?></td>
                                    </tr>
                                </table>

                                <h5 class="mt-4">Chi tiết đơn hàng</h5>
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>Hình</th>
                                            <th>Sản phẩm</th>
                                            <th>Giá</th>
                                            <th>SL</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><img src="../<?= $item['img'] ?>" width="60"></td>
                                                <td><?= $item['name'] ?></td>
                                                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td><strong><?= number_format($item['total_price'], 0, ',', '.') ?>₫</strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <div class="text-end mt-4">
                                    <h4>Tổng cộng:
                                        <strong class="text-success">
                                            <?= number_format($order['total'], 0, ',', '.') ?>₫
                                        </strong>
                                    </h4>

                                    <p>Phương thức thanh toán:
                                        <strong><?= strtoupper($order['payment_method']) ?></strong>
                                    </p>
                                </div>

                                <hr>

                                <div class="text-center mt-3">
                                    <a href="donhang-list.php" class="btn btn-primary mt-2">Quay lại</a>
                                </div>

                            </div>
                        </section>
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