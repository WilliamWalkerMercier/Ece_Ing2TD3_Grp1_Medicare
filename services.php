<?php
// Connexion à la base de données
$servername = "127.0.0.1";
$username = "root"; // Changez ceci en fonction de votre configuration
$password = "mysql"; // Changez ceci en fonction de votre configuration
$dbname = "medicare";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer toutes les informations de la table servicelab
$sql = "SELECT * FROM servicelab";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Affichage des informations de chaque service
    echo "<h1>Liste des Services</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<h2>Nom du Service: " . $row["Nom_Service"] . "</h2>";
        echo "Description: " . $row["Description_Service"] . "<br>";
        echo "Photo: <img src='" . $row["Photo"] . "' alt='" . $row["Nom_Service"] . "'><br>";
        echo "Payant: " . ($row["Payant"] ? 'Oui' : 'Non') . "<br>";
    }
} else {
    echo "Aucun service trouvé.";
}

$conn->close();
?>
