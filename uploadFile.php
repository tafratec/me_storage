<?php
header('Content-Type: application/json');
require_once 'auth.php';
// Authenticate request
authenticate();

switch ($_POST['calling_method']) {
    case 'payment_doc':
        echo uploadPayemntPic();
        break;
    case 'uploadExportDoc':
        echo uploadExportDoc();
        break;
    case 'file_remove':
        echo deleteFile();
        break;
    case 'bring_file':
        return downloadFile();
        break;
    default:
        http_response_code(400);
}

function uploadPayemntPic()
{
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        return json_encode(["error" => "File upload error"]);
    }

    $file = $_FILES['file'];

    // المسار المطلق لمجلد الموقع
    $rootPath = __DIR__;
    $uploadDir = $rootPath . '/payments/' . $_POST['cust_id'];

    // إنشاء المجلد payments/{cust_id} لو مش موجود
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            http_response_code(500);
            return json_encode(["error" => "Failed to create folder: $uploadDir"]);
        }
    }

    $uploadFile = $uploadDir . '/' . basename($file['name']);

    if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
        http_response_code(500);
        return json_encode(["error" => "Failed to move uploaded file"]);
    }

    // URL كامل للملف
    return 5;
}

function uploadExportDoc()
{
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        return json_encode(["error" => "File upload error"]);
    }

    $file = $_FILES['file'];
    $uploadDir = 'exportOrders/';
    $uploadFile = $uploadDir . basename($file['name']);

    if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
        http_response_code(500);
        return json_encode(["error" => "Failed to move uploaded file"]);
    }

    return json_encode(["message" => "File uploaded successfully", "file_path" => $uploadFile]);
}

function deleteFile()
{
    $filePath = $_POST['file_path'] ?? null;

    if (!$filePath || !file_exists($filePath)) {
        http_response_code(400);
        return json_encode(["error" => "File not found"]);
    }

    if (!unlink($filePath)) {
        http_response_code(500);
        return json_encode(["error" => "Failed to delete file"]);
    }

    return json_encode(["message" => "File deleted successfully"]);
}

function downloadFile()
{
    $filePath = $_POST['filePath'] ?? null;

    if (!$filePath || !file_exists($filePath)) {
        http_response_code(404);
        echo json_encode(["error" => "File not found"]);
        exit;
    }

    // ✅ رجّع JSON مباشرة
    header('Content-Type: application/json');
    echo file_get_contents($filePath);
    exit;
}
