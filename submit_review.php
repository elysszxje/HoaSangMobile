<?php
require 'connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'];
$rating = (int)$_POST['rating'];
$comment = trim($_POST['comment']);

$stmt = $pdo->prepare("
    SELECT 1
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    WHERE o.user_id = :user_id AND oi.product_id = :product_id
    LIMIT 1
");
$stmt->execute([':user_id' => $userId, ':product_id' => $productId]);

if (!$stmt->fetchColumn()) {
    echo "Bạn phải mua sản phẩm này mới có thể đánh giá.";
    exit;
}
$stmt = $pdo->prepare("
    INSERT INTO reviews (product_id, user_id, comment, rating)
    VALUES (:product_id, :user_id, :comment, :rating)
");
$stmt->execute([
    ':product_id' => $productId,
    ':user_id' => $userId,
    ':comment' => $comment,
    ':rating' => $rating
]);

$update = $pdo->prepare("
    UPDATE products
    SET rateCount = rateCount + 1
    WHERE id = :product_id
");
$update->execute([':product_id' => $productId]);

header("Location: detail.php?id=$productId&review=success");
exit;
