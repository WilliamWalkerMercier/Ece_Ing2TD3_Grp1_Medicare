<?php
// Configurer la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicare";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Si le formulaire de mise à jour est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Si le formulaire de suppression est soumis
    if (isset($_POST['delete_doctor'])) {
        $doctor_id = $_POST['doctor_id'];
        // Supprimer le docteur de la table Medecin
        $conn->query("DELETE FROM Medecin WHERE Id_Medecin = $doctor_id");

        //Met à jour le type de l'utilisateur , notamment pour l'affichage
        $conn->query("UPDATE Utilisateur SET Type = 2 WHERE Id_User = $doctor_id");
    }
}

// Obtenir tous les utilisateurs et toutes les informations liées aux utilisateurs
$sql = "SELECT U.*, M.Specialite, M.CV, M.Disponibilite, M.Bureau, M.Photo, M.Photo2, M.Photo3, M.Video
        FROM Utilisateur U 
        LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin";
$result = $conn->query($sql);


/*
    Chemin d'accès pour les photos à changer pour mettre tout au même endroit (à voir plus tard)



*/
?>


/* */

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Utilisateurs - Medicare</title>
    <link rel="stylesheet" href="../../ListeMedecinStyle.css"> <!-- Lien vers le fichier CSS -->
    <script>
        function changePhoto(event) {/*
        Source :https://stackoverflow.com/questions/7723188/what-properties-can-i-use-with-event-target
        */
            const photos = event.target.dataset.photos.split(',');//Convertit la chaine en un tableau de photo et recupere les informations de l'évenement declencheur
            let currentPhotoIndex = parseInt(event.target.dataset.currentIndex, 10);//Recupère l'index de la photo affichée
            currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;//Remet à 0 l'index si il dépasse le nombre d'image
            event.target.src = photos[currentPhotoIndex];//Change la source de la balise tag
            event.target.dataset.currentIndex = currentPhotoIndex.toString();//Remet à jour l'indice de la photo
        }
    </script>
</head>
<body>
<header>
    <h1>Détails des Utilisateurs</h1>
</header>

<div class="DoctorContainer">
    <?php
    if ($result->num_rows > 0) {//Vérifie qu'il y a des utilisateurs
        /*
         * https://www.w3schools.com/Php/func_mysqli_num_rows.asp
         */
        while ($row = $result->fetch_assoc()) {//Tant qu'il y a des informations
            $vIsMedecin = $row['Type'] == 1;//Regarde si l'utilisateur est un médecin ou non
            $vTitle = $vIsMedecin ? "Dr. " : "";//Met à jour son titre pour afficher Dr devant le nom ou pas
            $vPhoto = $row['Photo'] ?: 'default.jpg';//Recupere la premier photo ou affiche celle par défaut
            $vPhoto2 = $row['Photo2'] ?: '';
            $vPhoto3 = $row['Photo3'] ?: '';
            /*
             * https://www.w3schools.com/Php/func_array_filter.asp
             * https://www.w3schools.com/php/func_string_implode.asp
             * https://www.w3schools.com/php/func_string_htmlspecialchars.asp
             */
            $vPhotos = array_filter([$vPhoto, $vPhoto2, $vPhoto3]); // Contient uniquement les valeurs non nulles
            $vPhotosJavascript = implode(',', array_map(function ($p) {return htmlspecialchars($p);}, $vPhotos));//Parcourt toute la liste et convertit les charactères spéciaux en html car
            $vDisponibilite = isset($row['Disponibilite']) && strlen($row['Disponibilite']) == 12 ? str_split($row['Disponibilite']) : array_fill(0, 12, '0');//Vérifie que la chaine de disponibilité fait bien 12 caractères et l'initialise à 0

            echo "<div class='DoctorElement'>";
            /*
             * https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dataset
             * https://www.w3schools.com/tags/att_data-.asp
             * */
            echo "<img src='$vPhoto' alt='Photo de {$row['Nom']} {$row['Prenom']}' class='DoctorPicture' data-photos='$vPhotosJavascript' data-current-index='0' onclick='changePhoto(event)'>";
            echo "<div class='DoctorInfo'>";
            echo "<h2>$vTitle{$row['Prenom']} {$row['Nom']}</h2>";
            echo "<p><strong>ID:</strong> {$row['Id_User']}</p>";
            echo "<p><strong>Bureau :</strong> {$row['Bureau']}</p>";
            echo "<p><strong>Téléphone :</strong> {$row['Telephone']}</p>";
            echo "<p><strong>Courriel :</strong> {$row['Mail']}</p>";

            if ($vIsMedecin) {
                if (!empty($row['video'])) {//Si une vidéo est bien présente
                    echo "<p><strong><a href='{$row['video']}' target='_blank'>Vidéo</a></strong></p>";
                }
                echo "<h3>Disponibilités</h3>";
                echo "<div class='AvailabilityCalendar'>";
                $tDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                foreach ($tDays as $i => $day) {
                    $morning_index = $i * 2;
                    $afternoon_index = $i * 2 + 1;
                    echo "<div class='day'>$day</div>";
                    echo "<div class='slot " . (isset($vDisponibilite[$morning_index]) && $vDisponibilite[$morning_index] == '1' ? "" : "unavailable") . "'>Matin</div>";//Définit en fonction de la disponibilité
                    echo "<div class='slot " . (isset($vDisponibilite[$afternoon_index]) && $vDisponibilite[$afternoon_index] == '1' ? "" : "unavailable") . "'>Après-midi</div>";
                }
                echo "</div>";

                //Boutton pour les docteurs uniquement
                echo "<div class='DoctorButtons'>";
                echo "<form action='AddDoctor.html' method='GET' '>";
                echo "<button type='submit' class='AddDoctorButton'>Ajouter un docteur</button>";
                echo "</form>";

                //Envoie l'id de l'user à modifié
                echo "<form action='ModifyDoctor.php' method='GET''>";
                echo "<input type='hidden' name='doctor_id' value='{$row['Id_User']}'>";
                echo "<button type='submit' class='ModifyDoctorButton'>Modifier le docteur</button>";
                echo "</form>";

                //Bouton de supression
                echo "<form method='POST' class='DeleteDoctorForm'>";
                echo "<input type='hidden' name='doctor_id' value='{$row['Id_User']}'>";
                echo "<button type='submit' name='delete_doctor' class=\"EraseDoctorButton\">Supprimer le docteur</button>";
                echo "</form>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>Aucun utilisateur trouvé</p>";
    }
    ?>
</div>

</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
