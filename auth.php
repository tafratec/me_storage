<?php
require_once 'config.php';

function authenticate() {
    //$headers = getallheaders();
    //print_r($headers['Authorization']);
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? ($_SERVER['HTTP_AUTHORIZATION'] ?? null);    
    if (!$authHeader || $authHeader !== 'Bearer ' . API_KEY) {
        http_response_code(401);
        die(json_encode(["error" => "Unauthorized"]));
    }
    
}
?>
