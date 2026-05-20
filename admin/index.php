<?php
require 'connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt_products = $pdo->query("SELECT COUNT(*) AS product_count FROM products");
$product_count = $stmt_products->fetch(PDO::FETCH_ASSOC)['product_count'];

$stmt_users = $pdo->query("SELECT COUNT(*) AS user_count FROM users");
$user_count = $stmt_users->fetch(PDO::FETCH_ASSOC)['user_count'];

$stmt_orders = $pdo->query("SELECT COUNT(*) AS order_count FROM orders");
$order_count = $stmt_orders->fetch(PDO::FETCH_ASSOC)['order_count'];

// 1. TÍNH TỔNG DOANH THU
$stmt_revenue = $pdo->query("
    SELECT SUM(total) AS total_revenue 
    FROM orders 
    WHERE status = 'completed'
");
$total_revenue = $stmt_revenue->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

// 2. TÍNH TỔNG LỢI NHUẬN (Theo logic hạch toán của hệ thống)
$stmt_profit = $pdo->query("
    SELECT 
        SUM(p.import_price * oi.quantity) AS total_profit
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    JOIN orders o ON oi.order_id = o.id
    WHERE o.status = 'completed'
");
$total_profit = $stmt_profit->fetch(PDO::FETCH_ASSOC)['total_profit'] ?? 0;

// 3. TÍNH TỔNG CHI PHÍ NHẬP
$total_cost = $total_revenue - $total_profit;


// 4. BIỂU ĐỒ DOANH THU THEO THÁNG
$stmt_chart = $pdo->query("
    SELECT 
        MONTH(created_at) AS month,
        SUM(total) AS revenue
    FROM orders
    WHERE status = 'completed'
    GROUP BY MONTH(created_at)
    ORDER BY month ASC
");

$chartData = array_fill(1, 12, 0);
while ($row = $stmt_chart->fetch(PDO::FETCH_ASSOC)) {
    $chartData[intval($row['month'])] = intval($row['revenue']);
}

// 5. BIỂU ĐỒ LỢI NHUẬN THEO THÁNG
$stmt_profit_chart = $pdo->query("
    SELECT 
        MONTH(o.created_at) AS month,
        SUM(p.import_price * oi.quantity) AS profit
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    JOIN orders o ON oi.order_id = o.id
    WHERE o.status = 'completed'
    GROUP BY MONTH(o.created_at)
    ORDER BY month ASC
");

$profitData = array_fill(1, 12, 0);
while ($row = $stmt_profit_chart->fetch(PDO::FETCH_ASSOC)) {
    $profitData[intval($row['month'])] = intval($row['profit']);
}

// 6. BIỂU ĐỒ CHI PHÍ NHẬP THEO THÁNG
$costData = array_fill(1, 12, 0);
for ($i = 1; $i <= 12; $i++) {
    $costData[$i] = $chartData[$i] - $profitData[$i];
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
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="title pb-20">
                <h2 class="h3 mb-0">Trang Quản Trị</h2>
            </div>

            <div class="row pb-10">
                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark"><?= $product_count ?></div>
                                <div class="font-14 text-secondary weight-500">
                                    Sản phẩm
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#00eccf">
                                    <i class="icon-copy dw dw-calendar1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark"><?= $order_count ?></div>
                                <div class="font-14 text-secondary weight-500">
                                    Đơn hàng
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon">
                                    <i class="icon-copy fa fa-stethoscope" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">
                                    <?= number_format($total_revenue, 0, ',', '.') ?> VND
                                </div>
                                <div class="font-14 text-secondary weight-500">Doanh thu</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#007bff">
                                    <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">
                                    <?= number_format($total_cost, 0, ',', '.') ?> VND
                                </div>
                                <div class="font-14 text-secondary weight-500">Chi phí nhập</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#dc3545">
                                    <i class="icon-copy fa fa-cart-arrow-down" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">
                                    <?= number_format($total_profit, 0, ',', '.') ?> VND
                                </div>
                                <div class="font-14 text-secondary weight-500">Lợi nhuận gộp</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#28a745">
                                    <i class="icon-copy fa fa-line-chart" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-box mb-30 mt-4">
                <div class="pd-20">
                    <h4 class="text-blue h4">Biểu đồ doanh thu theo tháng</h4>
                </div>
                <div class="pb-20">
                    <canvas id="revenueChart" style="width: 100%; height: 350px;"></canvas>
                </div>
            </div>

            <div class="card-box mb-30 mt-4">
                <div class="pd-20">
                    <h4 class="text-blue h4" style="color: #dc3545 !important;">Biểu đồ chi phí nhập theo tháng</h4>
                </div>
                <div class="pb-20">
                    <canvas id="costChart" style="width: 100%; height: 350px;"></canvas>
                </div>
            </div>

            <div class="card-box mb-30 mt-4">
                <div class="pd-20">
                    <h4 class="text-blue h4" style="color: #28a745 !important;">Biểu đồ lợi nhuận gộp theo tháng</h4>
                </div>
                <div class="pb-20">
                    <canvas id="profitChart" style="width: 100%; height: 350px;"></canvas>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById("revenueChart").getContext("2d");
        const revenueData = <?= json_encode(array_values($chartData)) ?>;
        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
                datasets: [{
                    label: "Doanh thu (VND)",
                    data: revenueData,
                    borderColor: "#007bff",
                    backgroundColor: "rgba(0,123,255,0.2)",
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return value.toLocaleString('vi-VN') + "₫"; }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const ctx2 = document.getElementById("costChart").getContext("2d");
        const costData = <?= json_encode(array_values($costData)) ?>;
        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
                datasets: [{
                    label: "Chi phí nhập (VND)",
                    data: costData,
                    borderColor: "#dc3545",
                    backgroundColor: "rgba(220,53,69,0.2)",
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return value.toLocaleString('vi-VN') + "₫"; }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const ctx3 = document.getElementById("profitChart").getContext("2d");
        const profitData = <?= json_encode(array_values($profitData)) ?>;
        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
                datasets: [{
                    label: "Lợi nhuận gộp (VND)",
                    data: profitData,
                    borderColor: "#28a745",
                    backgroundColor: "rgba(40,167,69,0.2)",
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return value.toLocaleString('vi-VN') + "₫"; }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>