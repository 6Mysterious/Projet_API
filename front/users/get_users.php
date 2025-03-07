<?php
// Récupérer les données JSON depuis l'API en PHP
$api_url = "https://localhost/users";

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Désactiver SSL en local si besoin
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$json_data = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Vérifier si la réponse est vide ou une erreur HTTP
if ($json_data === false || empty($json_data) || $http_status != 200) {
    die("Erreur : L'API ne répond pas correctement. Code HTTP : $http_status. Réponse brute : " . htmlspecialchars($json_data));
}

$data = json_decode($json_data, true);

// Vérifier si le JSON est bien décodé
if (!is_array($data)) {
    die("Erreur : Impossible de décoder le JSON. Réponse brute : " . htmlspecialchars($json_data));
}

if (!isset($data["success"]) || !$data["success"] || !isset($data["users"])) {
    die("Erreur : Structure JSON inattendue. Voici la réponse : " . json_encode($data));
}

$users = $data["users"];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utlisateurs</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>PROJET API</h1>
    <a href="../users.php">Back</a>
    <h1>Liste des utilisateurs</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>  
                <th>email</th>
                <th>name</th>
                <th>surname</th>
                <th>address</th>
                <th>phone</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user["id"] ?></td>
                        <td><?= $user["email"] ?></td>
                        <td><?= $user["name"] ?></td>
                        <td><?= $user["surname"] ?></td>
                        <td><?= $user["adress"] ?></td>
                        <td><?= $user["phone_number"] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">Aucune commande trouvée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
