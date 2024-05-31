<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de créneau - Medicare</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="PrendreRDV.css">
    <link rel="icon" href="../Acceuil/imageAcceuil/LogoMedicare.ico">
</head>
<body>
<header>
    <div class="logo">
        <a href="../Acceuil/Acceuil.html"><img src="../Acceuil/imageAcceuil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="../Acceuil/Acceuil.html">Accueil</a></li>
            <li class="SousMenu1">
                <a href="ToutParcourir.html">Tout Parcourir</a>
                <ul class="SousMenu5">
                    <li><a href="Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="Recherche.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="#"><img src="../Acceuil/imageAcceuil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<section class="rdv">
    <h1>Réservation de créneau</h1>
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
            $resultat = mysqli_fetch_assoc($retourRequete);
            $jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
            $heuresMatin = ["08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30"];
            $heuresAprem = ["13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00"];
            $heuresJour = [$heuresMatin, $heuresAprem];
            $datesSemaine = datesSemaine($decalage);
            echo("Disponibilités de " . $resultat['Prenom'] . " " . $resultat['Nom'] . "<br>");
            echo("<form method='post'><table>");
            echo("<tr>");
            foreach ($jours as $jour) {
                echo("<td>" . $jour . " " . $datesSemaine[array_search($jour, $jours)] . "</td>");
            }
            echo("</tr>");
            foreach ($heuresJour as $heures) {
                foreach ($heures as $heure) {
                    echo("<tr>");
                    foreach ($jours as $jour) {
                        $date = $datesSemaine[array_search($jour, $jours)];
                        $reservationDuMoment = mysqli_query($db_handle, "SELECT * FROM RDV WHERE Date_Heure ='" . $date . " " . $heure . ":00' AND Id_Medecin='" . $idMedecin . "'");
                        if (mysqli_num_rows($reservationDuMoment) != 0) {
                            echo("<td>indisponible</td>");
                        } else {
                            echo("<td><button type='submit' name='date' value='" . $date . " " . $heure . ":00'>$heure</button></td>");
                        }
                    }
                    echo("</tr>");
                }
            }
            echo("</table><input type='hidden' name='decalage' value='$decalage'></form>");
        } else {
            echo("Base de données non trouvée");
        }
    }

    if (isset($_GET['id_Medecin'])) {
        $medecin = ($_GET['id_Medecin']);
    }
    $patient = 3;
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
            $insertionReussie = mysqli_query($db_handle, "INSERT INTO RDV (Id_Client, Id_Medecin, Id_lab, Nom_Service, Date_Heure) VALUES ('$patient', '$medecin', '0', '0', '$dateHeure')");
            if ($insertionReussie) {
                echo "Vous avez réservé le créneau : " . $dateHeure;
            } else {
                echo "Erreur lors de la réservation du créneau : " . mysqli_error($db_handle);
            }
        }
    }

    tableauRdv($medecin, $patient, $decalage, $db_handle);
    mysqli_close($db_handle);
    ?>
    <br>
    <form method="post">
        <input type="hidden" name="decalage" value="<?php echo $decalage; ?>">
        <input type="submit" name="decrementer" value="<-- Semaine précédente">
        <input type="submit" name="incrementer" value="Semaine suivante -->">
    </form>
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
                    <li><a href="Recherche.php">Recherche</a></li>
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