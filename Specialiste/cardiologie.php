<?php
// Connexion à la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "mysql";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$specialite = "Cardiologie";

$sql = "SELECT medecin.*, utilisateur.Nom, utilisateur.Prenom, utilisateur.Mail, utilisateur.Telephone FROM medecin 
        JOIN utilisateur ON medecin.Id_Medecin = utilisateur.Id_User
        WHERE Specialite = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $specialite);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h1>Médecins en Cardiologie</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<h2>Médecin: " . $row["Prenom"] . " " . $row["Nom"] . "</h2>";
        echo "CV: " . $row["CV"] . "<br>";
        echo "Disponibilité: " . $row["Disponibilite"] . "<br>";
        echo "Bureau: " . $row["Bureau"] . "<br>";
        echo "Photo: <img src='" . $row["Photo"] . "' alt='Photo de " . $row["Nom"] . "'><br>";
        echo "Email: " . $row["Mail"] . "<br>";
        echo "Téléphone: " . $row["Telephone"] . "<br>";
    }
} else {
    echo "Aucun médecin en cardiologie trouvé.";
}

$stmt->close();
$conn->close();
?>
