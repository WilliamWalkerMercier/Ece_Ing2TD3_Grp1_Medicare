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
