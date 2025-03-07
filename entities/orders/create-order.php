<?php

function createOrder(string $email_users, string $description, string $price, string $quantity, string $purchase_date): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createOrderQuery = $databaseConnection->prepare("
        INSERT INTO orders(
            email_users,
            description,
            price,
            quantity,
            purchase_date
        ) VALUES (
            :email_users,
            :description,
            :price,
            :quantity,
            :purchase_date
        );
    ");

    $createOrderQuery->execute([
        "email_users" => htmlspecialchars($email_users),
        "description" => htmlspecialchars($description),
        "price" => htmlspecialchars($price),
        "quantity" => htmlspecialchars($quantity),
        "purchase_date" => htmlspecialchars($purchase_date)
    ]);
}
