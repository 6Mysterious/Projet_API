<?php

function getOrders(): array
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $getUsersQuery = $databaseConnection->query("SELECT * FROM orders;");
    return $getUsersQuery->fetchAll(PDO::FETCH_ASSOC);
}
