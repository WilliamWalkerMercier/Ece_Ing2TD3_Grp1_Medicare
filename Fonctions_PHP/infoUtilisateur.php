<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Médecin - Medicare</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->

    <?php
        function afficherUtilisateur($db_handle, $idUtilisateur){
            $infoClient=mysqli_fetch_assoc(mysqli_query($db_handle,"SELECT * FROM Utilisateur u INNER JOIN  Client c ON u.Id_User = c.Id_Client WHERE u.Id_User =".$idUtilisateur));
            echo 
            "<form method='post'> <table>
            <tr><td>Nom</td><td>".$infoClient["Nom"].                   "</td><td>Nouvelle valeur: </td><td><input type='text' name'nom'></td></tr>
            <tr><td>Prénom</td><td>".$infoClient["Prenom"].             "</td><td>Nouvelle valeur: </td><td><input type='text' name'prenom'></td></tr>
            <tr><td>Mail</td><td>".$infoClient["Mail"].                 "</td><td>Nouvelle valeur: </td><td><input type='text' name'mail'></td></tr>
            <tr><td>Téléphone</td><td>".$infoClient["Telephone"].       "</td><td>Nouvelle valeur: </td><td><input type='text' name'telephone'></td></tr>
            <tr><td>Pays</td><td>".$infoClient["Pays"].                 "</td><td>Nouvelle valeur: </td><td><input type='text' name'pays'></td></tr>
            <tr><td>Code Postal</td><td>".$infoClient["Code_Postal"].   "</td><td>Nouvelle valeur: </td><td><input type='text' name'code_postal'></td></tr>
            <tr><td>Ville</td><td>".$infoClient["Ville"].               "</td><td>Nouvelle valeur: </td><td><input type='text' name'ville'></td>r>
            <tr><td>Ligne d'adresse 1</td><td>".$infoClient["Adresse1"]."</td><td>Nouvelle valeur: </td><td><input type='text' name'adresse1'></td></tr>
            <tr><td>Ligne d'adresse 2</td><td>".$infoClient["Adresse2"]."</td><td>Nouvelle valeur: </td><td><input type='text' name'adresse2'></td></tr>
            <tr><td>Numéro de carte</td><td>******                       </td><td>Nouvelle valeur: </td><td><input type='text' name'num_cb'></td></tr>
            <tr><td>Type de Carte</td><td>".$infoClient["Type_Carte"]."</td><td>Nouvelle valeur: </td><td><input type='text' name'type_carte'></td></tr>
            <tr><td>Date d'expiration</td><td>".$infoClient["Date_Expiration"]."</td><td>Nouvelle valeur: </td><td><input type='text' name'date_expiration'></td></tr>
            <tr><td>Solde</td><td>".$infoClient["Solde"]."</td><td>Nouvelle valeur: </td><td><button>Si seulement...</button></td></tr>
            </table>
            <input type='submit' name='Modifier les informations'>
            </form>";
        }
     
    ?>
</head>
<body>

    <?php
        $db_handle = mysqli_connect('localhost', 'root', '');
        $db_found = mysqli_select_db($db_handle, 'medicare');

        if(isset($_POST["Modifier les informations"])){
            
        }
        mysqli_close($db_handle);
    ?>
</body>
</html>


