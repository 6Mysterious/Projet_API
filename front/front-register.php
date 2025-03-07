<?php
require_once __DIR__ . "/../database/settings.php"; 
require_once __DIR__ . "/../entities/users/register-user.php"; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $address = trim($_POST['address']);
    $phone_number = trim($_POST['phone_number']);

    $result = registerUser($email, $password, $name, $surname, $address, $phone_number);

    if ($result['success']) {
        $message = '<p style="color:green;">' . $result['message'] . '</p>';
    } else {
        $message = '<p style="color:red;">' . $result['error'] . '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php if (!empty($message)) echo $message; ?>

    <form action="front-register.php" method="POST">
        <label>Email :</label>
        <input type="email" name="email" required><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>

        <label>Nom :</label>
        <input type="text" name="name" required><br>

        <label>Prénom :</label>
        <input type="text" name="surname" required><br>

        <label>Adresse :</label>
        <input type="text" name="address" required><br>

        <label>Téléphone :</label>
        <input type="text" name="phone_number" required><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
