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
    $doctor_id = $_POST['ID'];
    $name = $_POST['Name'];
    $prenom = $_POST['Prenom'];
    $field = $_POST['Field'];
    $city = $_POST['City'];
    $video = $_POST['Video'];


    // Disponibilité Même fonctionnement que lors de l'ajout
    $disponibilite = str_repeat('0', 12);
    if (isset($_POST['availability']) && is_array($_POST['availability'])) {
        foreach ($_POST['availability'] as $index => $value) {
            if ($value == 'on') {
                $disponibilite[(int)$index] = '1';
            }
        }
    }

    // Récupérer les informations actuelles du médecin
    $sql = "SELECT Photo, Photo2, Photo3 FROM Medecin WHERE Id_Medecin = $doctor_id";
    $result = $conn->query($sql);
    $doctor = $result->fetch_assoc();

    // Traiter les fichiers uploadés
    $photo1 = $doctor['Photo'];
    $photo2 = $doctor['Photo2'];
    $photo3 = $doctor['Photo3'];

    /*
     * https://stackoverflow.com/questions/18929178/move-uploaded-file-function-is-not-working
     * https://www.tutorialspoint.com/php/php_function_move_uploaded_file.html
     * https://sebhastian.com/php-moveuploadedfile/
     */
    if ($_FILES['Picture1']['error'] == UPLOAD_ERR_OK) {
        $photo1 = 'uploads/' . basename($_FILES['Picture1']['name']);
        move_uploaded_file($_FILES['Picture1']['tmp_name'], $photo1);
    }
    if ($_FILES['Picture2']['error'] == UPLOAD_ERR_OK) {
        $photo2 = 'uploads/' . basename($_FILES['Picture2']['name']);
        move_uploaded_file($_FILES['Picture2']['tmp_name'], $photo2);
    }
    if ($_FILES['Picture3']['error'] == UPLOAD_ERR_OK) {
        $photo3 = 'uploads/' . basename($_FILES['Picture3']['name']);
        move_uploaded_file($_FILES['Picture3']['tmp_name'], $photo3);
    }

    // Mettre à jour les informations du médecin
    $sql = "UPDATE Utilisateur 
            SET Nom='$name', Prenom='$prenom', Ville='$city'
            WHERE Id_User='$doctor_id'";
    $conn->query($sql);

    $sql = "UPDATE Medecin 
            SET Specialite='$field', Disponibilite='$disponibilite', Photo='$photo1', Photo2='$photo2', Photo3='$photo3', video='$video'
            WHERE Id_Medecin='$doctor_id'";
    $conn->query($sql);

    header("Location: administrateur.php");
    exit();
}

// Fermer la connexion
$conn->close();
?>
