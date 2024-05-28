<?php
// Configurer la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "mysql";
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
$sql = "SELECT * FROM Utilisateur";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Utilisateurs</title>
    <script>
        function toggleForm(userId, isChecked, isInitial) {
            var formDiv = document.getElementById('form_' + userId);
            if (isChecked && !isInitial) {
                formDiv.style.display = 'block';
            } else {
                formDiv.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <h1>Liste des Utilisateurs</h1>
    <form method="post" action="">
        <input type="hidden" name="update_users" value="1">
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Type</th>
                <th>Est Médecin</th>
                <th>Informations Médecin</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $is_medecin = $row['Type'] == 1;
                    echo "<tr>";
                    echo "<td>" . $row['Nom'] . "</td>";
                    echo "<td>" . $row['Prenom'] . "</td>";
                    echo "<td>" . $row['Mail'] . "</td>";
                    echo "<td>" . ($is_medecin ? 'Médecin' : 'Client') . "</td>";
                    echo "<td><input type='checkbox' name='user_ids[]' value='" . $row['Id_User'] . "' " . ($is_medecin ? 'checked' : '') . " onchange='toggleForm(" . $row['Id_User'] . ", this.checked, false)'></td>";
                    echo "<td>";
                    if (!$is_medecin) {
                        echo "<div id='form_" . $row['Id_User'] . "' style='display: none;'>";
                        echo "<input type='hidden' name='new_medecin_" . $row['Id_User'] . "' value='1'>";
                        echo "Spécialité: <input type='text' name='specialite_" . $row['Id_User'] . "'><br>";
                        echo "CV: <input type='text' name='cv_" . $row['Id_User'] . "'><br>";
                        echo "Disponibilité: <input type='text' name='disponibilite_" . $row['Id_User'] . "'><br>";
                        echo "Bureau: <input type='text' name='bureau_" . $row['Id_User'] . "'><br>";
                        echo "Photo: <input type='text' name='photo_" . $row['Id_User'] . "'><br>";
                        echo "</div>";
                    }
                    echo "</td>";
                    echo "<input type='hidden' name='all_user_ids[]' value='" . $row['Id_User'] . "'>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucun utilisateur trouvé</td></tr>";
            }
            ?>
        </table>
        <br>
        <input type="submit" value="Mettre à jour">
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if ($result->num_rows > 0) {
                $result->data_seek(0);
                while($row = $result->fetch_assoc()) {
                    if ($row['Type'] == 1) {
                        echo "toggleForm(" . $row['Id_User'] . ", true, true);";
                    }
                }
            }
            ?>
        });
    </script>
</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
