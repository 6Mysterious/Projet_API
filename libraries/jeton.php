<?php

const SECRET_KEY = "ma_cle_est_secrete";

function base64UrlEncode($data) {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

function generate_jwt($payload) {
    $header = base64UrlEncode(json_encode(["alg" => "HS256", "typ" => "JWT"]));
    $payload['iat'] = time();  
    $payload['exp'] = time() + 3600; 
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
        return null;
    }

    list($header, $payload, $signature) = $parts;

    $expected_signature = hash_hmac('sha256', "$header.$payload", SECRET_KEY, true);
    $expected_signature = base64UrlEncode($expected_signature);

    if (!hash_equals($expected_signature, $signature)) {
        return null; 
    }

    $payload = json_decode(base64_decode($payload), true);

    if (isset($payload['exp']) && $payload['exp'] < time()) {
        return null;
    }

    return $payload; 
}
