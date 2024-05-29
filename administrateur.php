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
    if (isset($_POST['update_users'])) {
        $checked_users = isset($_POST['user_ids']) ? $_POST['user_ids'] : [];
        $all_users = isset($_POST['all_user_ids']) ? $_POST['all_user_ids'] : [];
        $checked_users_set = array_flip($checked_users);

        foreach ($all_users as $user_id) {
            if (isset($checked_users_set[$user_id])) {
                // Si l'utilisateur est coché, le rendre médecin (type = 1)
                $conn->query("UPDATE Utilisateur SET Type = 1 WHERE Id_User = $user_id");

                // Ajouter un médecin si les informations sont fournies
                if (isset($_POST["new_medecin_$user_id"])) {
                    $specialite = $conn->real_escape_string($_POST["specialite_$user_id"]);
                    $cv = $conn->real_escape_string($_POST["cv_$user_id"]);
                    $disponibilite = $conn->real_escape_string($_POST["disponibilite_$user_id"]);
                    $bureau = $conn->real_escape_string($_POST["bureau_$user_id"]);
                    $photo = $conn->real_escape_string($_POST["photo_$user_id"]);

                    // Ajouter un nouveau médecin
                    $conn->query("INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau, Photo) VALUES ($user_id, '$specialite', '$cv', '$disponibilite', '$bureau', '$photo')");
                }
            } else {
                // Si l'utilisateur est décoché, le rendre client (type = 2) et le supprimer de la table Medecin
                $conn->query("UPDATE Utilisateur SET Type = 2 WHERE Id_User = $user_id");
                $conn->query("DELETE FROM Medecin WHERE Id_Medecin = $user_id");
            }
        }
    }
}

// Obtenir tous les utilisateurs
$sql = "SELECT U.*, M.Specialite, M.CV, M.Disponibilite, M.Bureau, M.Photo 
        FROM Utilisateur U 
        LEFT JOIN Medecin M ON U.Id_User = M.Id_Medecin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Utilisateurs - Medicare</title>
    <link rel="stylesheet" href="ListeMedecinStyle.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>
<header>
    <h1>Détails des Utilisateurs</h1>
</header>

<div class="DoctorContainer">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $is_medecin = $row['Type'] == 1;
            $title = $is_medecin ? "Dr. " : "";
            $photo = $row['Photo'] ?: 'default.jpg';
            $disponibilite = isset($row['Disponibilite']) && strlen($row['Disponibilite']) == 12 ? str_split($row['Disponibilite']) : array_fill(0, 12, '0');

            echo "<div class='DoctorElement'>";
            echo "<img src='$photo' alt='Photo de {$row['Nom']} {$row['Prenom']}' class='DoctorPicture'>";
            echo "<div class='DoctorInfo'>";
            echo "<h2>$title{$row['Prenom']} {$row['Nom']}</h2>";
            echo "<p><strong>Bureau :</strong> {$row['Bureau']}</p>";
            echo "<p><strong>Téléphone :</strong> {$row['Telephone']}</p>";
            echo "<p><strong>Courriel :</strong> {$row['Mail']}</p>";
            if ($is_medecin) {
                echo "<h3>Disponibilités</h3>";
                echo "<div class='AvailabilityCalendar'>";
                $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                foreach ($days as $i => $day) {
                    $morning_index = $i * 2;
                    $afternoon_index = $i * 2 + 1;
                    echo "<div class='day'>$day</div>";
                    echo "<div class='slot " . (isset($disponibilite[$morning_index]) && $disponibilite[$morning_index] == '1' ? "" : "unavailable") . "'>Matin</div>";
                    echo "<div class='slot " . (isset($disponibilite[$afternoon_index]) && $disponibilite[$afternoon_index] == '1' ? "" : "unavailable") . "'>Après-midi</div>";
                }
                echo "</div>";
                echo "<div class='DoctorButtons'>";
                echo "<button class=\"AddDoctorButton\">Ajouter un docteur</button>";
                echo "<button class=\"ModifyDoctor\">Modifier le docteur</button>";
                echo "<button class=\"EraseDoctor\">Supprimer le docteur</button>";
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
