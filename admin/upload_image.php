<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Thêm cờ 'uploaded' => 0 để báo lỗi chuẩn CKFinder
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Bạn chưa đăng nhập!']]);
    exit;
}

if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/hoasang/img/blogs/';
    $fileTmpPath = $_FILES['upload']['tmp_name'];
    $fileName = $_FILES['upload']['name'];
    $fileType = $_FILES['upload']['type'];

    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (in_array($fileType, $allowedFileTypes)) {
        $newFileName = time() . '_' . basename($fileName);
        $uploadPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            // ĐÂY LÀ ĐIỂM MẤU CHỐT: Phải có 'uploaded' => 1
            echo json_encode([
                'uploaded' => 1,
                'fileName' => $newFileName,
                'url' => '/hoasang/img/blogs/' . $newFileName
            ]);
            exit;
        } else {
            echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Lưu file thất bại. Kiểm tra quyền ghi của thư mục.']]);
            exit;
        }
    } else {
        echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Chỉ hỗ trợ định dạng JPG, PNG, GIF, WEBP.']]);
        exit;
    }
} else {
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Không có file nào được tải lên.']]);
    exit;
}
?>