<?php
require 'connect.php';

$inputData = array();
$returnData = array();

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

try {
    // Kiểm tra chữ ký bảo mật
    if ($secureHash == $vnp_SecureHash) {
        $orderId = $inputData['vnp_TxnRef'];
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // VNPAY nhân 100 nên phải chia lại

        // Truy vấn lấy đơn hàng từ Database
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            // Kiểm tra số tiền có khớp không
            if ($order['total'] == $vnp_Amount) {
                // Kiểm tra trạng thái đơn hàng (chỉ xử lý đơn pending)
                if ($order['status'] == 'pending') {
                    
                    if ($inputData['vnp_ResponseCode'] == '00') {
                        // THANH TOÁN THÀNH CÔNG: Cập nhật trạng thái completed
                        $updateStatus = $pdo->prepare("UPDATE orders SET status = 'completed', updated_at = NOW() WHERE id = ?");
                        $updateStatus->execute([$orderId]);

                        // Trừ số lượng voucher nếu đơn hàng có áp dụng
                        if (!empty($order['voucher_id'])) {
                            $updateVoucher = $pdo->prepare("UPDATE vouchers SET quantity = quantity - 1 WHERE id = ? AND quantity > 0");
                            $updateVoucher->execute([$order['voucher_id']]);
                        }

                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                    } else {
                        // THANH TOÁN THẤT BẠI HOẶC BỊ HỦY: Cập nhật trạng thái failed/cancelled
                        $updateStatus = $pdo->prepare("UPDATE orders SET status = 'failed', updated_at = NOW() WHERE id = ?");
                        $updateStatus->execute([$orderId]);

                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                    }
                } else {
                    $returnData['RspCode'] = '02';
                    $returnData['Message'] = 'Order already confirmed';
                }
            } else {
                $returnData['RspCode'] = '04';
                $returnData['Message'] = 'invalid amount';
            }
        } else {
            $returnData['RspCode'] = '01';
            $returnData['Message'] = 'Order not found';
        }
    } else {
        $returnData['RspCode'] = '97';
        $returnData['Message'] = 'Invalid signature';
    }
} catch (Exception $e) {
    $returnData['RspCode'] = '99';
    $returnData['Message'] = 'Unknow error';
}

// Trả về định dạng JSON cho VNPAY hiểu
header('Content-Type: application/json');
echo json_encode($returnData);
?>