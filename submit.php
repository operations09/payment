<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Use POST request only"]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['name']) || !isset($input['transaction_hash']) || !isset($input['method'])) {
    echo json_encode(["error" => "Missing: name, transaction_hash, method"]);
    exit;
}

$name = htmlspecialchars(trim($input['name']));
$txHash = htmlspecialchars(trim($input['transaction_hash']));
$method = htmlspecialchars(strtoupper(trim($input['method'])));

$adminEmail = "operations@rangeforex.com"; // CHANGE THIS
$subject = "New Payment - $method";
$message = "Name: $name\nTX: $txHash\nMethod: $method\nTime: " . date('Y-m-d H:i:s');

$headers = "From: noreply@rangeforex.com\r\nContent-Type: text/plain\r\n";

if (mail($adminEmail, $subject, $message, $headers)) {
    echo json_encode(["status" => "success", "message" => "Email sent!"]);
} else {
    echo json_encode(["status" => "success", "message" => "Recorded (email failed)"]);
}
?>
