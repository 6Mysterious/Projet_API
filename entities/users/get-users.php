<?php


function getUsers(): array
{
    require_once __DIR__ . "/../../database/connection.php";
    $databaseConnection = getDatabaseConnection();

    // Récupération de l'ID à partir des paramètres GET
    $id = $_GET['id'] ?? null;

    if ($id) {
        // Requête pour récupérer l'utilisateur par ID
        $stmt = $databaseConnection->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
    } else {
        // Requête pour récupérer tous les utilisateurs si aucun ID n'est fourni
        $stmt = $databaseConnection->prepare("SELECT * FROM users");
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
