<?php
header('Content-Type: application/json');
require_once 'auth.php';
require_once 'db.php';

// Authenticate request
authenticate();

// Get the parameter from the request
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "Missing 'WO' parameter"]);
    exit;
}

// Fetch something from the database
try {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT * FROM tfv_api_case where workorderID=:id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Record not found"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal server error"]);
}
?>
