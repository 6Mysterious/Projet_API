<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/users/register-user.php";

try {
    $data = json_decode(file_get_contents("php://input"), true);
    var_dump($data);

    if (!isset($data['email'], $data['password'], $data['name'], $data['surname'], $data['address'], $data['phone_number'])) {
        echo jsonResponse(400, [], ["success" => false, "error" => "Données incomplètes"]);
        exit;
    }

    $response = registerUser($data['email'], $data['password'], $data['name'], $data['surname'], $data['address'], $data['phone_number']);

    if ($response["success"]) {
        echo jsonResponse(201, [], $response);
    } else {
        echo jsonResponse(500, [], $response);
    }
} catch (Exception $exception) {
    echo jsonResponse(500, [], ["success" => false, "error" => $exception->getMessage()]);
}
?>