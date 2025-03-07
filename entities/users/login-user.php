<?php
require_once __DIR__ . "/../../libraries/jeton.php";
require_once __DIR__ . "/../../database/connection.php";

function loginUser($email, $password) {
    $pdo = getDatabaseConnection();

    try {
        $stmt = $pdo->prepare("SELECT id, email, name, surname, password, token FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            
            $token = $user['token'] ?: generate_jwt(["id" => $user['id'], "email" => $user['email']]);
            if (!$user['token']) {  // Mise à jour du token dans la base de données si nécessaire
                $updateStmt = $pdo->prepare("UPDATE users SET token = :token WHERE id = :id");
                $updateStmt->execute(['token' => $token, 'id' => $user['id']]);
            }
            return [
                "success" => true,
                "user" => [
                    "name" => $user['name'],
                    "surname" => $user['surname'],
                    "email" => $user['email'],
                    "token" => $token
                ]
            ];
        } else {
            return ["success" => false, "error" => "Identifiants incorrects"];
        }
        
    } catch (PDOException $e) {
        return ["success" => false, "error" => "Erreur lors de la connexion: " . $e->getMessage()];
    }
}
?>