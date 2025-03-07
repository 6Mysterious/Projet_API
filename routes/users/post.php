<?php

// Récupérer des données depuis le corps de la requête
// Faire une requête SQL pour créer un utilisateur
// Renvoyer une réponse (succès, echec) à l'utilisateur de l'API

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/users/create-user.php";

try {
    $body = getBody();

    createUser($body["email"], $body["password"], $body["name"], $body["surname"], $body["adress"], $body["phone_number"]);

    echo jsonResponse(200, [], [
        "success" => true,
        "message" => "Utlisateur créé"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}