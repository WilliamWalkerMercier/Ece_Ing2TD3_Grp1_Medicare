<?php
session_start();

// Configuration de la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicare";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientId = $_SESSION['user_id'];

// Requête SQL pour obtenir toutes les informations liées à l'utilisateur
$sql = "SELECT U.Id_User,U.Nom, U.Prenom, U.Mail,U.Carte_Vitale FROM Utilisateur U WHERE Id_User = $clientId";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AccueilMedecin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
        }

        .container {
            background: chartreuse;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: auto;
        }

        .UserInfo {
            text-align: center;
            margin-bottom: 20px; /* Space between user info and buttons */
        }

        .buttons {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Espace entre les boutons */
            max-width: 400px; /* Limite de largeur pour le conteneur */
        }

        .button {
            flex: 1 1 45%; /* Chaque bouton prendra environ 45% de la largeur disponible */
            /*
            *Premier chiffre: proportion pour s'agrandir
            *Deuxième chiffre: proportion pour se rétrécir
            *Troisième chiffre: taille initiale des cases
            *Source: https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_flexible_box_layout/Basic_concepts_of_flexbox
            */
            padding: 10px 20px; /* Haut-bas puis gauche-droite */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center; /* Centrer le texte dans les boutons */
        }

        #Info {
            background-color: #1e8ffd;
            color: #ffffff;
        }

        #ChatRoom {
            background-color: #32cc32;
            color: #ffffff;
        }


        #Deconnection {
            background-color: #7f007f;
            color: #ffffff;
        }
        .button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="UserInfo">
        <?php
        echo "<h2>{$row['Nom']} {$row['Prenom']}</h2>";
        echo "<p><strong>ID :</strong> {$row['Id_User']}</p>";
        echo "<p><strong>Courriel :</strong> {$row['Mail']}</p>";
        echo "<p><strong>Carte Vitale :</strong> {$row['Carte_Vitale']}</p>";
        ?>
    </div>
    <div class="buttons">
        <a href="../../RDV/infoUtilisateur.php">
        <button class="button" id="Info">Voir mes infos</button>
        </a>
        <button class="button" id="ChatRoom">Chatbox</button>
        <a href="../deconnexion.php">
            <button class="button" id="Deconnection">Se déconnecter</button><!-- Bouton Gérer les utilisateurs -->
        </a>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
