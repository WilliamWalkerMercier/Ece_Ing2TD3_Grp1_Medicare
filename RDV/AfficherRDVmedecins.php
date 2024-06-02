<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos rendez-vous de prévus</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="../RechercheParcourir/Recherche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <style>
        main{
            display: flex;
            justify-content: center;
        }
        form{
            display: flex;
            justify-content: center;
            align-items: center;
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
            <li><a href="../RDV/RendezVous.php">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png"
                                                           alt="Compte Logo"></a>
    </div>
</header>
<main>
    <?php
    function afficherRDV($db_handle, $idMedecin)
    {
        $rdvs = mysqli_query($db_handle, "SELECT * FROM RDV INNER JOIN Utilisateur ON RDV.Id_Client = Utilisateur.Id_User WHERE Id_Medecin ='" . $idMedecin . "'");
        $idRDV = -1;
        $listeCommandes = [];

        echo "<form method='post'><table>";

        if (mysqli_num_rows($rdvs) == 0) {
            echo "Vous n'avez pas de rendez-vous de prévus";
        } else {
            while ($rdv = mysqli_fetch_assoc($rdvs)) {
                $idRDV++;
                echo "<tr>
                            <td> Rendez-vous avec " . $rdv['Prenom'] . " " . $rdv['Nom'] . " le " . $rdv['Date_Heure'] . "</td>
                            <td><button type='submit' name='annuler' value='$idRDV'>Annuler </button></td>
                        </tr>";

                $listeCommandes[$idRDV] = "DELETE FROM RDV WHERE Id_Client='" . $rdv["Id_Client"] . "' AND Id_Medecin='" . $idMedecin . "' AND Date_Heure='" . $rdv['Date_Heure'] . "'";
            }
            echo "</table></form>";
        }

        return $listeCommandes;
    }

    ?>
    <?php
    $IdMedecin = $_SESSION['user_id'];

    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, 'medicare');

    $listeCommandes = afficherRDV($db_handle, $IdMedecin);

    // Ligne de débogage : afficher le tableau à l'aide de print_r au lieu de echo
    // echo "<pre>";
    // print_r($listeCommandes);
    // echo "</pre>";

    if (isset($_POST["annuler"])) {
        $annulerId = $_POST["annuler"];
        if (isset($listeCommandes[$annulerId])) {
            mysqli_query($db_handle, $listeCommandes[$annulerId]);
            echo "Commande exécutée : " . $listeCommandes[$annulerId] . "</br>";
            // Redirection après la soumission pour éviter la resoumission du formulaire
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Commande invalide.";
        }
    }

    mysqli_close($db_handle);
    ?>
</main>
</body>
</html>
