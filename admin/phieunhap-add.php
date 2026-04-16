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
    $supplier_id = $_POST['supplier_id'];
    $total = $_POST['total'];
    $import_prices = $_POST['import_price'];

    if (!empty($supplier_id) && !empty($total)) {

        $stmt = $pdo->prepare("INSERT INTO imports (supplier_id, total, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$supplier_id, $total]);

        $import_id = $pdo->lastInsertId();

        if (isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['import_price'])) {

            $product_ids = $_POST['product_id'];
            $quantities = $_POST['quantity'];
            $import_prices = $_POST['import_price'];

            foreach ($product_ids as $key => $product_id) {

                $quantity = $quantities[$key];
                $import_price = $import_prices[$key];

                $product_stmt = $pdo->prepare("SELECT quantity FROM products WHERE id = ?");
                $product_stmt->execute([$product_id]);
                $product = $product_stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {

                    $total_price = $import_price * $quantity;

                    $stmt_details = $pdo->prepare("
                        INSERT INTO import_details (import_id, product_id, quantity, import_price, total_price)
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt_details->execute([$import_id, $product_id, $quantity, $import_price, $total_price]);

                    $new_quantity = $product['quantity'] + $quantity;

                    $update_product_stmt = $pdo->prepare("
                        UPDATE products SET quantity = ?, import_price = ? WHERE id = ?
                    ");
                    $update_product_stmt->execute([$new_quantity, $import_price, $product_id]);
                }
            }
        }

        $success = "Thêm phiếu nhập thành công!";
        header("Location: phieunhap-list.php");
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
                                <h4> Tạo phiếu nhập</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Tạo phiếu nhập
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 card-box mb-30">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Tạo phiếu nhập mới</h4>
                    </div>
                    <div class="pb-20">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="supplier_id" class="col-sm-12 col-md-2 col-form-label">Chọn Nhà Cung Cấp</label>
                                <div class="col-sm-12 col-md-10">
                                    <select class="form-control" name="supplier_id" id="supplier_id" required>
                                        <option value="">Chọn nhà cung cấp</option>
                                        <?php
                                        $stmt = $pdo->query("SELECT * FROM suppliers");
                                        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($suppliers as $supplier): ?>
                                            <option value="<?= $supplier['id'] ?>"><?= $supplier['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div id="product_rows">
                                <div class="form-group row align-items-end">

                                    <div class="col-md-3">
                                        <label>Chọn Sản Phẩm</label>
                                        <select class="form-control" name="product_id[]" required>
                                            <option value="">Chọn sản phẩm</option>
                                            <?php
                                            $stmt = $pdo->query("SELECT * FROM products");
                                            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($products as $product): ?>
                                                <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Số Lượng</label>
                                        <input type="number" class="form-control" name="quantity[]" min="1" value="1" required />
                                    </div>

                                    <div class="col-md-2">
                                        <label>Giá Nhập</label>
                                        <input type="number" class="form-control" name="import_price[]" min="0" value="0" required />
                                    </div>

                                    <div class="col-md-3">
                                        <label>Tổng Tiền</label>
                                        <input type="text" class="form-control" name="total_price[]" readonly />
                                    </div>

                                </div>
                            </div>


                            <button type="button" id="add_product" class="btn btn-info">Thêm Sản Phẩm</button>

                            <div class="form-group row d-flex justify-content-end">
                                <label for="total" class="col-sm-12 col-md-2 col-form-label text-right">Tổng Tiền</label>
                                <div class="col-sm-12 col-md-2">
                                    <input type="text" class="form-control" id="total" name="total" readonly />
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Lưu Phiếu Nhập</button>
                            <a href="phieunhap-list.php" class="btn btn-secondary">Quay lại</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productRows = document.getElementById('product_rows');
            let total = document.getElementById('total');

            document.getElementById('add_product').addEventListener('click', function() {
                let newRow = productRows.querySelector('.form-group').cloneNode(true);

                newRow.querySelector('select[name="product_id[]"]').value = "";
                newRow.querySelector('input[name="quantity[]"]').value = 1;
                newRow.querySelector('input[name="total_price[]"]').value = "";

                productRows.appendChild(newRow);

                updateProductOptions();
                calculateTotal();
            });

            productRows.addEventListener('change', function() {
                updateProductOptions();
                calculateTotal();
            });


            function updateProductOptions() {
                let selectedProducts = [...document.querySelectorAll('select[name="product_id[]"]')]
                    .map(select => select.value)
                    .filter(v => v !== "");

                document.querySelectorAll('select[name="product_id[]"]').forEach(select => {

                    let currentValue = select.value;

                    [...select.options].forEach(option => {
                        if (option.value === "") return;

                        if (selectedProducts.includes(option.value) && option.value !== currentValue) {
                            option.style.display = "none";
                        } else {
                            option.style.display = "block";
                        }
                    });
                });
            }

            function calculateTotal() {
                let totalAmount = 0;
                let rows = productRows.querySelectorAll('.form-group');

                rows.forEach(function(row) {
                    let qty = row.querySelector('input[name="quantity[]"]').value;
                    let importPrice = row.querySelector('input[name="import_price[]"]').value;

                    if (qty && importPrice) {
                        let totalPrice = importPrice * qty;
                        row.querySelector('input[name="total_price[]"]').value = totalPrice.toFixed(2);
                        totalAmount += totalPrice;
                    }
                });

                total.value = totalAmount.toFixed(2);
            }


            updateProductOptions();
        });
    </script>
</body>

</html>