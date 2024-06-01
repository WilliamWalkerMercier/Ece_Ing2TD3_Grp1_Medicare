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
    $doctor_id = $conn->real_escape_string($_POST['ID']);
    $name = $conn->real_escape_string($_POST['Name']);
    $prenom = $conn->real_escape_string($_POST['Prenom']);
    $field = $conn->real_escape_string($_POST['Field']);
    $city = $conn->real_escape_string($_POST['City']);
    $videoURL = $conn->real_escape_string($_POST['Video']);



    // Disponibilité
    $disponibilite = str_repeat('0', 12);
    if (isset($_POST['availability']) && is_array($_POST['availability'])) {
        foreach ($_POST['availability'] as $index => $value) {
            if ($value == 'on') {
                $disponibilite[(int)$index] = '1';
            }
        }
    }

    // Traitement du CV
    $cv = '';
    if ($_FILES['CV']['error'] == UPLOAD_ERR_OK) {
        $cv = 'images/' . basename($_FILES['CV']['name']);
        move_uploaded_file($_FILES['CV']['tmp_name'], $cv);
    }

    // Récupérer les informations actuelles du médecin
    $sql = "SELECT Photo, Photo2, Photo3, CV FROM Medecin WHERE Id_Medecin = $doctor_id";
    $result = $conn->query($sql);
    $doctor = $result->fetch_assoc();

    // Traiter les fichiers uploadés
    $photo1 = $doctor['Photo'];
    $photo2 = $doctor['Photo2'];
    $photo3 = $doctor['Photo3'];

    if ($_FILES['Picture1']['error'] == UPLOAD_ERR_OK) {
        $photo1 = 'images/' . basename($_FILES['Picture1']['name']);
        move_uploaded_file($_FILES['Picture1']['tmp_name'], $photo1);
    }
    if ($_FILES['Picture2']['error'] == UPLOAD_ERR_OK) {
        $photo2 = 'images/' . basename($_FILES['Picture2']['name']);
        move_uploaded_file($_FILES['Picture2']['tmp_name'], $photo2);
    }
    if ($_FILES['Picture3']['error'] == UPLOAD_ERR_OK) {
        $photo3 = 'images/' . basename($_FILES['Picture3']['name']);
        move_uploaded_file($_FILES['Picture3']['tmp_name'], $photo3);
    }

    // Mettre à jour les informations du médecin
    $sql = "UPDATE Medecin 
            SET Specialite='$field', Disponibilite='$disponibilite', Photo='$photo1', Photo2='$photo2', Photo3='$photo3', Video='$videoURL', CV='$cv'
            WHERE Id_Medecin='$doctor_id'";
    $conn->query($sql);

    // Mettre à jour les informations utilisateur
    $sql = "UPDATE Utilisateur 
            SET Nom='$name', Prenom='$prenom', Ville='$city'
            WHERE Id_User='$doctor_id'";
    $conn->query($sql);

    // Redirection après mise à jour
    header("Location: administrateur.php");
    exit();
}

// Fermer la connexion
$conn->close();
?>
