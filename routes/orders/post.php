<?php

// Récupérer des données depuis le corps de la requête
// Faire une requête SQL pour créer un utilisateur
// Renvoyer une réponse (succès, echec) à l'utilisateur de l'API

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/orders/create-order.php";

try {
    $body = getBody();

    createOrder($body["email_users"], $body["description"], $body["price"], $body["quantity"], $body["purchase_date"]);

    echo jsonResponse(200, [], [
        "success" => true,
        "message" => "Commande créé"
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
