<?php
session_start();
require 'connect.php';

$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}

$vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$hashData = "";
$i = 0;
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

$secretKey = "HFWWS0H1PTNNWO8C114AIRI5CR1RA9DP";
$secureHash = hash_hmac('sha512', $hashData, $secretKey);

// Kiểm tra tính hợp lệ của dữ liệu trước khi hiển thị
if ($secureHash == $vnp_SecureHash) {
    $vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';
    $orderId = $_GET['vnp_TxnRef'] ?? '';

    if ($vnp_ResponseCode == '00') {
        // Thanh toán thành công: Chỉ cần xóa giỏ hàng trong session và chuyển hướng
        unset($_SESSION['cart']);
        header("Location: thanhcong.php?order_id=" . $orderId);
        exit();
    } else {
        echo "<h2>Thanh toán không thành công hoặc đã bị hủy!</h2>";
        echo "<p>Mã lỗi VNPAY: " . htmlspecialchars($vnp_ResponseCode) . "</p>";
        echo "<a href='giohang.php'>Quay lại giỏ hàng</a>";
    }
} else {
    echo "<h2>Lỗi bảo mật: Chữ ký không hợp lệ!</h2>";
}
?>
