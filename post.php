<?php
require_once 'QRGenerator.php';
require_once 'PDFGenerator.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
function validateBearerToken($token): bool
{
    $validToken = 'token123'; // API token

    return $token === $validToken;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $headers = apache_request_headers();

    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(array("message" => "Authorization header is missing"));
        exit;
    }

    $authorizationHeader = $headers['Authorization'];

    if (!preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
        http_response_code(401);
        echo json_encode(array("message" => "Invalid Authorization header format"));
        exit;
    }

    $token = $matches[1];

    if (!validateBearerToken($token)) {
        http_response_code(401);
        echo json_encode(array("message" => "Invalid bearer token"));
        exit;
    }

    // success auth, get fields and generate pdf
    $postData = json_decode(file_get_contents('php://input'), true);
    $qrFilename = 'qr_code.jpg';
    $qrPath = QRGenerator::generateQRCode('https://hrpanorama.pl/', $qrFilename);

    $pdfContent = $postData['value'];
    $pdfFilename = 'qrpdf-' . time() . '.pdf';
    $pdfPath = PDFGenerator::generatePDF($qrPath, $pdfContent, $pdfFilename);
    $pdfUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/public/'. $pdfFilename;

    echo json_encode(array("message" => "success", "pdfUrl" => $pdfUrl));

} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}
