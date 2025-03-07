<?php
$api_url = "http://localhost/orders"; 
$json_data = file_get_contents($api_url);
$data = json_decode($json_data, true);

if (!$data || !$data["success"]) {
    die("Erreur : Impossible de récupérer les commandes.");
}


$orders = $data["orders"] ?? []; 
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
                <th>Email</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Date d'achat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order["id"]) ?></td>
                        <td><?= htmlspecialchars($order["email_users"]) ?></td>
                        <td><?= htmlspecialchars($order["description"]) ?></td>
                        <td><?= htmlspecialchars($order["price"]) ?></td>
                        <td><?= htmlspecialchars($order["quantity"]) ?></td>
                        <td><?= htmlspecialchars($order["purchase_date"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Aucune commande trouvée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
