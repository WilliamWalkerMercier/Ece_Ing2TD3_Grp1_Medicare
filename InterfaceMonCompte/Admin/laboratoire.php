<?php
// Connexion à la base de données
$servername = "127.0.0.1";
$username = "root"; // Changez ceci en fonction de votre configuration
$password = ""; // Changez ceci en fonction de votre configuration
$dbname = "medicare";

// Créez une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer les informations des laboratoires
$sql = "SELECT * FROM Laboratoire";
$result = $conn->query($sql);

// Fonction pour afficher les informations des laboratoires
function afficherLaboratoires($result) {
    if ($result->num_rows > 0) {
        echo "<h1>Laboratoires</h1>";
        echo "<div class='DoctorContainer'>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='DoctorElement'>";
            echo "<h2>Laboratoire: " . $row["Id_Lab"] . "</h2>";
            echo "Nom: " . $row["Nom"] . "<br>";
            echo "Salle: " . $row["Salle"] . "<br>";
            echo "Téléphone: " . $row["Telephone"] . "<br>";
            echo "Email: " . $row["Email"] . "<br>";
            echo "Adresse: " . $row["Adresse"] . "<br>";
            echo "<img src='" . $row["Photo"] . "' alt='Photo du laboratoire' class='DoctorPicture'><br>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "Aucun laboratoire trouvé.";
    }
}

// Requête SQL pour récupérer les informations des services de laboratoire
$sql_services = "SELECT * FROM ServiceLab";
$result_services = $conn->query($sql_services);

