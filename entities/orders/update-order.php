<?php

function updateOrder(string $id, $columns): void
{
    if (count($columns) === 0) {
        return;
    }

    require_once __DIR__ . "/../../database/connection.php";

    $authorizedColumns = ["email_user", "description", "price", "quantity", "purchase_date"];

    $set = [];

    $sanitizedColumns = [
        "id" => htmlspecialchars($id)
    ];

    foreach ($columns as $columnName => $columnValue) {
        if (!in_array($columnName, $authorizedColumns)) {
            continue;
        }

        $set[] = "$columnName = :$columnName";

        $sanitizedColumns[$columnName] = htmlspecialchars($columnValue);
    }

    $set = implode(", ", $set);

    $databaseConnection = getDatabaseConnection();
    $updateOrderQuery = $databaseConnection->prepare("UPDATE orders SET $set WHERE id = :id;");
    $updateOrderQuery->execute($sanitizedColumns);
}
