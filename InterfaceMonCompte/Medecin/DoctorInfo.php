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

// Obtenir les informations du médecin à partir de son ID
$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;
$sql = "SELECT U.*, M.Specialite, M.CV, M.Disponibilite, M.Bureau, M.Photo, M.Photo2, M.Photo3, M.video
        FROM Utilisateur U 
        LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin
        WHERE U.Id_User = $doctor_id";
$result = $conn->query($sql);
$doctor = $result->fetch_assoc();

// Initialiser la disponibilité
$disponibilite = isset($doctor['Disponibilite']) && strlen($doctor['Disponibilite']) == 12 ? str_split($doctor['Disponibilite']) : array_fill(0, 12, '0');

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher un Médecin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
            max-width: 800px;
        }
        .Form {
            display: flex;
            flex-direction: column;
            flex: 1;
            background-color: #ffffff;
            padding: 20px;
            gap: 10px;
            border-radius: 8px;
            text-align: left;
        }
        .Form h2 {
            color: #333333;
            margin-bottom: 10px;
            text-align: center;
        }
        .FormElement {
            margin-bottom: 15px;
        }
        .FormElement label {
            margin-bottom: 5px;
            color: #333333;
            display: block;
        }
        .FormElement input, .FormElement textarea {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 16px;
        }
        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            width: 95%;
            background-color: #ffffff;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #ffcccb;
        }
        tr:nth-child(even) {
            background-color: #add8e6;
        }
        .PreviewImg {
            display: block;
            max-width: 100%;
            max-height: 200px;
        }
        .PreviewVideo {
            display: block;
            max-width: 100%;
            max-height: 315px;
        }
    </style>
    <script type="text/javascript">
        // Fonction pour la preview des vidéos
        function previewYouTubeVideo(url, previewId) {
            const preview = document.getElementById(previewId);
            const youtubePattern = /^https:\/\/www\.youtube\.com\/watch\?v=([\w-]+)$/;
            const match = url.match(youtubePattern);

            if (match && match[1]) {
                const videoId = match[1];
                preview.src = `https://www.youtube.com/embed/${videoId}`;
                preview.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }

        // Fonction pour afficher l'image directement
        function displayImage(src, previewId) {
            const preview = document.getElementById(previewId);
            if (src) {
                preview.src = src;
                preview.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }

        // Fonction pour initialiser la prévisualisation des images et vidéos
        function initializePreviews() {
            displayImage('<?php echo $doctor['Photo']; ?>', 'preview1');
            displayImage('<?php echo $doctor['Photo2']; ?>', 'preview2');
            displayImage('<?php echo $doctor['Photo3']; ?>', 'preview3');
            previewYouTubeVideo('<?php echo $doctor['video']; ?>', 'youtubePreview');
        }

        // Initialiser les prévisualisations lorsque la page est chargée
        window.onload = initializePreviews;
    </script>
</head>
<body>
<div class="container">
    <div class="Form">
        <h2>Informations du Médecin</h2>
        <div class="FormElement">
            <label for="ID">ID</label>
            <input type="text" id="ID" name="ID" value="<?php echo $doctor['Id_User']; ?>" readonly>
        </div>
        <div class="FormElement">
            <label for="Name">Nom</label>
            <input type="text" id="Name" name="Name" value="<?php echo $doctor['Nom']; ?>" readonly>
        </div>
        <div class="FormElement">
            <label for="FirstName">Prénom</label>
            <input type="text" id="FirstName" name="Prenom" value="<?php echo $doctor['Prenom']; ?>" readonly>
        </div>
        <div class="FormElement">
            <label for="Field">Spécialité</label>
            <input type="text" id="Field" name="Field" value="<?php echo $doctor['Specialite']; ?>" readonly>
        </div>
        <div class="FormElement">
            <label for="City">Ville</label>
            <input type="text" id="City" name="City" value="<?php echo $doctor['Ville']; ?>" readonly>
        </div>
    </div>

    <div class="Form">
        <h2>Disponibilités</h2>
        <div class="FormElement">
            <table>
                <thead>
                <tr>
                    <th>Jour</th>
                    <th>Matin</th>
                    <th>Après-midi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                for ($i = 0; $i < count($days); $i++) {
                    $morning_index = $i * 2;
                    $afternoon_index = $i * 2 + 1;
                    echo "<tr>";
                    echo "<td>$days[$i]</td>";
                    echo "<td>" . ($disponibilite[$morning_index] == '1' ? "Disponible" : "Non disponible") . "</td>";
                    echo "<td>" . ($disponibilite[$afternoon_index] == '1' ? "Disponible" : "Non disponible") . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="Form">
        <h2>Informations supplémentaires</h2>
        <div class="FormElement">
            <label for="Picture1">Photo1:</label>
            <img class="PreviewImg" id="preview1" src="" alt="Image Preview">
        </div>
        <div class="FormElement">
            <label for="Picture2">Photo2:</label>
            <img class="PreviewImg" id="preview2" src="" alt="Image Preview">
        </div>
        <div class="FormElement">
            <label for="Picture3">Photo3:</label>
            <img class="PreviewImg" id="preview3" src="" alt="Image Preview">
        </div>
        <div class="FormElement">
            <label for="Video">Vidéo YouTube:</label>
            <iframe class="PreviewVideo" id="youtubePreview" src="" allowfullscreen></iframe>
        </div>
        <div class="FormElement">
            <label for="CV">CV</label>
            <textarea id="CV" name="CV"  readonly><?php echo $doctor['CV']; ?></textarea>
        </div>
    </div>
</div>
</body>
</html>
