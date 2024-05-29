<?php
// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "medicare";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Mettre à jour les données si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mettre à jour les données du laboratoire
    if (isset($_POST['update_lab'])) {
        $id_lab = $_POST['id_lab'];
        $salle = $_POST['salle'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];

        $updateLabQuery = $conn->prepare("UPDATE Laboratoire SET Salle = ?, Telephone = ?, Email = ?, Nom = ?, Adresse = ? WHERE Id_Lab = ?");
        $updateLabQuery->execute([$salle, $telephone, $email, $nom, $adresse, $id_lab]);
        
        echo "Les données du laboratoire ont été mises à jour avec succès.";
    }

    // Mettre à jour les données du service
    if (isset($_POST['update_service'])) {
        $nom_service = $_POST['nom_service'];
        $description_service = $_POST['description_service'];

        $updateServiceQuery = $conn->prepare("UPDATE ServiceLab SET Description_Service = ? WHERE Nom_Service = ?");
        $updateServiceQuery->execute([$description_service, $nom_service]);

        echo "Les données du service ont été mises à jour avec succès.";
    }
}

// Sélectionner les données actuelles
$labQuery = $conn->query("SELECT * FROM Laboratoire");
$laboratoires = $labQuery->fetchAll(PDO::FETCH_ASSOC);

$serviceQuery = $conn->query("SELECT * FROM ServiceLab");
$services = $serviceQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les données</title>
</head>
<body>
    <h1>Modifier les données du Laboratoire</h1>
    <table border="1">
        <tr>
            <th>Id</th>
            <th>Salle</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($laboratoires as $lab): ?>
        <tr>
            <form method="POST" action="">
                <td><input type="text" name="id_lab" value="<?php echo $lab['Id_Lab']; ?>" readonly></td>
                <td><input type="text" name="salle" value="<?php echo $lab['Salle']; ?>"></td>
                <td><input type="text" name="telephone" value="<?php echo $lab['Telephone']; ?>"></td>
                <td><input type="email" name="email" value="<?php echo $lab['Email']; ?>"></td>
                <td><input type="text" name="nom" value="<?php echo $lab['Nom']; ?>"></td>
                <td><input type="text" name="adresse" value="<?php echo $lab['Adresse']; ?>"></td>
                <td>
                    <input type="hidden" name="update_lab" value="1">
                    <input type="submit" value="Mettre à jour">
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <h1>Modifier les données du Service</h1>
    <table border="1">
        <tr>
            <th>Nom Service</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($services as $service): ?>
        <tr>
            <form method="POST" action="">
                <td><input type="text" name="nom_service" value="<?php echo $service['Nom_Service']; ?>" readonly></td>
                <td><input type="text" name="description_service" value="<?php echo $service['Description_Service']; ?>"></td>
                <td>
                    <input type="hidden" name="update_service" value="1">
                    <input type="submit" value="Mettre à jour">
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
