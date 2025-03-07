<?php
require_once __DIR__ . "/../database/settings.php";
require_once __DIR__ . "/../entities/users/login-user.php";

$userInfo = null;
$errorMessage = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $result = loginUser($email, $password);

    if ($result["success"]) {
        $userInfo = $result["user"];
    } else {
        $errorMessage = $result["error"];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="front-login.php" method="POST">
        <label>Email :</label>
        <input type="email" name="email" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <button type="submit">Se connecter</button>
    </form>

    <?php if ($userInfo): ?>
        <h2>Informations de l'utilisateur :</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($userInfo["name"]) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($userInfo["surname"]) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($userInfo["email"]) ?></p>
        <p><strong>Token :</strong> <?= htmlspecialchars($userInfo["token"]) ?></p>
    <?php elseif ($errorMessage): ?>
        <p style="color: red;"><strong>Erreur :</strong> <?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>
</body>
</html>
