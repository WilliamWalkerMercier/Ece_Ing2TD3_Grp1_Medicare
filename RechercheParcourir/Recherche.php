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

// Obtenir la requête de recherche
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Échapper la requête pour éviter les injections SQL
$query = $conn->real_escape_string($query);

// Passer la requête en minuscule
$query = strtolower($query);

// Requête SQL pour rechercher dans les tables Utilisateur, Medecin, ServiceLab et Laboratoire
$sql = "
    SELECT 'Medecin' AS Type, u.Id_User AS Id, u.Nom, u.Prenom, u.Telephone, u.Mail, m.Specialite, m.Bureau, m.Photo, NULL AS Salle, NULL AS Adresse, m.Disponibilite AS Disponibilite 
    FROM Utilisateur u 
    JOIN Medecin m ON u.Id_User = m.Id_Medecin 
    WHERE LOWER(u.Nom) LIKE '%$query%' OR LOWER(u.Prenom) LIKE '%$query%' OR LOWER(m.Specialite) LIKE '%$query%'
    UNION
    SELECT 'Service' AS Type, s.Nom_Service AS Id, NULL AS Nom, NULL AS Prenom, NULL AS Telephone, NULL AS Mail, s.Nom_Service AS Specialite, s.Description_Service AS Bureau, s.Photo, NULL AS Salle, NULL AS Adresse, NULL AS Disponibilite
    FROM ServiceLab s
    WHERE LOWER(s.Nom_Service) LIKE '%$query%'
    UNION
    SELECT 'Laboratoire' AS Type, l.Id_Lab AS Id, l.Nom, NULL AS Prenom, l.Telephone AS Telephone, l.Email AS Mail, l.Nom AS Specialite, NULL AS Bureau, l.Photo, l.Salle, l.Adresse, NULL AS Disponibilite 
    FROM Laboratoire l
    WHERE LOWER(l.Nom) LIKE '%$query%' OR LOWER(l.Adresse) LIKE '%$query%'
";

// Exécuter la requête
$result = $conn->query($sql);

