<?php
session_start();
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$specialite = "Andrologie";

$sql = "SELECT medecin.*, utilisateur.Nom, utilisateur.Prenom, utilisateur.Mail, utilisateur.Telephone FROM medecin 
        JOIN utilisateur ON medecin.Id_Medecin = utilisateur.Id_User
        WHERE Specialite = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $specialite);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$conn->close();

function AfficherDetails($idMedecin)
{
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, 'medicare');

    $retourRequete = mysqli_query($db_handle, "SELECT * FROM Utilisateur U LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin WHERE U.Id_User = '$idMedecin'");
    $resultat = mysqli_fetch_assoc($retourRequete);

    if (!$resultat) {
        echo "Aucune disponibilité trouvée pour ce médecin.";
        return;
    }

    $moments = array("Matin", "Après-midi");
    $jours = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
    $nbMoment = 0;

    foreach ($jours as $jour) {
        echo("<div class='day'>" . $jour . "</div>");
        foreach ($moments as $moment) {
            if (!isset($resultat["Disponibilite"][$nbMoment]) || !$resultat["Disponibilite"][$nbMoment]) {
                /* on vérifie si la clé est définie et si la valeur est vraie avant d'afficher */
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
    <title>Laboratoire</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="ToutParcourir.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CarteMed.css">
    <link rel="stylesheet" href="Specialiste.css">
</head>
<body>
<section class="Specialiste">
    <h1>Andrologie</h1>
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
                <ul class="SousMenu2">
                    <li><a href="Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="RechercheHTML.php">Recherche</a></li>
            <li><a href="../RDV/RendezVous.php">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
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
                <a href="Specialiste.php">
                    <i class='bx bx-grid-small'></i>
                    <span class="lien">Tous</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="Addictologie.php">
                    <i class='bx bx-injection'></i>
                    <span class="lien">Addictologie</span>
                </a>
            </li>
            <li class="MenuBarElement active2">
                <a href="Andrologie.php">
                    <i class='bx bx-male'></i>
                    <span class="lien">Andrologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="Cardiologie.php">
                    <i class='bx bx-heart'></i>
                    <span class="lien">Cardiologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="Dermatologie.php">
                    <i class='bx bx-band-aid'></i>
                    <span class="lien">Dermatologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="Gastro.php">
                    <i class='bx bx-baguette'></i>
                    <span class="lien">Gastro-Héato-Entérologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="Gynecologie.php">
                    <i class='bx bx-female'></i>
                    <span class="lien">Gynécologie</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="IST.php">
                    <i class='bx bxs-virus'></i>
                    <span class="lien">I.S.T</span>
                </a>
            </li>
            <li class="MenuBarElement">
                <a href="Osteopathie.php">
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
                                <?php AfficherDetails($row['Id_Medecin']); ?>
                            </div>
                            <div class="doctor-actions">
                                <?php
                                if (isset($_SESSION['LogedIn']) && $_SESSION['LogedIn'] === true) {
                                    // Le formulaire est affiché seulement si $_SESSION['Log'] est vrai
                                    ?>
                                    <form action="PrendreRDV.php" method="get">
                                        <input type="hidden" name="id_Medecin" value="<?php echo $row['Id_Medecin'] ?>">
                                        <button type="submit" class="appointment-button">Prendre un RDV</button>
                                    </form>
                                    <?php
                                } else {?>
                                    <form action="../RDV/RendezVous.php" method="get">
                                        <input type="hidden" name="id_Medecin" value="<?php echo $row['Id_Medecin'] ?>">
                                        <button type="submit" class="appointment-button">Prendre un RDV</button>
                                    </form>
                                    <?php
                                }
                                ?>
                                <button class="contact-button">Communiquer</button>
                                <form action="AfficheCv.php" method="get">
                                    <input type="hidden" name="medecin_id" value="<?php echo $row['Id_Medecin']; ?>">
                                    <button type="submit" class="appointment-button">Voir le CV</button>
                                </form>
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
<script src="Specialiste.js"></script>
</body>
</html>

