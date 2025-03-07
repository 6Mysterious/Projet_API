<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/users/login-user.php";

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['email'], $data['password'])) {
        echo jsonResponse(400, [], ["success" => false, "error" => "Données incomplètes"]);
        exit;
    }

    $response = loginUser($data['email'], $data['password']);

    if ($response["success"]) {
        echo jsonResponse(200, [], $response);
    } else {
        echo jsonResponse(401, [], $response);
    }
} catch (Exception $exception) {
    echo jsonResponse(500, [], ["success" => false, "error" => $exception->getMessage()]);
}
?>