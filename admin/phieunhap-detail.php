<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$importId = $_GET['id'];

$stmt = $pdo->prepare("SELECT i.id, i.created_at, i.supplier_id, i.total, s.name AS supplier_name
                       FROM imports i
                       JOIN suppliers s ON i.supplier_id = s.id
                       WHERE i.id = ?");
$stmt->execute([$importId]);
$import = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT p.name AS product_name, idt.quantity, idt.total_price, idt.import_price
                       FROM import_details idt
                       JOIN products p ON idt.product_id = p.id
                       WHERE idt.import_id = ?");
$stmt->execute([$importId]);
$importDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="../vendors/styles/style.css" />
    <style>
        /* Định dạng chung */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            border-radius: 8px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .invoice-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .invoice-table td {
            color: #555;
        }

        .invoice-footer {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }

        .actions .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .actions .btn:hover {
            background-color: #0056b3;
        }

        .actions .btn i {
            margin-right: 5px;
        }
    </style>
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
                                <h4> Chi tiết phiếu nhập</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Chi tiết phiếu nhập
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Chi tiết phiếu nhập</h4>
                    </div>
                    <div class="pb-20">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <h2>Chi Tiết Phiếu Nhập</h2>
                                <div class="invoice-info">
                                    <p><strong>Mã Phiếu:</strong> <?= $import['id'] ?></p>
                                    <p><strong>Ngày Nhập:</strong> <?= date('d/m/Y', strtotime($import['created_at'])) ?></p>
                                    <p><strong>Nhà Cung Cấp:</strong> <?= htmlspecialchars($import['supplier_name']) ?></p>
                                </div>
                            </div>

                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th>Mã</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th>Giá Nhập</th>
                                        <th>Số Lượng</th>
                                        <th>Tổng Tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($importDetails as $index => $detail): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($detail['product_name']) ?></td>
                                            <td><?= number_format($detail['import_price'], 0, ',', '.') ?> VND</td>
                                            <td><?= $detail['quantity'] ?></td>
                                            <td><?= number_format($detail['total_price'], 0, ',', '.') ?> VND</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="invoice-footer">
                                <p><strong>Tổng Tiền:</strong> <?= number_format($import['total'], 0, ',', '.') ?> VND</p>
                            </div>

                            <div class="actions">
                                <a href="phieunhap-list.php" class="btn btn-back"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
                            </div>
                        </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productRows = document.getElementById('product_rows');
            let total = document.getElementById('total');

            document.getElementById('add_product').addEventListener('click', function() {
                let newRow = productRows.querySelector('.form-group').cloneNode(true);
                productRows.appendChild(newRow);
                calculateTotal();
            });

            productRows.addEventListener('change', function() {
                calculateTotal();
            });

            function calculateTotal() {
                let totalAmount = 0;
                let rows = productRows.querySelectorAll('.form-group');
                rows.forEach(function(row) {
                    let quantity = row.querySelector('input[name="quantity[]"]').value;
                    let productId = row.querySelector('select[name="product_id[]"]').value;

                    if (productId && quantity) {
                        fetch(`get_product_price.php?id=${productId}`)
                            .then(response => response.json())
                            .then(data => {
                                let price = parseFloat(data.price);
                                let totalPrice = price * quantity;
                                row.querySelector('input[name="total_price[]"]').value = totalPrice.toFixed(2);
                                totalAmount += totalPrice;
                                total.value = totalAmount.toFixed(2);
                            });
                    }
                });
            }
        });
    </script>
</body>

</html>