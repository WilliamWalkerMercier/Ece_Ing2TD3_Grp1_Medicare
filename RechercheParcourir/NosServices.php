<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer toutes les informations de la table servicelab
$sql = "SELECT * FROM servicelab";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratoire</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="ToutParcourir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <link rel="stylesheet" href="CarteMed.css">
</head>
<body>
<section class="ToutParcourirResultats">
    <div>
        <div class="cartes">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <section class="doctor-details">
                        <img src="<?php echo htmlspecialchars($row['Photo']); ?>" alt="Photo du laboratoire"
                             class="laboratoire-photo">
                        <div class="service-info">
                            <h2><?php echo htmlspecialchars($row['Nom_Service']); ?></h2>
                            <p><strong>Description :</strong> <?php echo htmlspecialchars($row['Description_Service']); ?></p>
                            <div class="laboratoire-actions">
                                <form action="PrendreRDVservice.php" method="get">
                                    <input type="hidden" name="Nom_Service" value="<?php echo $row['Nom_Service'] ?>">
                                    <button type="submit" class="appointment-button">Prendre un RDV</button>
                                </form>
                            </div>
                        </div>
                    </section>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Aucun médecin généraliste trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<header>
    <div class="logo">
        <a href="../Acceuil/Accueil.php"><img src="../Acceuil/imageAccueil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="../Acceuil/Accueil.php">Accueil</a></li>
            <li class="SousMenu1">
                <a href="ToutParcourir.php" class="active">Tout Parcourir</a>
                <ul class="SousMenu5">
                    <li><a href="Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="RechercheHTML.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="#"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<footer>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="../Acceuil/Accueil.php" class="active">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="ToutParcourir.php">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="Generaliste.php">Médecin généraliste</a></li>
                            <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                            <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                        </ul>
                    </li>
                    <li><a href="RechercheHTML.php">Recherche</a></li>
                    <li><a href="#">Rendez-vous</a></li>
                </ul>
            </nav2>
        </div>
    </div>
    <div class="copyright">
        <div class="copyright2">
            <p>Medicare &copy; 2024 Tous droits réservés.</p>
        </div>
        <div class="copyright3">
            <div class="insta">
                <a href="#"><img src="../Acceuil/imageAccueil/insta.png"></a>
            </div>
            <div class="x">
                <a href="#"><img src="../Acceuil/imageAccueil/twitter.png"></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

