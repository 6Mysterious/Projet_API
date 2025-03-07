<?php
require_once __DIR__ . "/../../database/connection.php"; 

function registerUser($email, $password, $name, $surname, $address, $phone_number) {
    $pdo = getDatabaseConnection(); 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            return ["success" => false, "error" => "Cet email est déjà utilisé."];
        }

        $stmt = $pdo->prepare("INSERT INTO users (email, password, name, surname, address, phone_number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $name, $surname, $address, $phone_number]);

        return ["success" => true, "message" => "Utilisateur enregistré avec succès"];
    } catch (PDOException $e) {
        return ["success" => false, "error" => "Erreur lors de l'inscription: " . $e->getMessage()];
    }
}
