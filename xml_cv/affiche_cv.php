<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CV du Médecin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .cv-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
            position: relative;
        }
        .photo-container {
            position: absolute;
            top: 20px;
            right: 20px;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            padding: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .photo-container img {
            border-radius: 8px;
            width: 150px; 
            height: auto;
        }
        h1, h2 {
            color: #333;
        }
        h1 {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        p {
            line-height: 1.6;
        }
        .section {
            margin-bottom: 20px;
        }
        .section ul {
            list-style-type: none;
            padding: 0;
        }
        .section li {
            margin-bottom: 10px;
        }
        .section-title {
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="cv-container">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medecin_id = intval($_POST['medecin_id']);

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "medicare";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT CV, Photo FROM medecin WHERE Id_Medecin = $medecin_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $xmlFilePath = $row['CV'];
        $photoPath = $row['Photo'];

        if (file_exists($xmlFilePath)) {
            $xml = simplexml_load_file($xmlFilePath);
            if ($xml === false) {
                echo "<p>Failed to load XML file.</p>";
            } else {
                // Display the photo
                echo "<div class='photo-container'><img src='$photoPath' alt='Photo du médecin'></div>";

                echo "<h1>CV de " . $xml->Prenom . " " . $xml->Nom . "</h1>";
                echo "<p><strong>Spécialité :</strong> " . $xml->Specialite . "</p>";

                // Formations
                echo "<div class='section'>";
                echo "<h2>Formations</h2>";
                foreach ($xml->CV->Formations->Formation as $formation) {
                    echo "<p><strong>" . $formation->Diplome . "</strong> - " . $formation->Etablissement . " (" . $formation->Annee . ")</p>";
                }
                echo "</div>";

                // Expériences
                echo "<div class='section'>";
                echo "<h2>Expériences</h2>";
                foreach ($xml->CV->Experiences->Experience as $experience) {
                    echo "<p><strong>" . $experience->Poste . "</strong> - " . $experience->Lieu . " (" . $experience->Duree . ")</p>";
                    echo "<p>" . $experience->Description . "</p>";
                }
                echo "</div>";

                // Publications
                echo "<div class='section'>";
                echo "<h2>Publications</h2>";
                foreach ($xml->CV->Publications->Publication as $publication) {
                    echo "<p><strong>" . $publication->Titre . "</strong> - " . $publication->Journal . " (" . $publication->Annee . ")</p>";
                }
                echo "</div>";

                // Distinctions
                echo "<div class='section'>";
                echo "<h2>Distinctions</h2>";
                foreach ($xml->CV->Distinctions->Distinction as $distinction) {
                    echo "<p><strong>" . $distinction->Titre . "</strong> (" . $distinction->Annee . ")</p>";
                    echo "<p>" . $distinction->Description . "</p>";
                }
                echo "</div>";

                // Compétences
                echo "<div class='section'>";
                echo "<h2>Compétences</h2>";
                echo "<ul>";
                foreach ($xml->CV->Competences->Competence as $competence) {
                    echo "<li>" . $competence . "</li>";
                }
                echo "</ul>";
                echo "</div>";

                // Langues
                echo "<div class='section'>";
                echo "<h2>Langues</h2>";
                echo "<ul>";
                foreach ($xml->CV->Langues->Langue as $langue) {
                    echo "<li><strong>" . $langue->Nom . ":</strong> " . $langue->Niveau . "</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
        } else {
            echo "<p>Le fichier XML n'existe pas.</p>";
        }
    } else {
        echo "<p>Médecin introuvable.</p>";
    }

    $conn->close();
} else {
    echo "<p>Méthode de requête invalide.</p>";
}
?>
</div>
</body>
</html>
