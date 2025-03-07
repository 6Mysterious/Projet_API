<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un utilisateur</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 400px; margin: auto; display: flex; flex-direction: column; }
        label { font-weight: bold; margin-top: 10px; }
        input { padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 20px; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #218838; }
        .message { margin-top: 15px; font-weight: bold; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

    <h1>Création d'un utilisateur</h1>
    <a href="users.php">Retour à la liste</a>

    <form id="userForm">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required minlength="8">

        <label for="name">Nom</label>
        <input type="text" id="name" name="name" required>

        <label for="surname">Prénom</label>
        <input type="text" id="surname" name="surname" required>

        <label for="address">Adresse</label>
        <input type="text" id="address" name="address" required>

        <label for="phone">Téléphone</label>
        <input type="text" id="phone" name="phone" required pattern="[0-9]{10}">

        <button type="submit">Créer l'utilisateur</button>
    </form>

    <div id="message" class="message"></div>

    <script>
        document.getElementById("userForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            let formData = {
                email: document.getElementById("email").value,
                password: document.getElementById("password").value,
                name: document.getElementById("name").value,
                surname: document.getElementById("surname").value,
                adress: document.getElementById("address").value,
                phone_number: document.getElementById("phone").value
            };

            fetch("https://localhost/users", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                let messageDiv = document.getElementById("message");
                if (data.success) {
                    messageDiv.innerHTML = "OK" + data.message;
                    messageDiv.className = "message success";
                    document.getElementById("userForm").reset();
                } else {
                    messageDiv.innerHTML = "Erreur : " + (data.error || "Une erreur inconnue est survenue.");
                    messageDiv.className = "message error";
                }
            })
            .catch(error => {
                console.error("Erreur :", error);
                document.getElementById("message").innerHTML = "Une erreur est survenue lors de l'inscription.";
                document.getElementById("message").className = "message error";
            });
        });
    </script>

</body>
</html>