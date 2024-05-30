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
$doctor_id = $_GET['doctor_id'];
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
    <title>Modifier un Médecin</title>
    <script type="text/javascript">

        /*
        https://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded
         */
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const reader = new FileReader();

            reader.onload = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }

        function previewYouTubeVideo(event, previewId) {
            const url = event.target.value;
            const preview = document.getElementById(previewId);
            const youtubePattern = /^https:\/\/www\.youtube\.com\/watch\?v=([\w-]+)$/;//Vérifie que le pattern est bon
            const match = url.match(youtubePattern);//Extrait l'ID de la vidéo

            if (match && match[1]) {//Si l'id est existe et qu'il est valide
                const videoId = match[1];
                preview.src = `https://www.youtube.com/embed/${videoId}`;
                preview.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
        }

        .Container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            width: 100%;
            max-width: 800px;
        }

        .FormRow {
            display: flex;
            justify-content: space-between;
            width: 100%;
            gap: 10px;
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

        .FormElement input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 16px;
        }

        label {
            cursor: pointer;
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

        #AddDoctorButton {
            background-color: #28a745;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            text-align: center;
        }

        #AddDoctorButton:hover {
            opacity: 0.9;
        }

        .PreviewImg {
            display: none;
            max-width: 100%;
            max-height: 50px;
        }

        .PreviewVideo {
            display: none;
            max-width: 100%;
            max-height: 200px;
        }
    </style>
</head>
<body>
<form action="UpdateDoctorBDD.php" method="POST" enctype="multipart/form-data">
    <div class="Container">
        <div class="FormRow">
            <div class="Form">
                <h2>Informations du Médecin</h2>
                <div class="FormElement">
                    <label for="ID">ID</label>
                    <input type="text" id="ID" name="ID" value="<?php echo $doctor['Id_User']; ?>" required readonly><!--On ne veut pas modifier l'ID-->
                </div>
                <div class="FormElement">
                    <label for="Name">Nom:</label>
                    <input type="text" id="Name" name="Name" value="<?php echo $doctor['Nom']; ?>" required>
                </div>
                <div class="FormElement">
                    <label for="Prenom">Prénom:</label>
                    <input type="text" id="Prenom" name="Prenom" value="<?php echo $doctor['Prenom']; ?>" required>
                </div>
                <div class="FormElement">
                    <label for="Field">Spécialité</label>
                    <input type="text" id="Field" name="Field" value="<?php echo $doctor['Specialite']; ?>" required>
                </div>
                <div class="FormElement">
                    <label for="City">Ville:</label>
                    <input type="text" id="City" name="City" value="<?php echo $doctor['Ville']; ?>" required>
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
                        <?php /* Meme système que l'affichage*/
                        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                        for ($i = 0; $i < count($days); $i++) {
                            $morning_index = $i * 2;
                            $afternoon_index = $i * 2 + 1;
                            echo "<tr>";
                            echo "<td>$days[$i]</td>";
                            echo "<td><input type='checkbox' name='availability[$morning_index]' " . ($disponibilite[$morning_index] == '1' ? "checked" : "") . "></td>";
                            echo "<td><input type='checkbox' name='availability[$afternoon_index]' " . ($disponibilite[$afternoon_index] == '1' ? "checked" : "") . "></td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="FormRow">
            <div class="Form">
                <h2>Informations supplémentaires</h2>
                <div class="FormElement">
                    <label for="Picture1">Photo1:</label>
                    <input type="file" id="Picture1" name="Picture1" onchange="previewImage(event, 'preview1')">
                    <img class="PreviewImg" id="preview1" src="<?php echo $doctor['Photo']; ?>" alt="Image Preview"
                         style="display:block;">
                </div>
                <div class="FormElement">
                    <label for="Picture2">Photo2:</label>
                    <input type="file" id="Picture2" name="Picture2" onchange="previewImage(event, 'preview2')">
                    <img class="PreviewImg" id="preview2" src="<?php echo $doctor['Photo2']; ?>" alt="Image Preview"
                         style="display:block;">
                </div>
                <div class="FormElement">
                    <label for="Picture3">Photo3:</label>
                    <input type="file" id="Picture3" name="Picture3"
                           onchange="previewImage(event, 'preview3')">
                    <img class="PreviewImg" id="preview3" src="<?php echo $doctor['Photo3']; ?>" alt="Image Preview"
                         style="display:block;">
                </div>
                <div class="FormElement">
                    <label for="Video">Vidéo YouTube:</label>
                    <input type="url" id="Video" name="Video" value="<?php echo $doctor['video']; ?>"
                           placeholder="https://www.youtube.com/watch?v=example" required
                           oninput="previewYouTubeVideo(event, 'youtubePreview')">
                </div>
                <div class="FormElement">
                    <iframe class="PreviewVideo" id="youtubePreview"
                            src="https://www.youtube.com/embed/<?php echo $doctor['video']; ?>" allowfullscreen
                            style="display:block; width: 560px; height: 315px;"></iframe>
                </div>
                <div class="FormElement">
                    <label for="CV">CV</label>
                    <input type="file" id="CV" name="CV" accept=".xml,application/xml">
                </div>
                <div class="FormElement">
                    <button type="submit" id="AddDoctorButton">Mettre à jour le médecin</button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>

