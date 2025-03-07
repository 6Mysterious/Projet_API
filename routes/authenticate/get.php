<?php

require_once __DIR__ . "/../../libraries/response.php";

function generateToken($userId, $username)
{
    $header = json_encode(["alg" => "HS256", "typ" => "JWT"]);

    $payload = json_encode([
        "user" => [
            "id" => $userId,
            "username" => $username
        ],
        "exp" => time() + 3600 
    ]);

    $secret = bin2hex(random_bytes(32)); 

    $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac("sha256", $base64Header . "." . $base64Payload, $secret, true);
    $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    return $base64Header . "." . $base64Payload . "." . $base64Signature;
}

try {
    $userId = random_int(1, 1000); 
    $username = "user" . $userId;

    echo jsonResponse(200, ["X-School" => "ESGI"], [
        "success" => true,
        "token" => generateToken($userId, $username)
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}