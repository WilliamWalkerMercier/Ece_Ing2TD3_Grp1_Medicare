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

// Traitement des données du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $conn->real_escape_string($_POST['ID']);
    $name = $conn->real_escape_string($_POST['Name']);
    $field = $conn->real_escape_string($_POST['Field']);
    $city = $conn->real_escape_string($_POST['City']);

    // Disponibilité
    $disponibilite = str_repeat('0', 12);
    if (isset($_POST['availability']) && is_array($_POST['availability'])) {
        foreach ($_POST['availability'] as $index => $value) {
            if ($value == 'on') {
                $disponibilite[(int)$index] = '1';
            }
        }
    }

    // Téléchargement des fichiers
    $upload_dir = "images/";
    $upload_dir2 = "../../RechercheParcourir/images/";
    $upload_dirCV = "../../RechercheParcourir/";
    if (!is_dir($upload_dir)) {
       mkdir($upload_dir, 0777, true);
    }
    if (!is_dir($upload_dir2)) {
        mkdir($upload_dir2, 0777, true);
    }

    $files = ['Picture1', 'Picture2', 'Picture3'];
    $vXML = ['CV'];
    $file_paths = [];

    foreach ($files as $file) {
        if (isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
            $file_name = basename($_FILES[$file]['name']);
            $target_file = $upload_dir . $file_name;
            $second_target_file = $upload_dir2 . $file_name; // Chemin pour le deuxième répertoire

            // Déplacer le fichier vers le premier répertoire
            if (move_uploaded_file($_FILES[$file]['tmp_name'], $target_file)) {
                // Copier le fichier vers le deuxième répertoire
                copy($target_file, $second_target_file);
                $file_paths[$file] = $target_file; // Stocker le chemin du premier répertoire
            } else {
                echo "Échec du téléchargement de $file_name.<br>";
            }
        } else {
            echo "Aucun fichier $file téléchargé ou une erreur est survenue.<br>";
        }
    }

    foreach ($vXML as $prFile) {
        if (isset($_FILES[$prFile]) && $_FILES[$prFile]['error'] == 0) {
            $file_name = basename($_FILES[$prFile]['name']);
            $target_file = $upload_dirCV . $file_name;
            if (move_uploaded_file($_FILES[$prFile]['tmp_name'], $target_file)) {
                $file_paths[$prFile] = $file_name;
            } else {
                echo "Échec du téléchargement de $file_name.<br>";
            }
        } else {
            echo "Aucun fichier $file téléchargé ou une erreur est survenue.<br>";
        }
    }
    $YoutubeLink = isset($_POST['Video']) ? $_POST['Video'] : '';

    $photo1 = isset($file_paths['Picture1']) ? $file_paths['Picture1'] : '';
    $photo2 = isset($file_paths['Picture2']) ? $file_paths['Picture2'] : '';
    $photo3 = isset($file_paths['Picture3']) ? $file_paths['Picture3'] : '';
    $cv = isset($file_paths['CV']) ? $file_paths['CV'] : '';

    // Ajouter le médecin à la table Medecin
    $sql2 = "INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau, Photo, Photo2, Photo3, VIDEO) VALUES ('$id', '$field', '$cv', '$disponibilite', '$city', '$photo1', '$photo2', '$photo3', '$YoutubeLink')";

    $conn->query("UPDATE Utilisateur SET Type = 1 WHERE Id_User = $id");

    if ($conn->query($sql2) === TRUE) {
        echo "Nouveau médecin créé avec succès.<br>";
    } else {
        echo "Erreur : " . $sql2 . "<br>" . $conn->error;
    }

    // Rediriger vers la page des utilisateurs après l'ajout
    header("Location: administrateur.php"); // Utilisez le chemin relatif correct
    exit();
}

// Fermer la connexion
$conn->close();
?>
