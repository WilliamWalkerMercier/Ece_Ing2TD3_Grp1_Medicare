<?php
// Configurer la connexion à la base de données
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

// Spécialité à exclure
$specialite = "Generaliste";

// Requête SQL pour récupérer les informations des médecins qui ne sont pas généralistes
$sql = "SELECT medecin.*, utilisateur.Nom, utilisateur.Prenom, utilisateur.Mail, utilisateur.Telephone 
        FROM medecin 
        JOIN utilisateur ON medecin.Id_Medecin = utilisateur.Id_User
        WHERE medecin.Specialite != ?";

// Préparation de la requête
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erreur lors de la préparation de la requête : " . $conn->error);
}

// Lier les paramètres
$stmt->bind_param("s", $specialite);

// Exécution de la requête
$stmt->execute();

// Récupération des résultats
$result = $stmt->get_result();
if (!$result) {
    die("Erreur lors de la récupération des résultats : " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specialiste</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="Specialiste.css">
    <link rel="icon" href="../Acceuil/imageAcceuil/LogoMedicare.ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CarteMed.css">
</head>
<body>
<section class="Specialiste">
    <h1>Médecins Spécialistes</h1>
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
<section class="SpecialisteResultats">
    <nav3 class="Bar">
        <div class="LogoMenu">
            <h2 class="specialite">Spécialité</h2>
            <i class='bx bx-menu toggle-btn'></i>
        </div>
        <ul class="MenuBar">
            <li class="MenuBarElement">
                <a href="addictologie.php">
                    <i class='bx bx-injection'></i>
                    <span class="lien">Addictologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="andrologie.php">
                    <i class='bx bx-male'></i>
                    <span class="lien">Andrologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="cardiologie.php">
                    <i class='bx bx-heart'></i>
                    <span class="lien">Cardiologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="dermatologie.php">
                    <i class='bx bx-band-aid'></i>
                    <span class="lien">Dermatologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="gastro.php">
                    <i class='bx bx-baguette'></i>
                    <span class="lien">Gastro-Héato-Entérologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="gynecologie.php">
                    <i class='bx bx-female'></i>
                    <span class="lien">Gynécologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="ist.php">
                    <i class='bx bxs-virus'></i>
                    <span class="lien">I.S.T</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="osteopathie.php">
                    <i class='bx bx-bone'></i>
                    <span class="lien">Ostéopathie</span>
                </a>
            </li>
        </ul>
    </nav3>
    <div>
        <?php if ($result->num_rows > 0): ?>
            <div class="cartes">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <section class="doctor-details">
                        <img src="<?php echo htmlspecialchars($row['Photo']); ?>" alt="Photo du médecin"
                             class="doctor-photo">
                        <div class="doctor-info">
                            <h2><?php echo htmlspecialchars($row['Nom'] . " " . $row['Prenom']); ?></h2>
                            <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($row['Specialite']); ?></p>
                            <?php if (isset($row['Bureau'])): ?>
                                <p><strong>Bureau :</strong> <?php echo htmlspecialchars($row['Bureau']); ?></p>
                            <?php endif; ?>
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
                                    <input type="hidden" name="id_Medecin" value="<?php echo $row['Id_Medecin'] ?>">
                                    <button type="submit" class="appointment-button">Prendre un RDV</button>
                                </form>
                                <button class="contact-button">Communiquer</button>
                                <button class="cv-button">Voir le CV</button>
                            </div>
                        </div>
                    </section>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Aucun médecin spécialiste trouvé.</p>
        <?php endif; ?>
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
<script src="Specialiste.js"></script>
</body>
</html>

<?php
// Fermer la connexion
$stmt->close();
$conn->close();
?>
