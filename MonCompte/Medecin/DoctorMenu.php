<?php

session_start();
$vDoctorId=$_SESSION['user_id'];

// Configurer la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicare";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtenir les informations du médecin à partir de son ID

$sql = "SELECT U.*, M.Specialite, M.CV, M.Disponibilite, M.Bureau, M.Photo, M.Photo2, M.Photo3, M.video
        FROM Utilisateur U 
        LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin
        WHERE U.Id_User = $vDoctorId";
$result = $conn->query($sql);
$doctor = $result->fetch_assoc();

// Initialiser la disponibilité
$disponibilite = isset($doctor['Disponibilite']) && strlen($doctor['Disponibilite']) == 12 ? str_split($doctor['Disponibilite']) : array_fill(0, 12, '0');

// Fermer la connexion
$conn->close();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Médecin</title>
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
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .userInfo {
            text-align: center;
            margin-bottom: 20px; /* Espace entre les infos utilisateur et les boutons */
        }
        .userInfo p {
            margin: 10px 0;
            font-size: 16px;
            color: #333;
        }
        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            width: 100%;
        }
        .button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            background-color: #1e8ffd;
            text-decoration: none; /* Supprimer le soulignement des liens */
            display: inline-block;
            text-align: center;
        }
        .button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="userInfo">
        <h2>Informations du Médecin</h2>
        <p>ID: <?php echo $doctor['Id_User']; ?></p>
        <p>Nom: <?php echo $doctor['Nom']; ?></p>
        <p>Prénom: <?php echo $doctor['Prenom']; ?></p>
        <p>Spécialité: <?php echo $doctor['Specialite']; ?></p>
        <p>Ville: <?php echo $doctor['Ville']; ?></p>
    </div>
    <div class="buttons">
        <a href="DoctorInfo.php?doctor_id=<?php echo $vDoctorId; ?>" class="button">Mes informations</a>
        <a href="../../ChatRoom/Chat.php" class="button">ChatRoom</a>
        <a href="../../RDV/AfficherRDVmedecins.php" class="button">Gestion des rendez-vous</a>
        <a href="../deconnexion.php" class="button">Se déconnecter</a>
    </div>
</div>
</body>
</html>
