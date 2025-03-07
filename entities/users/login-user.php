<?php
require_once __DIR__ . "/../../libraries/jeton.php";
require_once __DIR__ . "/../../database/connection.php";

function loginUser($email, $password) {
    $pdo = getDatabaseConnection();

    try {
        $stmt = $pdo->prepare("SELECT id, email, name, surname, password, token FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Vérifier si l'utilisateur a déjà un token
            if (empty($user['token'])) {
                // Générer un token si inexistant
                $token = generate_jwt(["id" => $user['id'], "email" => $user['email']]);
                
                // Enregistrer le token dans la base de données
                $updateStmt = $pdo->prepare("UPDATE users SET token = ? WHERE id = ?");
                $updateStmt->execute([$token, $user['id']]);
            } else {
                // Utiliser le token existant
                $token = $user['token'];
            }

            // Retourner les informations de l'utilisateur
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