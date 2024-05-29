<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous du Client - Medicare</title>
</head>
<body>
    <?php
        $db_handle = mysqli_connect('localhost', 'root', '', 'medicare');

        if ($db_handle) {
            $idClient = 3; // Remplacez cette valeur par l'ID du client souhaité

            // Vérifier si une annulation de rendez-vous a été demandée
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['annuler_rdv'])) {
                $idMedecin = $_POST['id_medecin'];
                $idLab = $_POST['id_lab'];
                $nomService = $_POST['nom_service'];
                $dateHeure = $_POST['date_heure'];

                // Supprimer le rendez-vous
                $deleteQuery = "
                    DELETE FROM RDV 
                    WHERE Id_Client = $idClient AND Id_Medecin = $idMedecin AND Id_Lab = $idLab AND Nom_Service = '$nomService' AND Date_Heure = '$dateHeure';
                ";
                if (mysqli_query($db_handle, $deleteQuery)) {
                    echo "Rendez-vous annulé avec succès.";
                } else {
                    echo "Erreur lors de l'annulation du rendez-vous : " . mysqli_error($db_handle);
                }
            }

            // Récupérer les rendez-vous du client
            $query = "
                SELECT 
                    RDV.Date_Heure, 
                    RDV.Id_Medecin, 
                    Medecin.Nom AS Nom_Medecin, 
                    Medecin.Prenom AS Prenom_Medecin, 
                    RDV.Id_Lab, 
                    Laboratoire.Nom AS Nom_Laboratoire, 
                    RDV.Nom_Service, 
                    ServiceLab.Description_Service
                FROM 
                    RDV
                INNER JOIN 
                    Medecin ON RDV.Id_Medecin = Medecin.Id_Medecin
                INNER JOIN 
                    Laboratoire ON RDV.Id_Lab = Laboratoire.Id_Lab
                INNER JOIN 
                    ServiceLab ON RDV.Nom_Service = ServiceLab.Nom_Service
                WHERE 
                    RDV.Id_Client = $idClient;
            ";

            $result = mysqli_query($db_handle, $query);

            if ($result) {
                echo "<table border='1'>";
                echo "<tr><th>Date et Heure</th><th>Médecin</th><th>Laboratoire</th><th>Service</th><th>Action</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['Date_Heure'] . "</td>";
                    echo "<td>" . $row['Prenom_Medecin'] . " " . $row['Nom_Medecin'] . "</td>";
                    echo "<td>" . $row['Nom_Laboratoire'] . "</td>";
                    echo "<td>" . $row['Nom_Service'] . " - " . $row['Description_Service'] . "</td>";
                    echo "<td>
                        <form method='post'>
                            <input type='hidden' name='id_medecin' value='" . $row['Id_Medecin'] . "'>
                            <input type='hidden' name='id_lab' value='" . $row['Id_Lab'] . "'>
                            <input type='hidden' name='nom_service' value='" . $row['Nom_Service'] . "'>
                            <input type='hidden' name='date_heure' value='" . $row['Date_Heure'] . "'>
                            <input type='submit' name='annuler_rdv' value='Annuler'>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Erreur dans l'exécution de la requête : " . mysqli_error($db_handle);
            }

            mysqli_close($db_handle);
        } else {
            echo "Échec de la connexion à la base de données.";
        }
    ?>
</body>
</html>