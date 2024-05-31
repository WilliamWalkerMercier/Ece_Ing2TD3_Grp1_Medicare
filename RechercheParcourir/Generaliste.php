<?php
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

// Obtenir la requête de recherche
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Échapper la requête pour éviter les injections SQL
$query = $conn->real_escape_string($query);

// Passer la requête en minuscule
$query = strtolower($query);

$sql = "SELECT medecin.*, utilisateur.Nom, utilisateur.Prenom, utilisateur.Mail, utilisateur.Telephone FROM medecin 
        JOIN utilisateur ON medecin.Id_Medecin = utilisateur.Id_User
        WHERE Specialite = ?";

$stmt = $conn->prepare($sql);
$specialite = 'Generaliste';
$stmt->bind_param('s', $specialite);

// Exécuter la requête
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generaliste</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="Specialiste.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAcceuil/LogoMedicare.ico">
    <link rel="stylesheet" href="CarteMed.css">
</head>
<body>
<section class="Specialiste">
    <h1>Médecins Généralistes</h1>
</section>
<header>
    <div class="logo">
        <a href="../Acceuil/Acceuil.html"><img src="../Acceuil/imageAcceuil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="../Acceuil/Acceuil.html">Accueil</a></li>
            <li class="SousMenu1">
                <a href="ToutParcourir.html" class="active">Tout Parcourir</a>
                <ul class="SousMenu2">
                    <li><a href="Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="Recherche.html">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="#"><img src="../Acceuil/imageAcceuil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<section>
    <div>
        <div class="cartes">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <section class="doctor-details">
                        <img src="<?php echo htmlspecialchars($row['Photo']); ?>" alt="Photo du médecin"
                             class="doctor-photo">
                        <div class="doctor-info">
                            <h2><?php echo htmlspecialchars($row['Nom'] . " " . $row['Prenom']); ?></h2>
                            <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($row['Specialite']); ?></p>
                            <p><strong>Bureau :</strong> <?php echo htmlspecialchars($row['Bureau']); ?></p>
                            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($row['Telephone']); ?></p>
                            <p><strong>Email :</strong> <?php echo htmlspecialchars($row['Mail']); ?></p>
                            <h3>Disponibilités</h3>
                            <div class="availability-calendar">
                                <div class="day">Lundi</div>
                                <div class="slot">Matin</div>
                                <div class="slot">Après-midi</div>
                                <div class="day">Mardi</div>
                                <div class="slot">Non disponible</div>
                                <div class="slot">Après-midi</div>
                                <div class="day">Mercredi</div>
                                <div class="slot">Matin</div>
                                <div class="slot">Non disponible</div>
                                <div class="day">Jeudi</div>
                                <div class="slot">Matin</div>
                                <div class="slot">Non disponible</div>
                                <div class="day">Vendredi</div>
                                <div class="slot">Matin</div>
                                <div class="slot">Après-midi</div>
                            </div>
                            <div class="doctor-actions">
                                <form action="PrendreRDV.php" method="get">
                                    <input type="hidden" name="id_Medecin" value="<?php echo htmlspecialchars($row['Id_Medecin']); ?>">
                                    <button type="submit" class="appointment-button">Prendre un RDV</button>
                                </form>
                                <button class="contact-button">Communiquer</button>
                                <button class="cv-button">Voir le CV</button>
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
<footer>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="../Acceuil/Acceuil.html" class="active">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="ToutParcourir.html">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="Generaliste.php">Médecin généraliste</a></li>
                            <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                            <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                        </ul>
                    </li>
                    <li><a href="Recherche.html">Recherche</a></li>
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
                <a href="#"><img src="../Acceuil/imageAcceuil/insta.png"></a>
            </div>
            <div class="x">
                <a href="#"><img src="../Acceuil/imageAcceuil/twitter.png"></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
