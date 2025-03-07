<?php

const SECRET_KEY = "votre_cle_secrete"; // Change cette clé pour une clé sécurisée

function base64UrlEncode($data) {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

function generate_jwt($payload) {
    $header = base64UrlEncode(json_encode(["alg" => "HS256", "typ" => "JWT"]));
    $payload['iat'] = time();  // Date de création
    $payload['exp'] = time() + 3600; // Expiration dans 1 heure
    $payload = base64UrlEncode(json_encode($payload));

    // Créer la signature
    $signature = hash_hmac('sha256', "$header.$payload", SECRET_KEY, true);
    $signature = base64UrlEncode($signature);

    // Retourner le JWT complet
    return "$header.$payload.$signature";
}

function verify_jwt($token) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return null; // Format invalide
    }

    list($header, $payload, $signature) = $parts;

    // Vérifier la signature
    $expected_signature = hash_hmac('sha256', "$header.$payload", SECRET_KEY, true);
    $expected_signature = base64UrlEncode($expected_signature);

    if (!hash_equals($expected_signature, $signature)) {
        return null; // Signature invalide
    }

    // Décoder le payload
    $payload = json_decode(base64_decode($payload), true);

    // Vérifier si le token a expiré
    if (isset($payload['exp']) && $payload['exp'] < time()) {
        return null; // Token expiré
    }

    return $payload; // Retourne les données du token
}
