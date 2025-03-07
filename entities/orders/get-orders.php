<?php

require_once __DIR__ . "/../../database/connection.php";

function getOrders(): array
{
    $databaseConnection = getDatabaseConnection();
    $id = $_GET['id'] ?? null;  // Récupérer l'ID depuis la requête GET

    if ($id) {
        // Préparation de la requête SQL pour rechercher par ID
        $stmt = $databaseConnection->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // Assurer que l'ID est traité comme un entier
    } else {
        // Requête par défaut pour récupérer tous les ordres si aucun ID n'est spécifié
        $stmt = $databaseConnection->prepare("SELECT * FROM orders");
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>