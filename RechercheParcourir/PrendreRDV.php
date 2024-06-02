<?php
include '../MonCompte/VerifConnection.php';
checkUserLoggedIn(); // Vérifie si l'utilisateur est connecté
checkPermission(2);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de créneau - Medicare</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="PrendreRDV.css">
    <link rel="stylesheet" href="Specialiste.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<header>
    <div class="logo">
        <a href="../Acceuil/Accueil.php"><img src="../Acceuil/imageAccueil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="../Acceuil/Accueil.php">Accueil</a></li>
            <li class="SousMenu1">
                <a href="ToutParcourir.php">Tout Parcourir</a>
                <ul class="SousMenu2">
                    <li><a href="Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="Recherche.php">Recherche</a></li>
            <li><a href="../RDV/RendezVous.php">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<section class="Specialiste">
    <h1>Réservation de créneau</h1>
</section>
<section class="rdv">
    <?php
    function datesSemaine($decalage) {
        $aujourdhui = new DateTime();
        $aujourdhui->modify("last sunday +1 day");
        $aujourdhui->modify("+{$decalage} week");
        $dates_semaine = [];
        for ($i = 0; $i < 7; $i++) {
            $date_jour = clone $aujourdhui;
            $date_jour->modify("+$i day");
            $dates_semaine[] = $date_jour->format('Y-m-d');
        }
        return $dates_semaine;
    }

    function tableauRdv($idMedecin, $patient, $decalage, $db_handle) {
        if ($db_handle) {
            $retourRequete = mysqli_query($db_handle, "SELECT * FROM Utilisateur U LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin WHERE U.Id_User = '$idMedecin'");
            if ($resultat = mysqli_fetch_assoc($retourRequete)) {
                $Dispo = $resultat['Disponibilite'];
                $jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
                $heuresMatin = ["08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30"];
                $heuresAprem = ["13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00"];
                $heuresJour = [$heuresMatin, $heuresAprem];
                $datesSemaine = datesSemaine($decalage);

                echo("Disponibilités de " . $resultat['Prenom'] . " " . $resultat['Nom'] . "<br>");
                echo("<form method='post'><table>");
                echo("<thead><tr>");
                foreach ($jours as $index => $jour) {
                    echo("<th>" . $jour . " " . $datesSemaine[$index] . "</th>");
                }
                echo("</tr></thead>");
                echo("<tbody>");

                foreach ($heuresJour as $indexHeure => $heures) {
                    foreach ($heures as $heure) {
                        echo("<tr>");
                        foreach ($jours as $indexJour => $jour) {
                            $date = $datesSemaine[$indexJour];
                            $heureIndex = $indexJour * 2 + ($indexHeure > 0 ? 1 : 0);
                            $isAvailable = $Dispo[$heureIndex] == '1';

                            $reservationDuMoment = mysqli_query($db_handle, "SELECT * FROM RDV WHERE Date_Heure ='" . $date . " " . $heure . ":00' AND Id_Medecin='" . $idMedecin . "'");

                            if (mysqli_num_rows($reservationDuMoment) == 0 && $isAvailable) {
                                echo("<td><button type='submit' name='date' value='" . $date . " " . $heure . ":00'>$heure</button></td>");
                            } else {
                                echo("<td class='indisponible'>Indisponible</td>");
                            }
                        }
                        echo("</tr>");
                    }
                }
                echo("</tbody>");
                echo("</table><input type='hidden' name='decalage' value='$decalage'></form>");
            } else {
                echo "Aucune information trouvée pour l'ID médecin $idMedecin.";
            }
        } else {
            echo("Base de données non trouvée");
        }
    }


    if (isset($_GET['id_Medecin'])) {
        $medecin = ($_GET['id_Medecin']);
    }
    $patient = $_SESSION['user_id'];
    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, 'medicare');
    $decalage = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['decalage'])) {
            $decalage = $_POST['decalage'];
        }
        if (isset($_POST['incrementer'])) {
            $decalage += 1;
        }
        if (isset($_POST['decrementer'])) {
            $decalage -= 1;
        }
        if (isset($_POST['date'])) {
            $dateHeure = $_POST['date'];
            $dateActuelle = date('Y-m-d H:i:s'); // Obtenir la date actuelle
            $classeRendezVous = (strtotime($dateHeure) < strtotime($dateActuelle)) ? "Rendez-vous-passés" : "Rendez-vous-à-venir";

            if($classeRendezVous!="Rendez-vous-passés"){
                $insertionReussie = mysqli_query($db_handle, "INSERT INTO RDV (Id_Client, Id_Medecin, Id_lab, Nom_Service, Date_Heure) VALUES ('$patient', '$medecin', '0', '0', '$dateHeure')");
                if ($insertionReussie) {
                    echo "Vous avez réservé le créneau : " . $dateHeure;
                } else {
                    echo "Erreur lors de la réservation du créneau : " . mysqli_error($db_handle);
                }
            }

        }
    }

    tableauRdv($medecin, $patient, $decalage, $db_handle);
    mysqli_close($db_handle);
    ?>
    <br>
    <form method="post">
        <input type="hidden" name="decalage" value="<?php echo $decalage; ?>">
        <input type="submit" name="decrementer" value="Semaine précédente">
        <input type="submit" name="incrementer" value="Semaine suivante">
    </form>
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
                    <li><a href="Recherche.php">Recherche</a></li>
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