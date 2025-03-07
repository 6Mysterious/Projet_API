<?php

require_once __DIR__ . "/../../libraries/response.php";

function generateToken()
{
    $header = json_encode(["alg" => "HS256", "typ" => "JWT"]);
    $payload = json_encode(["user" => ["id" => 1, "username" => "testuser", "password" => '$2y$10$']]);
    $secret
        = "
    12345678901234567890123456789012
    12345678901234567890123456789012
    12345678901234567890123456789012
    12345678901234567890123456789012
    ";

    return base64_encode($header) . "." . base64_encode($payload) . "." . hash_hmac("sha256", $header . $payload, $secret);
}

try {

    echo jsonResponse(200, ["X-School" => "ESGI"], [
        "success" => true,
        "token" => generateToken()
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}

