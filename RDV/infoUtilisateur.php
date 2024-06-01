<?php
session_start()
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Client - Medicare</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->

    <?php
        function afficherUtilisateur($db_handle, $idUtilisateur){
            $infoClient = mysqli_fetch_assoc(mysqli_query($db_handle, "SELECT * FROM Utilisateur u left JOIN Client c ON u.Id_User = c.Id_Client WHERE u.Id_User =".$idUtilisateur));
            /*Pour tester avec des uti_lisateurs qui sont des médecins, mettre left join à la place de Innr join*/
            echo /*tableau qui contient les informations et des boutons permettant de le modiier*/
            "<form method='post'> <table>
            <tr><td>Nom</td><td>".$infoClient["Nom"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='nom'></td></tr>
            <tr><td>Prénom</td><td>".$infoClient["Prenom"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='prenom'></td></tr>
            <tr><td>Mail</td><td>".$infoClient["Mail"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='mail'></td></tr>
            <tr><td>Téléphone</td><td>".$infoClient["Telephone"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='telephone'></td></tr>
            <tr><td>Pays</td><td>".$infoClient["Pays"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='pays'></td></tr>
            <tr><td>Code Postal</td><td>".$infoClient["Code_Postal"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='code_postal'></td></tr>
            <tr><td>Ville</td><td>".$infoClient["Ville"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='ville'></td></tr>
            <tr><td>Ligne d'adresse 1</td><td>".$infoClient["Adresse1"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='adresse1'></td></tr>
            <tr><td>Ligne d'adresse 2</td><td>".$infoClient["Adresse2"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='adresse2'></td></tr>
            <tr><td>Numéro de carte</td><td>******</td><td>Nouvelle valeur: </td><td><input type='text' name='num_cb'></td></tr>
            <tr><td>Type de Carte</td><td>".$infoClient["Type_Carte"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='type_carte'></td></tr>
            <tr><td>Date d'expiration</td><td>".$infoClient["Date_Expiration"]."</td><td>Nouvelle valeur: </td><td><input type='text' name='date_expiration'></td></tr>
            <tr><td>Code de Sécurité</td><td>******</td><td>Nouvelle valeur: </td><td><input type='text' name='code_securite'></td></tr>
            <tr><td>Solde</td><td>".$infoClient["Solde"]."</td><td>Nouvelle valeur: </td><td><button>Si seulement...</button></td></tr>
            </table>
            <input type='hidden' name='idUtilisateur' value='".$idUtilisateur."'>
            <input type='submit' name='modifier' value='Modifier les informations'>
            </form>";
        } 
        function afficherRDV($db_handle, $idUtilisateur){            
            $rdvs = mysqli_query($db_handle, 
            "SELECT * FROM RDV LEFT JOIN Medecin ON RDV.Id_Medecin = Medecin.Id_Medecin 
             LEFT JOIN Utilisateur ON Medecin.Id_Medecin = Utilisateur.Id_User 
             LEFT JOIN Laboratoire ON RDV.Id_Lab=Laboratoire.Id_Lab
             WHERE Id_Client =".$idUtilisateur);
            $idRDV=-1;
            $listeCommandes=[];
            echo "<form method='post'><table>";
            while($rdv = mysqli_fetch_assoc($rdvs)){
                $idRDV++;
                if($rdv["Id_Lab"]==0){
                    echo "<tr><td> Rendez-vous avec ".$rdv['Prenom']." ".$rdv['Nom'];
                    if ($rdv['Specialite']!=NULL || $rdv['Specialite']!="Generaliste"){
                        echo " (".$rdv['Specialite'].") ";
                    }
                    else{
                        echo " (Généraliste) ";
                    }
                    echo "le ".$rdv['Date_Heure']." en ".$rdv["Bureau"].
                    "</td><td><button type='submit' name='annuler' value='$idRDV'>Annuler </button>";
                    $listeCommandes[$idRDV]="DELETE FROM RDV WHERE Id_Client='$idUtilisateur' AND Id_Medecin='".$rdv['Id_Medecin']."' AND Date_Heure='".$rdv['Date_Heure']."'";
                }
                else{
                    /*ATTENTION: je n'ai pas teste cette commande*/
                    echo "<tr><td> Rendez-vous au laboratoire Médical au ".$rdv["Adresse"].", dans la salle ".$rdv["Salle"].". et le service". $rdv["Nom_Service"]."</td>";
                    echo "<td><button type='submit' name='annuler value='$idRDV'>Annuler </button>";
                    $listeCommandes[$idRDV]="DELETE FROM RDV WHERE Id_Client='$idUtilisateur' AND Date_Heure='".$rdv['Date_Heure']."' AND Nom_Service='".$rdv["Nom_Service"]."' AND Id_Lab='".$rdv["Id_Lab"]."'";

                }

            }
            echo "</table></form>";
            return $listeCommandes;
        }
    ?>
</head>
<body>
    <?php
        $idUtilisateur = $_SESSION['user_id'];


    $db_handle = mysqli_connect('localhost', 'root', '');
        $db_found = mysqli_select_db($db_handle, 'medicare');

        // Affichage des informations de l'utilisateur avec l'ID spécifié
        afficherUtilisateur($db_handle, $idUtilisateur);
        $listeCommandes=afficherRDV($db_handle, $idUtilisateur);

        if(isset($_POST["modifier"])){
            $idUtilisateur = $_POST['idUtilisateur'];
            $updatesUtilisateur = [];
            $updatesClient = [];

            if (!empty($_POST['nom'])) {//on regarde siles champs sont remplis. SI c'est le cas, on ajoute une modification à apporter à la base.
                $updatesUtilisateur[] = "Nom='" . mysqli_real_escape_string($db_handle, $_POST['nom']) . "'";
            }
            if (!empty($_POST['prenom'])) {
                $updatesUtilisateur[] = "Prenom='" . mysqli_real_escape_string($db_handle, $_POST['prenom']) . "'";
            }
            if (!empty($_POST['mail'])) {
                $updatesUtilisateur[] = "Mail='" . mysqli_real_escape_string($db_handle, $_POST['mail']) . "'";
            }
            if (!empty($_POST['telephone'])) {
                $updatesUtilisateur[] = "Telephone='" . mysqli_real_escape_string($db_handle, $_POST['telephone']) . "'";
            }
            if (!empty($_POST['pays'])) {
                $updatesUtilisateur[] = "Pays='" . mysqli_real_escape_string($db_handle, $_POST['pays']) . "'";
            }
            if (!empty($_POST['code_postal'])) {
                $updatesUtilisateur[] = "Code_Postal='" . mysqli_real_escape_string($db_handle, $_POST['code_postal']) . "'";
            }
            if (!empty($_POST['ville'])) {
                $updatesUtilisateur[] = "Ville='" . mysqli_real_escape_string($db_handle, $_POST['ville']) . "'";
            }
            if (!empty($_POST['adresse1'])) {
                $updatesUtilisateur[] = "Adresse1='" . mysqli_real_escape_string($db_handle, $_POST['adresse1']) . "'";
            }
            if (!empty($_POST['adresse2'])) {
                $updatesUtilisateur[] = "Adresse2='" . mysqli_real_escape_string($db_handle, $_POST['adresse2']) . "'";
            }
            if (!empty($_POST['num_cb'])) {
                $updatesClient[] = "Num_Cb='" . mysqli_real_escape_string($db_handle, $_POST['num_cb']) . "'";
            }
            if (!empty($_POST['type_carte'])) {
                $updatesClient[] = "Type_Carte='" . mysqli_real_escape_string($db_handle, $_POST['type_carte']) . "'";
            }
            if (!empty($_POST['date_expiration'])) {
                $updatesClient[] = "Date_Expiration='" . mysqli_real_escape_string($db_handle, $_POST['date_expiration']) . "'";
            }
            if (!empty($_POST['code_securite'])) {
                $updatesClient[] = "Code_Securite='" . mysqli_real_escape_string($db_handle, $_POST['code_securite']) . "'";
            }
            if (!empty($_POST['solde'])) {
                $updatesClient[] = "Solde='" . mysqli_real_escape_string($db_handle, $_POST['solde']) . "'";
            }

            if (count($updatesUtilisateur) > 0 || count($updatesClient) > 0) {
                mysqli_begin_transaction($db_handle);

                if (count($updatesUtilisateur) > 0) {
                    $queryUtilisateur = "UPDATE Utilisateur SET " . implode(", ", $updatesUtilisateur) . " WHERE Id_User=" . $idUtilisateur;
                    mysqli_query($db_handle, $queryUtilisateur);
                }

                if (count($updatesClient) > 0) {
                    $queryClient = "UPDATE Client SET " . implode(", ", $updatesClient) . " WHERE Id_Client=" . $idUtilisateur;
                    mysqli_query($db_handle, $queryClient);
                }

                mysqli_commit($db_handle);
                echo "Les informations ont été mises à jour avec succès.";
            } else {
                echo "Aucun champ n'a été rempli.";
            }
        }
        if(isset($_POST["annuler"])) {
        mysqli_query($db_handle,$listeCommandes[$_POST["annuler"]]);
        }



        mysqli_close($db_handle);
    ?>
</body>
</html>
