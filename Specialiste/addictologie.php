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

// Spécialité à rechercher
$specialite = "Addictologie";

// Requête SQL pour récupérer les informations des médecins spécialisés en addictologie
$sql = "SELECT medecin.*, utilisateur.Mail, utilisateur.Telephone FROM medecin 
        JOIN utilisateur ON medecin.Id_Medecin = utilisateur.Id_User
        WHERE Specialite = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $specialite);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Affichage des informations de chaque médecin spécialisé en addictologie
    echo "<h1>Médecins spécialisés en Addictologie</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<h2>Médecin: " . $row["Id_Medecin"] . "</h2>";
        echo "CV: " . $row["CV"] . "<br>";
        echo "Disponibilité: " . $row["Disponibilite"] . "<br>";
        echo "Bureau: " . $row["Bureau"] . "<br>";
        echo "Photo: <img src='" . $row["Photo"] . "' alt='Photo de " . $row["Id_Medecin"] . "'><br>";
        echo "Email: " . $row["Mail"] . "<br>";
        echo "Téléphone: " . $row["Telephone"] . "<br>";
    }
} else {
    echo "Aucun médecin spécialisé en Addictologie trouvé.";
}

$stmt->close();
$conn->close();
?>
