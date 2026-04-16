<?php
$host = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'hoasang';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_message = 'Không thể kết nối đến CSDL';
    $reason = $e->getMessage();
    exit();
}