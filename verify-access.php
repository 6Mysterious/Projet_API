<?php
require_once 'jeton.php';  // Assurez-vous que le chemin d'accès à jeton.php est correct

session_start();

if (!isset($_SESSION['jwt'])) {
    header('Location: front-login.php');  // Redirige vers la page de connexion
    exit();
}

$payload = verify_jwt($_SESSION['jwt']);
if ($payload === null) {
    header('Location: front-login.php');  // Redirige vers la page de connexion en cas de JWT invalide
    exit();
}

// Si le code arrive ici, cela signifie que le JWT est valide
