<?php

function deleteOrder(string $id): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $deleteOrderQuery = $databaseConnection->prepare("DELETE FROM orders WHERE id = :id");

    $deleteOrderQuery->execute([
        "id" => $id
    ]);
}