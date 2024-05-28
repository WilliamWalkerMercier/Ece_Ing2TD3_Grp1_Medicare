!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de créneau - Medicare</title>

    <?php
            
        $db_handle = mysqli_connect('localhost', 'root', '' );
        $db_found = mysqli_select_db($db_handle, 'medicare');

        $week=array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");  
        $moments= array("Matin","Après-midi");
        $jours=array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
        $heuresMatin=array("08H30","09H00","09H30","10H00","10H30","11H00","11H30");
        $heuresAprem=array("13H00","13h30","14h00","14h30","15h00","15H30","16H00");
        $heuresJour =array($heuresMatin,$heuresAprem);
        if ($db_found) {    
            echo("<table>");
            echo("<tr>");
            foreach($jours as $jour){
                echo("<td> ".$jour." </td>");
            }
            echo("</tr>");
            foreach($heuresJour as $heures){
                echo("<tr>");
                foreach($heures as $heure){
                    foreach($jours as $jour){
                        echo("<td><input type='buton' value='$heure'</td>");
                    }
                }
                echo("</tr>");
            }



        }
        else{
            echo("Base de données non trouvée");
        }    

        mysqli_close($db_handle);

    ?>
</head>


$mondayThisWeek = new DateTimeImmutable("monday this week");
    echo $mondayThisWeek->format("Y-m-d"); // Affichera la date du lundi de cette semaine
