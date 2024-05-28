<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de créneau - Medicare</title>

    <?php
    function datesSemaine($decallage) {
        // Obtenir la date du jour
        $aujourdhui = new DateTime();
        // Prendre le dernier dimanche
        $aujourdhui->modify("last sunday");
        $aujourdhui->modify("+1 day");
        $aujourdhui->modify("+{$decallage} week");
        
        // Calculer les dates des jours de la semaine
        $dates_semaine = [];
        for ($i = 0; $i < 7; $i++) {
            $date_jour = clone $aujourdhui;
            $date_jour->modify("+$i day");
            $dates_semaine[] = $date_jour->format('Y-m-d');
        }
        return $dates_semaine;
    }

    function tableauRdv($idMedecin, $patient, $decallage, $db_handle) {
        if ($db_handle) {
            $retourRequete = mysqli_query($db_handle, "SELECT * FROM Utilisateur U LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin WHERE U.Id_User = '$idMedecin'");
            $resultat = mysqli_fetch_assoc($retourRequete);

            $jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
            $heuresMatin = ["08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30"];
            $heuresAprem = ["13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00"];
            $heuresJour = [$heuresMatin, $heuresAprem];

            $datesSemaine = datesSemaine($decallage);

            $idJour = 0;
            $idMoment = 0;

            echo("Disponibilités de " . $resultat['Prenom'] . " " . $resultat['Nom'] . "</br>");

            echo("<form method='post'><table>");
            echo("<tr>");

            for ($i = 0; $i < 6; $i++) {
                echo("<td> " . $jours[$i] . " " . $datesSemaine[$i] . " &emsp;</td>");
            }
            echo("</tr>");
            foreach ($heuresJour as $heures) {
                foreach ($heures as $heure) {
                    echo("<tr>");
                    foreach ($jours as $jour) {
                        $reservationDuMoment = mysqli_query($db_handle, "SELECT * FROM RDV WHERE Date_Heure ='" . $datesSemaine[$idJour] . " " . $heure . ":00' AND Id_Medecin='" . $idMedecin . "'");
                        if (!($resultat["Disponibilite"][$idJour * 2 + $idMoment]) or mysqli_num_rows($reservationDuMoment) != 0) {
                            echo("<td>indisponible</td>");
                        } else {
                            echo("<td><button type='submit' name='date' value='" . $datesSemaine[$idJour] . " " . $heure . ":00'>$heure</button></td>");
                        }
                        $idJour = fmod($idJour + 1, 6);
                    }
                    echo("</tr>");
                }
                $idMoment = fmod($idMoment + 1, 2);
            }
            echo("</table><input type='hidden' name='decallage' value='$decallage'></form>");
        } else {
            echo("Base de données non trouvée");
        }
    }
    ?>
</head>
<body>
    <?php
    $medecin = 5;
    $patient = 3;

    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, 'medicare');

    $decallage = 0; // Initialisation de la variable

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['decallage'])) {
            $decallage = $_POST['decallage'];
        }

        if (isset($_POST['incrementer'])) {
            $decallage += 1;
        }

        if (isset($_POST['decrementer'])) {
            $decallage -= 1;
        }

        if (isset($_POST['date'])) {
            $dateHeure = $_POST['date'];
            $insertionReussie = mysqli_query($db_handle, "INSERT INTO RDV VALUES ('$patient', '$medecin', '0', '0', '$dateHeure')");
            if ($insertionReussie) {
                echo "Vous avez réservé le créneau : " . $dateHeure;
            } else {
                echo "Erreur lors de la réservation du créneau : " . mysqli_error($db_handle);
            }
        }
    }

    tableauRdv($medecin, $patient, $decallage, $db_handle);

    mysqli_close($db_handle);
    ?>
    </br>
    <form method="post">
        <input type="hidden" name="decallage" value="<?php echo $decallage; ?>">
        <input type="submit" name="decrementer" value="<--Semaine précédente">
        <input type="submit" name="incrementer" value="Semaine suivante-->">
    </form>
</body>
</html>
