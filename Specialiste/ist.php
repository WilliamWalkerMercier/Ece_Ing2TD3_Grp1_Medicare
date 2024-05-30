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
$specialite = "I.S.T.";

// Requête SQL pour récupérer les informations des médecins spécialisés en I.S.T.
$sql = "SELECT * FROM medecin WHERE Specialite = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $specialite);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Affichage des informations de chaque médecin spécialisé en I.S.T.
    echo "<h1>Médecins spécialisés en I.S.T. (Infections Sexuellement Transmissibles)</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<h2>Médecin: " . $row["Id_Medecin"] . "</h2>";
        echo "CV: " . $row["CV"] . "<br>";
        echo "Disponibilité: " . $row["Disponibilite"] . "<br>";
        echo "Bureau: " . $row["Bureau"] . "<br>";
        echo "Photo: " . $row["Photo"] . "<br>";
        echo "Photo2: " . $row["Photo2"] . "<br>";
        echo "Photo3: " . $row["Photo3"] . "<br>";
        echo "Video: " . $row["Video"] . "<br>";
    }
} else {
    echo "Aucun médecin spécialisé en I.S.T. (Infections Sexuellement Transmissibles) trouvé.";
}

$stmt->close();
$conn->close();
?>
