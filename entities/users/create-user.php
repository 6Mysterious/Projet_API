<?php

function createUser(string $email, string $password, string $name, string $surname, string $adress, string $phone_number): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO users(
            email,
            password,
            name,
            surname,
            adress,
            phone_number
            
        ) VALUES (
            :email,
            :password,
            :name,
            :surname,
            :adress,
            :phone_number
        );
    ");

    $createUserQuery->execute([
        "email" => htmlspecialchars($email),
        "password" => password_hash(htmlspecialchars($password), PASSWORD_BCRYPT),
        "name" => htmlspecialchars($name),
        "surname" => htmlspecialchars($surname),
        "adress" => htmlspecialchars($adress),
        "phone_number" => htmlspecialchars($phone_number)
    ]);
}
