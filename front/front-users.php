<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche d'Utilisateur</title>
    <script>
        function fetchAndFilterUsers() {
            const name = document.getElementById('searchInput').value.trim();
            const url = `http://127.0.0.1/users?name=${encodeURIComponent(name)}`;

            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.users.length > 0) {
                    displayResults(data.users);
                } else {
                    document.getElementById('results').innerHTML = "Aucun utilisateur trouvé.";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('results').innerHTML = "Erreur lors de la recherche.";
            });
        }

        function displayResults(users) {
            let html = `<table><tr><th>Email</th><th>Nom</th><th>Prénom</th><th>Adresse</th><th>Téléphone</th></tr>`;
            users.forEach(user => {
                html += `<tr>
                            <td>${user.email}</td>
                            <td>${user.name}</td>
                            <td>${user.surname}</td>
                            <td>${user.address}</td>
                            <td>${user.phone_number}</td>
                         </tr>`;
            });
            html += `</table>`;
            document.getElementById('results').innerHTML = html;
        }
    </script>
</head>
<body>
    <h1>Rechercher un utilisateur</h1>
    <input type="text" id="searchInput" placeholder="Entrer un nom ou prénom">
    <button onclick="fetchAndFilterUsers()">Rechercher</button>
    <div id="results"></div>
</body>
</html>