// Fonction pour afficher les informations des services de laboratoire
function afficherServices($result_services) {
    if ($result_services->num_rows > 0) {
        echo "<h1>Services de Laboratoire</h1>";
        echo "<div class='DoctorContainer'>";
        while($row = $result_services->fetch_assoc()) {
            echo "<div class='DoctorElement'>";
            echo "<h2>Service: " . $row["Nom_Service"] . "</h2>";
            echo "Description: " . $row["Description_Service"] . "<br>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "Aucun service trouvé.";
    }
}

// Mettre à jour les données si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mettre à jour les données du laboratoire
    if (isset($_POST['update_lab'])) {
        $vIdLab = $_POST['id_lab'];
        $vSalle = $_POST['salle'];
        $vPhone = $_POST['telephone'];
        $vEmail = $_POST['email'];
        $vName = $_POST['nom'];
        $vAdresse = $_POST['adresse'];

        $updateLabQuery = $conn->prepare("UPDATE Laboratoire SET Salle = ?, Telephone = ?, Email = ?, Nom = ?, Adresse = ? WHERE Id_Lab = ?");
        $updateLabQuery->bind_param("sssssi", $vSalle, $vPhone, $vEmail, $vName, $vAdresse, $vIdLab);
        $updateLabQuery->execute();

        echo "Les données du laboratoire ont été mises à jour avec succès.";
        // Rediriger pour recharger la page et afficher les nouvelles données
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    // Mettre à jour les données du service
    if (isset($_POST['update_service'])) {
        $vNameService = $_POST['nom_service'];
        $vServiceDescription = $_POST['description_service'];

        $updateServiceQuery = $conn->prepare("UPDATE ServiceLab SET Description_Service = ? WHERE Nom_Service = ?");
        $updateServiceQuery->bind_param("ss", $vServiceDescription, $vNameService);
        $updateServiceQuery->execute();

        echo "Les données du service ont été mises à jour avec succès.";
        // Rediriger pour recharger la page et afficher les nouvelles données
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }

    // Ajouter un nouveau service
    if (isset($_POST['add_service'])) {
        $vNewServiceName = $_POST['new_nom_service'];
        $vNewServiceDescription = $_POST['new_description_service'];

        $addServiceQuery = $conn->prepare("INSERT INTO ServiceLab (Nom_Service, Description_Service) VALUES (?, ?)");
        $addServiceQuery->bind_param("ss", $vNewServiceName, $vNewServiceDescription);
        $addServiceQuery->execute();

        echo "Le nouveau service a été ajouté avec succès.";
        // Rediriger pour recharger la page et afficher les nouvelles données
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les données</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            background-color: #007bff;
            color: white;
            padding: 20px;
        }

        /* Conteneur de la grille pour les éléments */
        .DoctorContainer {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
            justify-items: center;
        }

        /* Éléments individuels */
        .DoctorElement {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        .DoctorElement img {
            border-radius: 8px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .DoctorInfo p {
            margin: 8px 0;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            font-size: 1em;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        img:hover {
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px ;
        }

        table, th, td {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            text-align: left;
        }

        input[type="text"], input[type="email"], input[type="submit"] {
            padding: 8px;
            margin: 4px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        .UpdateButton {
            background-color: #a21588;
            color: white;
            cursor: pointer;
        }

        .UpdateButton:hover, .AddButton:hover {
            opacity: 0.8;
        }

        .AddButton{
            background-color: #1fb601;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php
// Afficher les informations des laboratoires
afficherLaboratoires($result);

// Afficher les informations des services de laboratoire
afficherServices($result_services);
?>

<h1>Modifier les données du Laboratoire</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Salle</th>
        <th>Telephone</th>
        <th>Email</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Actions</th>
    </tr>
    <?php
    // Requête SQL pour récupérer les informations des laboratoires pour les formulaires de modification
    $labQuery = $conn->query("SELECT * FROM Laboratoire");
    while($lab = $labQuery->fetch_assoc()): ?>
        <tr>
            <?php echo '<form method="POST" action="">
                <td><input type="text" name="id_lab" value="' . $lab['Id_Lab'] . '" readonly></td>
                <td><input type="text" name="salle" value="' . $lab['Salle'] . '"></td>
                <td><input type="text" name="telephone" value="' . $lab['Telephone'] . '"></td>
                <td><input type="email" name="email" value="' . $lab['Email'] . '"></td>
                <td><input type="text" name="nom" value="' . $lab['Nom'] . '"></td>
                <td><input type="text" name="adresse" value="' . $lab['Adresse'] . '"></td>
                <td>
                    <input type="hidden" name="update_lab" value="1">
                    <input type="submit" value="Mettre à jour">
                </td>
            </form>'; ?>
        </tr>
    <?php endwhile; ?>
</table>

<h1>Modifier les données du Service</h1>
<table>
    <tr>
        <th>Nom Service</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>
    <?php
    // Requête SQL pour récupérer les informations des services pour les formulaires de modification
    $serviceQuery = $conn->query("SELECT * FROM ServiceLab");
    while($service = $serviceQuery->fetch_assoc()): ?>
        <tr>
            <?php echo '<form method="POST" action="">
                <td><input type="text" name="ServicenName" value="' . $service['Nom_Service'] . '"></td>
                <td><input type="text" name="ServiceDescription" value="' . $service['Description_Service'] . '"></td>
                <td>
                    <input type="hidden" name="UpdateService" value="1">
                    <input class="UpdateButton" type="submit" value="Mettre à jour">
                </td>
            </form>'; ?>
        </tr>
    <?php endwhile; ?>
</table>

<h1>Ajouter un nouveau service</h1>
<form method="POST" action="">
    <table>
        <tr>
            <!--<td>Nom du service:</td>-->
            <td>
                <label for="NewServiceName">Nouveau Service:
                    <input type="text" name="NewServiceName" required>
                </label></td>
        </tr>
        <tr>
            <td><label for="NewServiceDescription">Description:
                    <input type="text" name="NewServiceDescription" required>
                </label></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" name="add_service" value="1">
                <input class="AddButton" type="submit" value="Ajouter">
            </td>
        </tr>
    </table>
</form>
</body>
</html>

<?php
$conn->close();
?>