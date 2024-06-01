<?php

session_start();


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

$doctor_id = $_SESSION['user_id'];

// Si le formulaire de mise à jour est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Si le formulaire de suppression est soumis
    if (isset($_POST['delete_doctor'])) {
        $doctor_id = $_SESSION['user_id'];
        // Supprimer le docteur de la table Medecin
        $conn->query("DELETE FROM Medecin WHERE Id_Medecin = $doctor_id");

        //Met à jour le type de l'utilisateur , notamment pour l'affichage
        $conn->query("UPDATE Utilisateur SET Type = 2 WHERE Id_User = $doctor_id");
    }
}

// Obtenir tous les utilisateurs et toutes les informations liées aux utilisateurs
$sql = "SELECT * FROM Utilisateur WHERE Id_User = $doctor_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
/*
    Chemin d'accès pour les photos à changer pour mettre tout au même endroit (à voir plus tard)

*/
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion requise</title>
    <link rel="stylesheet" href="../../HeaderFooter.css">
    <link rel="stylesheet" href="../../RechercheParcourir/Recherche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../../Acceuil/imageAccueil/LogoMedicare.ico">
    <style>

        .container {
            display: flex;
            flex-direction: column;
            padding: 30px;
            align-items: center;
            color: black;
            overflow: hidden;
            top: 70px;
            width: auto;
            position: relative;
            height: auto;
        }

        .UserInfo {
            text-align: center;
            margin-bottom: 20px; /* Space between user info and buttons */
        }

        .buttons {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
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

        #DoctorList {
            background-color: #1e8ffd;
            color: #ffffff;
        }

        #LaboInfo {
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
<header>
    <div class="logo">
        <a href="../../Acceuil/Accueil.php"><img src="../../Acceuil/imageAccueil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="../../Acceuil/Accueil.php">Accueil</a></li>
            <li class="SousMenu1">
                <a href="../../RechercheParcourir/ToutParcourir.php">Tout Parcourir</a>
                <ul class="SousMenu5">
                    <li><a href="../../RechercheParcourir/Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="../../RechercheParcourir/Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="../../RechercheParcourir/Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="RechercheHTML.php" class="active">Recherche</a></li>
            <li><a href="../../RDV/RendezVous.php">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="#"><img src="../../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<div class="container"><!-- Contient tout l'affichage -->
    <div class="UserInfo"><!-- Affiche les informations de l'utilisateur -->
        <?php echo "<h2>{$row['Prenom']} {$row['Nom']}</h2>";
        echo "<p><strong>ID:</strong> {$row['Id_User']}</p>";
        echo "<p><strong>Courriel :</strong> {$row['Mail']}</p>";
        ?>
    </div>
    <div class="buttons"><!-- Bloc des boutons -->
        <a href="administrateur.php">
            <button class="button" id="DoctorList">Liste des médecins</button><!-- Bouton Liste des médecins -->
        </a>
        <a href="laboratoire.php">
            <button class="button" id="LaboInfo">Info Laboratoire</button><!-- Bouton Info Laboratoire -->
        </a>
        <a href="../deconnexion.php">
            <button class="button" id="Deconnection">Se déconnecter</button><!-- Bouton Gérer les utilisateurs -->
        </a>
    </div>
</div>

</body>
</html>
