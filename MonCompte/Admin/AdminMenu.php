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
        main {
            margin-top: 100px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 200px);
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 600px;
        }

        .UserInfo h2 {
            margin-bottom: 20px;
        }

        .UserInfo p {
            margin: 10px 0;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            flex: 1 1 calc(33.333% - 30px);
            width: auto;
            height: auto;
            color: #fff;
            background-color: #144b1f;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            opacity: 0.8;
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
            <li><a href="../../RechercheParcourir/RechercheHTML.php">Recherche</a></li>
            <li><a href="../../RDV/RendezVous.php">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="../RedirectConnection.php"><img src="../../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<main>
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
</main>
<footer>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="../../Acceuil/Accueil.php">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="../../RechercheParcourir/ToutParcourir.php">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="../../RechercheParcourir/Generaliste.php">Médecin généraliste</a></li>
                            <li><a href="../../RechercheParcourir/Specialiste.php">Médecin spécialistes</a></li>
                            <li><a href="../../RechercheParcourir/Laboratoire.php">Laboratoire de biologie médicale</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="../../RechercheParcourir/RechercheHTML.php">Recherche</a></li>
                    <li><a href="../../RDV/RendezVous.php">Rendez-vous</a></li>
                </ul>
            </nav2>
        </div>
    </div>
    <div class="copyright">
        <div class="copyright2">
            <p>Medicare &copy; 2024 Tous droits réservés.</p>
        </div>
        <div class="copyright3">
            <p>Medicare@medecine.fr</p>
        </div>
        <div class="copyright3">
            <p>06 25 78 98 67</p>
        </div>
        <div class="copyright3">
            <div class="insta">
                <a href="#"><img src="../../Acceuil/imageAccueil/insta.png"></a>
            </div>
            <div class="x">
                <a href="#"><img src="../../Acceuil/imageAccueil/twitter.png"></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
