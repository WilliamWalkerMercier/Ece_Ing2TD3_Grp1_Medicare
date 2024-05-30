<?php
// Connexion à la base de données
$servername = "127.0.0.1";
$username = "root"; // Changez ceci en fonction de votre configuration
$password = "mysql"; // Changez ceci en fonction de votre configuration
$dbname = "medicare";

// Créez une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer les informations des laboratoires
$sql = "SELECT * FROM laboratoire";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Afficher les informations de chaque laboratoire
    echo "<h1>Laboratoires</h1>";
    while($row = $result->fetch_assoc()) {
        echo "<h2>Laboratoire: " . $row["Id_Lab"] . "</h2>";
        echo "Nom: " . $row["Nom"] . "<br>";
        echo "Salle: " . $row["Salle"] . "<br>";
        echo "Téléphone: " . $row["Telephone"] . "<br>";
        echo "Email: " . $row["Email"] . "<br>";
        echo "Adresse: " . $row["Adresse"] . "<br>";
        echo "Photo: " . $row["Photo"] . "<br>";
    }
} else {
    echo "Aucun laboratoire trouvé.";
}

$conn->close();
?>
