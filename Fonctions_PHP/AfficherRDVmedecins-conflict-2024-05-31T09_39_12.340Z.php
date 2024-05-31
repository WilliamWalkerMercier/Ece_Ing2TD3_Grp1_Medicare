<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos rendez-vous de prévus</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->
    <?php   
        function afficherRDV($db_handle, $idMedecin){
            $rdvs = mysqli_query($db_handle, "SELECT * FROM RDV INNER JOIN Utilisateur ON RDV.Id_Client = Utilisateur.Id_User WHERE Id_Medecin ='".$idMedecin."'");
            $idRDV=-1;
            $listeCommandes=[];
            echo "<form method='post'><table>";
            if(mysqli_num_rows($rdvs) == 0){
                echo "Vous n'avez pas de rendez-vous de prévus";
            }
            else{
                while($rdv = mysqli_fetch_assoc($rdvs)){
                    $idRDV++;
                    echo "<tr>
                            <td> Rendez-vous avec ".$rdv['Prenom']." ".$rdv['Nom']." le ".$rdv['Date_Heure']."</td>
                            <td><button type='submit' name='annuler' value='$idRDV'>Annuler </button></td>
                        </tr>";

                    $listeCommandes[$idRDV]="DELETE FROM RDV WHERE Id_Client='".$rdv["Id_Client"]."' AND Id_Medecin='".$idMedecin."' AND Date_Heure='".$rdv['Date_Heure']."'";
                }
                echo "</table></form>";
            }
            return $listeCommandes;
        }

?>

<body>
    <?php
        $IdMedecin=3;

        $db_handle = mysqli_connect('localhost', 'root', '');
        $db_found = mysqli_select_db($db_handle, 'medicare');

        $listeCommandes=afficherRDV($db_handle, $IdMedecin);

        if(isset($_POST["annuler"])) {
        mysqli_query($db_handle,$listeCommandes[$_POST["annuler"]]);
        echo $listeCommandes[$_POST["annuler"]];
        }

        mysqli_close($db_handle);
    ?>
</body>