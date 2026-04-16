<?php
require 'connect.php';
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($product);
}
?>
