<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Médecin - Medicare</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->

    <?php
    function AfficherDetails($idMedecin){/*affiche les informations d'un médecin telles que leur nom, leur bureau, leurs créneaux de disponibilité (ne prend pas en compte les réservations déjà effectuées chez cez médecin)*/
        $db_handle = mysqli_connect('localhost', 'root', '' );
        $db_found = mysqli_select_db($db_handle, 'medicare');

        $retourRequete=mysqli_query($db_handle,"SELECT * FROM Utilisateur U LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin WHERE U.Id_User = '$idMedecin'");
        $resultat = mysqli_fetch_assoc($retourRequete);
        echo("
        <img src='". $resultat["Photo"]."'alt=Dr.".$resultat["Prenom"]." ".$resultat["Nom"]."class='doctor-photo'>
        <div class='doctor-info'>
        <h2> Dr.".$resultat["Prenom"]." ".$resultat["Nom"]."</h2>
        <p><strong>Bureau :</strong>".$resultat["Bureau"]."</p>
        <p><strong>Téléphone :</strong>".$resultat["Telephone"]."</p>
        <p><strong>Courriel :</strong>".$resultat["Mail"]."</p>
        <h3>Disponibilités</h3>
        <div class='availability-calendar'>");

        $moments= array("Matin","Après-midi");
        $jours=array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
        $nbMoment=0;

        foreach($jours as $jour){
            echo("<div class='day'>".$jour."</div>");
            foreach($moments as $moment){
                if(!($resultat["Disponibilite"][$nbMoment])){/*on parcourt les disponnibilités du médecin pour savoir quoi afficher*/
                    echo("<div class='slot unavailable'>Non disponible</div>");
                }
                else{
                    echo("<div class='slot'>".$moment."</div>");
                }
                $nbMoment++;
            }

            }
        echo("</div>");
        mysqli_close($db_handle);
    }
?>
</head>
<body>
<header>
    <h1>Détails du Médecin</h1>
</header>

<section class="doctor-details">
    <?php AfficherDetails(5) ?>
        <div class="doctor-actions">
            <button class="appointment-button">Prendre un RDV</button>
            <button class="contact-button">Communiquer</button>
            <button class="cv-button">Voir le CV</button>
        </div>
    </div>
</section>
</body>
</html>





















