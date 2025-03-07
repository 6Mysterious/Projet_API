<?php

require_once __DIR__ . "/../../database/connection.php";

function getOrders(): array
{
    $databaseConnection = getDatabaseConnection();
    $email = $_GET['email'] ?? null;
    $description = $_GET['description'] ?? null;

    if ($email) {
        $stmt = $databaseConnection->prepare("SELECT * FROM orders WHERE LOWER(email_users) LIKE LOWER(?)");
        $email = '%' . $email . '%';
        $stmt->bindParam(1, $email);
    } elseif ($description) {
        $stmt = $databaseConnection->prepare("SELECT * FROM orders WHERE LOWER(description) LIKE LOWER(?)");
        $description = '%' . $description . '%';
        $stmt->bindParam(1, $description);
    } else {
        $stmt = $databaseConnection->prepare("SELECT * FROM orders");
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
