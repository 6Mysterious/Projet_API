<?php
$api_url = "http://localhost/orders"; 
$json_data = file_get_contents($api_url);
$data = json_decode($json_data, true);

if (!$data || !$data["success"]) {
    die("Erreur : Impossible de récupérer les commandes.");
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