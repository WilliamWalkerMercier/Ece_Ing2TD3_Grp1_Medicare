<?php
session_start();
?>

<!DOCTYPE html> <!--HTML et css fichier qui affiche les RDV médecins avec son css -->
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
        main {
            margin: 80px auto;
            padding: 20px;
            max-width: 1000px;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
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
            color: grey;
        }
        .Rendez-vous-à-venir {
            color: green;
        }
    </style>
</head>
<body><!-- Organisation de la page -->
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
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<main>
    <?php
function afficherRDV($db_handle, $idMedecin) //Fonction qui affiche les RDV du médecin
{
    $rdvs = mysqli_query($db_handle, "SELECT *, DATE_FORMAT(Date_Heure, '%Y-%m-%d %H:%i:%s') AS DateFormatee FROM RDV INNER JOIN Utilisateur ON RDV.Id_Client = Utilisateur.Id_User WHERE Id_Medecin ='" . $idMedecin . "'");
    $idRDV = -1;
    $listeCommandes = [];

    echo "<form method='post'><table>";
    $dateActuelle = date('Y-m-d H:i:s'); // Obtenir la date actuelle
    if (mysqli_num_rows($rdvs) == 0) {
        echo "<tr><td>Vous n'avez pas de rendez-vous de prévus.</td></tr>";
    } else {
        while ($rdv = mysqli_fetch_assoc($rdvs)) {
            $idRDV++;
            // Comparaison de la date du rendez-vous avec la date actuelle
            $classeRendezVous = (strtotime($rdv['DateFormatee']) < strtotime($dateActuelle)) ? "Rendez-vous-passés" : "Rendez-vous-à-venir";
            echo "<tr class='" . $classeRendezVous . "'>
                    <td> Rendez-vous avec " . $rdv['Prenom'] . " " . $rdv['Nom'] . " le " . $rdv['Date_Heure'] . "</td>
                    <td><button type='submit' name='annuler' value='$idRDV'>Annuler</button></td>
                  </tr>";

            $listeCommandes[$idRDV] = "DELETE FROM RDV WHERE Id_Client='" . $rdv["Id_Client"] . "' AND Id_Medecin='" . $idMedecin . "' AND Date_Heure='" . $rdv['Date_Heure'] . "'";
        }
        echo "</table></form>";
    }

    return $listeCommandes; // Retourne le tableau de commandes pour annulation de rendez-vous
}

    $IdMedecin = $_SESSION['user_id'];

    $db_handle = mysqli_connect('localhost', 'root', '');
    $db_found = mysqli_select_db($db_handle, 'medicare');

    $listeCommandes = afficherRDV($db_handle, $IdMedecin);

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
</main><!--Footer-->
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
