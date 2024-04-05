<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// that should be in database with ORM or DTO and with pass hash in bcrypt

$username = 'user123';
$password = 'password123';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $inputData = json_decode(file_get_contents('php://input'), true);
    $inputUsername = $inputData['username'] ?? '';
    $inputPassword = $inputData['password'] ?? '';

    if ($inputUsername === $username && $inputPassword === $password) {
        http_response_code(200);
        echo json_encode(array("message" => "Authentication successful"));
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Invalid username or password"));
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}

