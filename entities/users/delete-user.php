<?php

function deleteUser(string $id): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $deleteUserQuery = $databaseConnection->prepare("DELETE FROM users WHERE id = :id");

    $deleteUserQuery->execute([
        "id" => $id
    ]);
}