function AfficherDetails($idMedecin)
{
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, 'medicare');

    $retourRequete = mysqli_query($db_handle, "SELECT * FROM Utilisateur U LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin WHERE U.Id_User = '$idMedecin'");
    $resultat = mysqli_fetch_assoc($retourRequete);

    $moments = array("Matin", "Après-midi");
    $jours = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
    $nbMoment = 0;

    foreach ($jours as $jour) {
        echo("<div class='day'>" . $jour . "</div>");
        foreach ($moments as $moment) {
            if (!($resultat["Disponibilite"][$nbMoment])) {/*on parcourt les disponibilités du médecin pour savoir quoi afficher*/
                echo("<div class='slot unavailable'>Non disponible</div>");
            } else {
                echo("<div class='slot'>" . $moment . "</div>");
            }
            $nbMoment++;
        }

    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="Recherche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <link rel="stylesheet" href="CarteMed.css">
</head>
<body>
<section class="recherche">
    <h1>Recherche</h1>
    <div class="barre">
        <div class="iconRecherche">
            <form action="Recherche.php" method="get">
                <input type="text" name="query" placeholder="Entrez un nom, une spécialité ou un service" required>
                <a type="submit">
                    <i class="search fa fa-search"></i>
                </a>
            </form>
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
                <a href="ToutParcourir.php">Tout Parcourir</a>
                <ul class="SousMenu5">
                    <li><a href="Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="RechercheHTML.php" class="active">Recherche</a></li>
            <li><a href="../RDV/RendezVous.php">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<main>
    <section class="RechercheResultats">
        <div>
            <?php if ($query): ?>
                <h1>Résultats de la recherche pour '<?php echo htmlspecialchars($query); ?>':</h1>
                <div class="cartes">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php if ($row['Type'] == 'Medecin'): ?>
                                <section class="doctor-details">
                                    <img src="<?php echo htmlspecialchars($row['Photo']); ?>" alt="Photo du médecin"
                                         class="doctor-photo">
                                    <div class="doctor-info">
                                        <h2><?php echo htmlspecialchars($row['Nom'] . " " . $row['Prenom']); ?></h2>
                                        <p><strong>Spécialité
                                                :</strong> <?php echo htmlspecialchars($row['Specialite']); ?>
                                        </p>
                                        <?php if (isset($row['Bureau'])): ?>
                                            <p><strong>Bureau :</strong> <?php echo htmlspecialchars($row['Bureau']); ?>
                                            </p>
                                        <?php endif; ?>
                                        <p><strong>Téléphone
                                                :</strong> <?php echo htmlspecialchars($row['Telephone']); ?>
                                        </p>
                                        <p><strong>Email :</strong> <?php echo htmlspecialchars($row['Mail']); ?></p>
                                        <h3>Disponibilités</h3>
                                        <div class="availability-calendar">
                                            <?php AfficherDetails($row['Id']); ?>
                                        </div>
                                        <div class="doctor-actions">
                                            <?php
                                            if (isset($_SESSION['LogedIn']) && $_SESSION['LogedIn'] === true) {
                                                // Le formulaire est affiché seulement si $_SESSION['Log'] est vrai
                                                ?>
                                                <form action="PrendreRDV.php" method="get">
                                                    <input type="hidden" name="id_Medecin"
                                                           value="<?php echo $row['Id'] ?>">
                                                    <button type="submit" class="appointment-button">Prendre un RDV
                                                    </button>
                                                </form>
                                                <?php
                                            } else { ?>
                                                <form action="../RDV/RendezVous.php" method="get">
                                                    <input type="hidden" name="id_Medecin"
                                                           value="<?php echo $row['Id'] ?>">
                                                    <button type="submit" class="appointment-button">Prendre un RDV
                                                    </button>
                                                </form>
                                                <?php
                                            }
                                            ?>
                                            <a href="Communication.php">
                                                <button class="contact-button">Communiquer</button>
                                            </a>
                                            <form action="AfficheCv.php" method="get">
                                                <input type="hidden" name="medecin_id"
                                                       value="<?php echo $row['Id']; ?>">
                                                <button type="submit" class="appointment-button">Voir le CV</button>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            <?php elseif ($row['Type'] == 'Service'): ?>
                                <section class="service-details">
                                    <img src="<?php echo htmlspecialchars($row['Photo']); ?>" alt="Photo des services"
                                         class="service-photo">
                                    <div class="service-info">
                                        <h2><?php
                                            $vNomService = $row['Specialite'];
                                            echo htmlspecialchars($row['Specialite']); ?></h2>
                                        <p><strong>Description
                                                :</strong> <?php echo htmlspecialchars($row['Bureau']); ?></p>
                                        <div class="Service-actions">
                                            <?php

                                            // Configurer la connexion à la base de données
                                            $servername = "localhost";
                                            $username = "root";
                                            $password = "";
                                            $dbname = "medicare";

                                            // Créer la connexion
                                            $conn2 = new mysqli($servername, $username, $password, $dbname);

                                            // Vérifier la connexion
                                            if ($conn2->connect_error) {
                                                die("Connection failed: " . $conn2->connect_error);
                                            }


                                            // Utilisation de requêtes préparées pour éviter les injections SQL
                                            $stmt2 = $conn2->prepare("SELECT Payant FROM servicelab WHERE Nom_Service = ?");
                                            $stmt2->bind_param("s", $vNomService); // 's' spécifie que la variable est une chaîne (string)
                                            $stmt2->execute();
                                            $result2 = $stmt2->get_result();

                                            if ($result2->num_rows > 0) {
                                                $row = $result2->fetch_assoc();
                                                $payant = $row['Payant'];

                                                if ($payant == 1) {
                                                    ?>
                                                    <p><strong>Payant
                                                            :</strong> 6 €</p>
                                                    <form action="checkoutForm.html" method="get">
                                                        <input type="hidden" name="Nom_Service"
                                                               value="<?php
                                                               $_SESSION['NomServiceBesoin'] = $vNomService;
                                                               echo $vNomService ?>">
                                                        <button type="submit" class="appointment-button">Payer le
                                                            service
                                                        </button>
                                                    </form>
                                                    <?php

                                                } else {
                                                    ?>
                                                    <p><strong>Payant
                                                            :</strong>Non</p>
                                                    <form action="PrendreRDVservice.php" method="get">
                                                    <input type="hidden" name="Nom_Service"
                                                           value="<?php echo $vNomService ?>">
                                                    <button type="submit" class="appointment-button">Prendre un RDV
                                                    </button>
                                                    </form><?php
                                                }
                                            }
                                            $stmt2->close();
                                            $conn2->close(); ?>
                                        </div>
                                    </div>
                                </section>
                            <?php elseif
                            ($row['Type'] == 'Laboratoire'): ?>
                                <section class="laboratoire-details">
                                    <img src="<?php echo htmlspecialchars($row['Photo']); ?>" alt="Photo du médecin"
                                         class="laboratoire-photo">
                                    <div class="laboratoire-info">
                                        <h2><?php echo htmlspecialchars($row['Nom']); ?></h2>
                                        <?php if (!empty($row['Salle'])): ?>
                                            <p><strong>Salle :</strong> <?php echo htmlspecialchars($row['Salle']); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if (!empty($row['Adresse'])): ?>
                                            <p><strong>Adresse
                                                    :</strong> <?php echo htmlspecialchars($row['Adresse']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($row['Telephone'])): ?>
                                            <p><strong>Téléphone
                                                    :</strong> <?php echo htmlspecialchars($row['Telephone']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($row['Mail'])): ?>
                                            <p><strong>Email :</strong> <?php echo htmlspecialchars($row['Mail']); ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="laboratoire-actions">
                                            <form action="NosServices.php" method="get">
                                                <button class="laboratoire-button">Nos Services</button>
                                            </form>
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
</main>
<footer>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="../Acceuil/Acceuil.php" class="active">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="ToutParcourir.php">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="Generaliste.php">Médecin généraliste</a></li>
                            <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                            <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                        </ul>
                    </li>
                    <li><a href="RechercheHTML.php">Recherche</a></li>
                    <li><a href="../RDV/RendezVous.php">Rendez-vous</a></li>
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

<?php
// Fermer la connexion
$conn->close();
?>
