<?php

require_once __DIR__ . "/../../libraries/response.php";

function generateToken($userId, $username)
{
    // **1️⃣ Créer l'en-tête JWT**
    $header = json_encode(["alg" => "HS256", "typ" => "JWT"]);
    
    // **2️⃣ Créer la charge utile (payload) avec ID utilisateur et expiration**
    $payload = json_encode([
        "user" => [
            "id" => $userId,
            "username" => $username
        ],
        "exp" => time() + 3600 // Expire dans 1 heure
    ]);

    // **3️⃣ Générer un secret sécurisé**
    $secret = bin2hex(random_bytes(32)); // Clé aléatoire de 256 bits (32 octets)

    // **4️⃣ Encodage Base64URL correct**
    $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    // **5️⃣ Signature HMAC-SHA256**
    $signature = hash_hmac("sha256", $base64Header . "." . $base64Payload, $secret, true);
    $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    // **6️⃣ Retourner le token complet**
    return $base64Header . "." . $base64Payload . "." . $base64Signature;
}

try {
    // Simuler un utilisateur avec un ID aléatoire
    $userId = random_int(1, 1000); 
    $username = "user" . $userId;

    echo jsonResponse(200, ["X-School" => "ESGI"], [
        "success" => true,
        "token" => generateToken($userId, $username)
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
