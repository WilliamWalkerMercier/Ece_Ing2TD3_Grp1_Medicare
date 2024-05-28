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
            //prendre le dernier dimanche
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
        function tableauRdv($idMedecin,$decallage){/*décallage: 0 si semaine actuelle, 1 si semaine prochaine etc*/
        $db_handle = mysqli_connect('localhost', 'root', '' );
        $db_found = mysqli_select_db($db_handle, 'medicare');

        if ($db_found) { 

            $retourRequete=mysqli_query($db_handle,"SELECT * FROM Utilisateur U LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin WHERE U.Id_User = '$idMedecin'");
            $resultat = mysqli_fetch_assoc($retourRequete);

            $week=array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");  /*déclaration des variables dont je vais avoir besoin pour l'affichage et la génération des requêtes*/
            $moments= array("Matin","Après-midi");
            $jours=array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
            $heuresMatin=array("08H30","09H00","09H30","10H00","10H30","11H00","11H30");
            $heuresAprem=array("13H00","13h30","14h00","14h30","15h00","15H30","16H00");
            $heuresJour =array($heuresMatin,$heuresAprem);   

            $datesSemaine=datesSemaine($decallage);
        

            $idJour=0;
            $idMoment=0;

            echo("Disponibilités de ".$resultat['Prenom']." ".$resultat['Nom']."</br>");

            echo("<table>");
            echo("<tr>");
        
            for($i=0;$i<6;$i++){
                echo("<td> ".$jours[$i]." ".$datesSemaine[$i]."</td>");
            }
            /*foreach($jours as $jour){
                echo("<td> ".$jour." </td>");
            }*/
            echo("</tr>");
            foreach($heuresJour as $heures){
                foreach($heures as $heure){
                echo("<tr>");
                    foreach($jours as $jour){
                        if(!($resultat["Disponibilite"][$idJour*2+$idMoment])){
                            echo("<td><input type='button' value='Indisponnible'</td>");
                        }
                        else{
                            echo("<td><input type='button' value='$heure'</td>");
                        }
                        $idJour=fmod($idJour+1,6);
                    }
                echo("</tr>");
                }
                $idMoment=fmod($idMoment+1,2);
            }
            echo("</table>");



        }
        else{
            echo("Base de données non trouvée");
        }    

        mysqli_close($db_handle);
    }
    ?>
</head>
<body>
    <?php
        $decallage = 0; // Initialisation de la variable

    // Vérifie si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Vérifie si le bouton 'incrémenter' a été cliqué
        if (isset($_POST['incrementer'])) {
            $decallage = $_POST['decallage'] + 1;
        }

        // Vérifie si le bouton 'décrémenter' a été cliqué
        if (isset($_POST['decrementer'])) {
            $decallage = $_POST['decallage'] - 1;
        }
    }

    // Appel de la fonction tableauRdv
    tableauRdv(5, $decallage);
    ?>
    </br>
    <form method="post">
        <input type="submit" name="incrementer" value="Semaine précédente">
        <input type="submit" name="decrementer" value="Semaine suivante">
    </form>
</body>

</body>



