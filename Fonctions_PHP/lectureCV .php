<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de créneau - Medicare</title>

    <?php
    function lireCV($db_handle, $idMedecin) {
        $query = "SELECT CV FROM Medecin WHERE Id_Medecin = '".$idMedecin."'";
        $result = mysqli_query($db_handle, $query);
        if (!$result) {
            echo "Error executing query: " . mysqli_error($db_handle);
            return;
        }

        $row = mysqli_fetch_assoc($result);
        if (!$row) {
            echo "No CV found for the given Id_Medecin. ($idMedecin)";
            return;
        }

        $cvFileName = $row["CV"];
        $cvFilePath = $cvFileName . ".xml";

        if (file_exists($cvFilePath)) {
            $cv = simplexml_load_file($cvFilePath);
            if ($cv === false) {
                echo "Failed to load XML file.";
                return;
            }

            $diplomes = isset($cv->diplomes) ? (string)$cv->diplomes : 'Not found';
            $experiencesPro = isset($cv->experiencesPro) ? (string)$cv->experiencesPro : 'Not found';
            $aPropos = isset($cv->aPropos) ? (string)$cv->aPropos : 'Not found';

            echo "Diplomes: $diplomes<br>";
            echo "Experiences Pro: $experiencesPro<br>";
            echo "A Propos: $aPropos<br>";
        } else {
            echo "File not found: $cvFilePath";
        }
    }
    ?>
</head>
<body>
    <?php
    $medecin = 33;

    $db_handle = mysqli_connect('localhost', 'root', '');
    if (!$db_handle) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $db_found = mysqli_select_db($db_handle, 'medicare');
    if (!$db_found) {
        die("Database not found: " . mysqli_error($db_handle));
    }

    lireCV($db_handle, $medecin);

    mysqli_close($db_handle);
    ?>
</body>
</html>