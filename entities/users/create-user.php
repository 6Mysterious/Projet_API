<?php

function createUser($email, $password, $phone_number, $address, $name, $surname)
{
  require_once __DIR__ . "/../../database/connection.php";

  $databaseConnection = getDatabaseConnection();

  $createUserQuery = $databaseConnection->prepare("
    INSERT INTO users (
      email,
      password,
      phone_number,
      address,
      name,
      surname
      
    ) VALUES (
      :email,
      :password,
      :phone_number,
      :address,
      :name,
      :surname
    );
  ");

  return $createUserQuery->execute([
    "email" => htmlspecialchars($email),
    "password" => password_hash($password, PASSWORD_BCRYPT),
    "phone_number" => htmlspecialchars($phone_number),
    "address" => htmlspecialchars($address),
    "name" => htmlspecialchars($name),
    "surname" => htmlspecialchars($surname)
  ]);
}
