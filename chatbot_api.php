<?php
require_once 'env.php';
header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$inputArray = json_decode($inputJSON, true);
$userMessage = $inputArray['message'] ?? '';

if (empty($userMessage)) {
    echo json_encode(['reply' => 'Tôi chưa nhận được tin nhắn từ bạn.']);
    exit;
}

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . GEMINI_API_KEY;

$payload = [
    "contents" => [
        ["parts" => [["text" => "Bạn là trợ lý ảo của HoaSang Store. Hãy trả lời ngắn gọn, lịch sự về điện thoại và công nghệ. Khách hỏi: " . $userMessage]]]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
// Bổ sung dòng dưới đây để tắt kiểm tra SSL trên localhost
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
$botReply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? "Xin lỗi, tôi đang bận một chút, bạn hỏi lại sau nhé!";

echo json_encode(['reply' => $botReply]);
?>