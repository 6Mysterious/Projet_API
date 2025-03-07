<?php
// Récupérer les données JSON depuis l'API en PHP
$api_url = "https://localhost/orders";

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

if (!isset($data["success"]) || !$data["success"] || !isset($data["orders"])) {
    die("Erreur : Structure JSON inattendue. Voici la réponse : " . json_encode($data));
}

$orders = $data["orders"];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des commandes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Liste des commandes</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>  
                <th>email</th>
                <th>description</th>
                <th>price</th>
                <th>quantity</th>
                <th>purchase date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order["id"] ?></td>
                        <td><?= $order["email_users"] ?></td>
                        <td><?= $order["description"] ?></td>
                        <td><?= $order["price"] ?></td>
                        <td><?= $order["quantity"] ?></td>
                        <td><?= $order["purchase_date"] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">Aucune commande trouvée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
