<?php
require_once 'env.php';
header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$inputArray = json_decode($inputJSON, true);
$userMessage = $inputArray['message'] ?? '';

// 1. Kiểm tra xem có nhận được tin nhắn không
if (empty($userMessage)) {
    echo json_encode(['reply' => 'Lỗi: Không nhận được tin nhắn từ giao diện.']);
    exit;
}

// 2. Kiểm tra xem Key có bị trống hay lỗi file env.php không
if (!defined('GEMINI_API_KEY') || empty(trim(GEMINI_API_KEY))) {
    echo json_encode(['reply' => 'Lỗi: Chưa có API Key hoặc file env.php cấu hình sai.']);
    exit;
}

// ĐÃ SỬA LỖI: Chuyển model gemini mới
$model = 'gemini-3.1-flash-lite';
$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . trim(GEMINI_API_KEY);

$payload = [
    "contents" => [
        ["parts" => [["text" => "Bạn là nhân viên tư vấn của HoaSang Store. Khách hỏi: " . $userMessage]]]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

// 3. Kiểm tra lỗi mất mạng / firewall của XAMPP
if ($error) {
    echo json_encode(['reply' => 'Lỗi mạng cURL: ' . $error]);
    exit;
}

$responseData = json_decode($response, true);

// 4. Bóc tách chính xác câu trả lời
if (isset($responseData['error'])) {
    echo json_encode(['reply' => "Lỗi API Google: " . $responseData['error']['message']]);
} elseif (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    echo json_encode(['reply' => $responseData['candidates'][0]['content']['parts'][0]['text']]);
} else {
    echo json_encode(['reply' => "Lỗi cấu trúc dữ liệu trả về: " . $response]);
}
?>