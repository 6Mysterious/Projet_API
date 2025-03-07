<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding: 20px; }
        input, button { margin: 5px; padding: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Gestion des Utilisateurs</h1>

    <!-- GET USERS -->
    <h2>Liste des Utilisateurs</h2>
    <button onclick="getUsers()">Charger les Utilisateurs</button>
    <input type="number" id="getUserId" placeholder="ID Utilisateur">
    <button onclick="getUserById()">Rechercher par ID</button>
    <div id="usersList"></div>

    <!-- POST USER -->
    <h2>Ajouter un Utilisateur</h2>
    <input type="text" id="postName" placeholder="Nom">
    <input type="text" id="postSurname" placeholder="Prénom">
    <input type="email" id="postEmail" placeholder="Email">
    <input type="text" id="postPhone" placeholder="Téléphone">
    <input type="text" id="postAddress" placeholder="Adresse">
    <button onclick="addUser()">Ajouter</button>
    <p id="postResponse"></p>

    <!-- PATCH USER -->
    <h2>Modifier un Utilisateur</h2>
    <input type="number" id="patchUserId" placeholder="ID Utilisateur">
    <input type="text" id="patchName" placeholder="Nouveau Nom">
    <input type="text" id="patchSurname" placeholder="Nouveau Prénom">
    <button onclick="updateUser()">Mettre à jour</button>
    <p id="patchResponse"></p>

    <!-- DELETE USER -->
    <h2>Supprimer un Utilisateur</h2>
    <input type="number" id="deleteUserId" placeholder="ID Utilisateur">
    <button onclick="deleteUser()">Supprimer</button>
    <p id="deleteResponse"></p>

    <script>
        const API_URL = "http://127.0.0.1/users"; // Remplacez par l'URL de votre API

        // GET ALL USERS
        function getUsers() {
            fetch(API_URL)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayUsers(data.users);
                    } else {
                        document.getElementById('usersList').innerHTML = "Aucun utilisateur trouvé.";
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }

        // GET USER BY ID
        function getUserById() {
            const userId = document.getElementById('getUserId').value;
            fetch(`${API_URL}?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayUsers([data.user]);
                    } else {
                        document.getElementById('usersList').innerHTML = "Utilisateur non trouvé.";
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }

        // POST USER (Ajouter)
        function addUser() {
            const user = {
                name: document.getElementById('postName').value,
                surname: document.getElementById('postSurname').value,
                email: document.getElementById('postEmail').value,
                phone_number: document.getElementById('postPhone').value,
                address: document.getElementById('postAddress').value
            };

            fetch(API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(user)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('postResponse').innerText = data.message;
                getUsers(); // Rafraîchir la liste
            })
            .catch(error => console.error('Erreur:', error));
        }

        // PATCH USER (Modifier)
        function updateUser() {
            const userId = document.getElementById('patchUserId').value;
            const updateData = {
                name: document.getElementById('patchName').value,
                surname: document.getElementById('patchSurname').value
            };

            fetch(`${API_URL}/${userId}`, {
                method: "PATCH",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(updateData)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('patchResponse').innerText = data.message;
                getUsers(); // Rafraîchir la liste
            })
            .catch(error => console.error('Erreur:', error));
        }

        // DELETE USER (Supprimer)
        function deleteUser() {
            const userId = document.getElementById('deleteUserId').value;

            fetch(`${API_URL}/${userId}`, {
                method: "DELETE"
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('deleteResponse').innerText = data.message;
                getUsers(); // Rafraîchir la liste
            })
            .catch(error => console.error('Erreur:', error));
        }

        // AFFICHAGE DES UTILISATEURS DANS UN TABLEAU
        function displayUsers(users) {
            let html = `<table>
                <tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Téléphone</th><th>Adresse</th></tr>`;
            users.forEach(user => {
                html += `<tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.surname}</td>
                    <td>${user.email}</td>
                    <td>${user.phone_number}</td>
                    <td>${user.address}</td>
                </tr>`;
            });
            html += `</table>`;
            document.getElementById('usersList').innerHTML = html;
        }
    </script>
</body>
</html>
