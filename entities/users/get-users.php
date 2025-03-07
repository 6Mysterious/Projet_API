<?php

function getUsers(): array
{
    require_once __DIR__ . "/../../database/connection.php";
    $databaseConnection = getDatabaseConnection();
    $name = $_GET['name'] ?? null;
    
    if ($name) {
        $stmt = $databaseConnection->prepare("SELECT * FROM users WHERE LOWER(name) LIKE LOWER(:name) OR LOWER(surname) LIKE LOWER(:name)");
        $nameParam = '%' . $name . '%';
        $stmt->bindParam(':name', $nameParam);
    } else {
        $stmt = $databaseConnection->prepare("SELECT * FROM users");
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}