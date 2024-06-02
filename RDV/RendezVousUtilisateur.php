<?php
session_start()
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Client - Medicare</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="../RechercheParcourir/Recherche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <style>
        main {
            margin: 80px auto;
            padding: 20px;
            max-width: 1000px;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #35424a;
            color: white;
        }

        input[type=text], button {
            padding: 10px;
            margin-top: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #35424a;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        button:hover {
            background-color: #144b1f;
        }
        .Rendez-vous-passés {
            color: indianred;
        }
        .Rendez-vous-à-venir {
            color: green;
        }
    </style>
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
                <a href="../RechercheParcourir/ToutParcourir.php">Tout Parcourir</a>
                <ul class="SousMenu5">
                    <li><a href="../RechercheParcourir/Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="../RechercheParcourir/Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="../RechercheParcourir/Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="../RechercheParcourir/RechercheHTML.php">Recherche</a></li>
            <li><a href="../RDV/RendezVous.php" class="active">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<main>
    <?php
    function afficherUtilisateur($db_handle, $idUtilisateur)
    {
        $infoClient = mysqli_fetch_assoc(mysqli_query($db_handle, "SELECT * FROM Utilisateur u left JOIN Client c ON u.Id_User = c.Id_Client WHERE u.Id_User =" . $idUtilisateur));
        echo "<form method='post'><table>
            <tr><th>Champ</th><th>Valeur actuelle</th><th>Nouvelle valeur</th></tr>
            <tr><td>Nom</td><td>" . $infoClient["Nom"] . "</td><td><input type='text' name='nom'></td></tr>
            <tr><td>Prénom</td><td>" . $infoClient["Prenom"] . "</td><td><input type='text' name='prenom'></td></tr>
            <tr><td>Mail</td><td>" . $infoClient["Mail"] . "</td><td><input type='text' name='mail'></td></tr>
            <tr><td>Téléphone</td><td>" . $infoClient["Telephone"] . "</td><td><input type='text' name='telephone'></td></tr>
            <tr><td>Pays</td><td>" . $infoClient["Pays"] . "</td><td><input type='text' name='pays'></td></tr>
            <tr><td>Code Postal</td><td>" . $infoClient["Code_Postal"] . "</td><td><input type='text' name='code_postal'></td></tr>
            <tr><td>Ville</td><td>" . $infoClient["Ville"] . "</td><td><input type='text' name='ville'></td></tr>
            <tr><td>Ligne d'adresse 1</td><td>" . $infoClient["Adresse1"] . "</td><td><input type='text' name='adresse1'></td></tr>
            <tr><td>Ligne d'adresse 2</td><td>" . $infoClient["Adresse2"] . "</td><td><input type='text' name='adresse2'></td></tr>
            <tr><td>Numéro de carte</td><td>" . $infoClient["Num_Cb"] . "</td><td><input type='text' name='num_cb'></td></tr>
            <tr><td>Type de Carte</td><td>" . $infoClient["Type_Carte"] . "</td><td><input type='text' name='type_carte'></td></tr>
            <tr><td>Date d'expiration</td><td>" . $infoClient["Date_Expiration"] . "</td><td><input type='text' name='date_expiration'></td></tr>
            <tr><td>Code de Sécurité</td><td>" . $infoClient["Code_Securite"] . "</td><td><input type='text' name='code_securite'></td></tr>
            <tr><td>Solde</td><td>" . $infoClient["Solde"] . "</td><td><button>Si seulement...</button></td></tr>
            </table>
            <input type='hidden' name='idUtilisateur' value='" . $idUtilisateur . "'>
            <button type='submit' name='modifier'>Modifier les informations</button>
            </form>";
    }

    function afficherRDV($db_handle, $idUtilisateur)
    {
        $rdvs = mysqli_query($db_handle,
            "SELECT *, DATE_FORMAT(Date_Heure, '%Y-%m-%d %H:%i:%s') AS DateFormatee FROM RDV 
         LEFT JOIN Medecin ON RDV.Id_Medecin = Medecin.Id_Medecin 
         LEFT JOIN Utilisateur ON Medecin.Id_Medecin = Utilisateur.Id_User 
         LEFT JOIN Laboratoire ON RDV.Id_Lab = Laboratoire.Id_Lab
         WHERE Id_Client = " . $idUtilisateur);

        $idRDV = -1;
        $listeCommandes = [];
        echo "<form method='post'><table>";

        $dateActuelle = date('Y-m-d H:i:s'); // Obtenir la date actuelle

        if (mysqli_num_rows($rdvs) > 0) {
            while ($rdv = mysqli_fetch_assoc($rdvs)) {
                $idRDV++;
                // Comparaison de la date du rendez-vous avec la date actuelle
                $classeRendezVous = (strtotime($rdv['DateFormatee']) < strtotime($dateActuelle)) ? "Rendez-vous-passés" : "Rendez-vous-à-venir";

                echo "<tr class=' . $classeRendezVous '><td>";
                if ($rdv["Id_Lab"] == 0) { // Gestion des rendez-vous avec médecins
                    echo " Rendez-vous avec " . $rdv['Prenom'] . " " . $rdv['Nom'];
                    echo ($rdv['Specialite'] != NULL && $rdv['Specialite'] != "Generaliste") ? " (" . $rdv['Specialite'] . ")" : " (Généraliste)";
                    echo " le " . $rdv['Date_Heure'] . " en " . $rdv["Bureau"] . "</td>";
                } else { // Gestion des rendez-vous avec laboratoires
                    echo " Rendez-vous au laboratoire Médical au " . $rdv["Adresse"] . ", dans la salle " . $rdv["Salle"] . " et le service " . $rdv["Nom_Service"] . "</td>";
                }
                if($classeRendezVous!="Rendez-vous-passés"){
                    echo "<td><button type='submit' name='annuler' value='$idRDV'>Annuler</button></td></tr>";
                    $listeCommandes[$idRDV] = "DELETE FROM RDV WHERE Id_Client='$idUtilisateur' AND Date_Heure='" . $rdv['Date_Heure'] . "' AND Nom_Service='" . $rdv["Nom_Service"] . "' AND Id_Lab='" . $rdv["Id_Lab"] . "'";
                }
            }
        }

        echo "</table></form>";
        return $listeCommandes; // Toujours retourner un tableau, même vide
    }

    ?>
    <?php
    $idUtilisateur = $_SESSION['user_id'];

    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, 'medicare');

    $listeCommandes = afficherRDV($db_handle, $idUtilisateur);
    if (empty($listeCommandes)) {
        echo "Aucun rendez-vous à afficher.";
    }

    if (isset($_POST["modifier"])) {
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
    if (isset($_POST["annuler"]) && isset($listeCommandes[$_POST["annuler"]])) {
        mysqli_query($db_handle, $listeCommandes[$_POST["annuler"]]);
    }

    mysqli_close($db_handle);
    ?>
</main>
<footer>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="../Acceuil/Accueil.php" class="active">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="../RechercheParcourir/ToutParcourir.php">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="../RechercheParcourir/Generaliste.php">Médecin généraliste</a></li>
                            <li><a href="../RechercheParcourir/Specialiste.php">Médecin spécialistes</a></li>
                            <li><a href="../RechercheParcourir/Laboratoire.php">Laboratoire de biologie médicale</a></li>
                        </ul>
                    </li>
                    <li><a href="../RechercheParcourir/Recherche.php">Recherche</a></li>
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
