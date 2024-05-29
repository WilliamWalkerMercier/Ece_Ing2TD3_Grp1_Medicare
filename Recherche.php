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

// Requête SQL pour rechercher dans les tables Utilisateur, Medecin, ServiceLab et Laboratoire
$sql = "
    SELECT 'Medecin' AS Type, u.Nom, u.Prenom, m.Specialite, m.Bureau 
    FROM Utilisateur u 
    JOIN Medecin m ON u.Id_User = m.Id_Medecin 
    WHERE LOWER(u.Nom) LIKE '%$query%' OR LOWER(u.Prenom) LIKE '%$query%' OR LOWER(m.Specialite) LIKE '%$query%'
    UNION
    SELECT 'Service' AS Type, NULL AS Nom, NULL AS Prenom, s.Nom_Service AS Specialite, s.Description_Service AS Bureau 
    FROM ServiceLab s
    WHERE LOWER(s.Nom_Service) LIKE '%$query%'
    UNION
    SELECT 'Laboratoire' AS Type, NULL AS Nom, NULL AS Prenom, l.Nom AS Specialite, CONCAT('Salle: ', l.Salle, ', Téléphone: ', l.Telephone, ', Email: ', l.Email, ', Adresse: ', l.Adresse) AS Bureau 
    FROM Laboratoire l
    WHERE LOWER(l.Nom) LIKE '%$query%' OR LOWER(l.Adresse) LIKE '%$query%'
";

// Exécuter la requête
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recherche</title>
        <link rel="stylesheet" href="HeaderFooter.css">
        <link rel="stylesheet" href="Recherche.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" href="img/LogoMedicare.ico">
        <link rel="stylesheet" href="carte.css">
    </head>
<body>
    <section class="recherche">
        <h1>Recherche</h1>
        <div class="barre">
            <div class="iconRecherche">
                <form action="Recherche.php" method="get">
                    <input type="text" name="query" placeholder="Entrez un nom, une spécialité ou un service" required>
                    <a href="#" type="submit">
                        <i class="search fa fa-search"></i>
                    </a>
                </form>
            </div>
        </div>
    </section>
    <header>
        <div class="logo">
            <a href="Acceuil.html"><img src="img/LogoMedicare.png" alt="Medicare Logo"></a>
        </div>
        <nav>
            <ul>
                <li><a href="Acceuil.html">Accueil</a></li>
                <li class="SousMenu1">
                    <a href="#">Tout Parcourir</a>
                    <ul class="SousMenu2">
                        <li><a href="#">Médecin généraliste</a></li>
                        <li><a href="#">Médecin spécialistes</a></li>
                        <li><a href="#">Laboratoire de biologie médicale</a></li>
                    </ul>
                </li>
                <li><a href="Recherche.html" class="active">Recherche</a></li>
                <li><a href="#">Rendez-vous</a></li>
            </ul>
        </nav>
        <div class="CompteLogo">
            <a href="#"><img src="img/MonCompte.png" alt="Compte Logo"></a>
        </div>
    </header>
    <section class="RechercheResultats">
        <div>
            <?php if ($query): ?>
                <h1>Résultats de la recherche pour '<?php echo htmlspecialchars($query); ?>':</h1>
                <div class="cartes-medecins">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php if ($row['Type'] == 'Medecin'): ?>
                                <section class="doctor-details">
                                    <img src="img/MonCompte.png" alt="Photo du médecin" class="doctor-photo">
                                    <div class="doctor-info">
                                        <h2><?php echo htmlspecialchars($row['Nom'] . " " . $row['Prenom']); ?></h2>
                                        <p><strong>Spécialité :</strong> <?php echo htmlspecialchars($row['Specialite']); ?></p>
                                        <p><strong>Bureau :</strong> <?php echo htmlspecialchars($row['Bureau']); ?></p>
                                        <h3>Disponibilités</h3>
                                        <div class="availability-calendar">
                                            <div class="day">Lundi</div><div class="slot">Matin</div><div class="slot">Après-midi</div>
                                            <div class="day">Mardi</div><div class="slot">Non disponible</div><div class="slot">Après-midi</div>
                                            <div class="day">Mercredi</div><div class="slot">Matin</div><div class="slot">Non disponible</div>
                                            <div class="day">Jeudi</div><div class="slot">Matin</div><div class="slot">Non disponible</div>
                                            <div class="day">Vendredi</div><div class="slot">Matin</div><div class="slot">Après-midi</div>
                                        </div>
                                        <div class="doctor-actions">
                                            <button class="appointment-button">Prendre un RDV</button>
                                            <button class="contact-button">Communiquer</button>
                                            <button class="cv-button">Voir le CV</button>
                                        </div>
                                    </div>
                                </section>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Aucun résultat trouvé pour '<?php echo htmlspecialchars($query); ?>'</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <h1>Veuillez entrer une requête de recherche.</h1>
            <?php endif; ?>
        </div>
    </section>
    <footer class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="Acceuil.html" class="active">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="#">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="#">Médecin généraliste</a></li>
                            <li><a href="#">Médecin spécialistes</a></li>
                            <li><a href="#">Laboratoire de biologie médicale</a></li>
                        </ul>
                    </li>
                    <li><a href="Recherche.html">Recherche</a></li>
                    <li><a href="#">Rendez-vous</a></li>
                </ul>
            </nav2>
        </div>
    </footer>
    <footer class="copyright">
        <div class="copyright2">
            <p>Medicare &copy; 2024 Tous droits réservés.</p>
        </div>
        <div class="copyright3">
            <div class="insta">
                <a href="#"><img src="img/insta.png"></a>
            </div>
            <div class="x">
                <a href="#"><img src="img/twitter.png"></a>
            </div>
        </div>
    </footer>
    </body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
