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
    <link rel="stylesheet" href="../../HeaderFooter.css">
    <link rel="stylesheet" href="../../RechercheParcourir/Recherche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../../Acceuil/imageAccueil/LogoMedicare.ico">
    <style>

        .container {
            display: flex;
            flex-direction: column;
            padding: 80px;
            align-items: center;
            color: black;
            overflow: hidden;
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

<?php
$conn->close();
?>
