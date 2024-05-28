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

// Obtenir la requête de recherche
$query = $_GET['query'];

// Échapper la requête pour éviter les injections SQL
$query = $conn->real_escape_string($query);

// Passer la requête en minuscule
$query = strtolower($query);

// Requête SQL pour rechercher dans les tables Utilisateur, Medecin, ServiceLab et Laboratoire
$sql = "
    SELECT 'Medecin' AS Type, u.Nom, u.Prenom, m.Specialite, m.Bureau 
    FROM Utilisateur u 
    JOIN Medecin m ON u.Id_User = m.Id_Medecin 
    WHERE LOWER(u.Nom) LIKE '%$query%' OR LOWER(u.Prenom) LIKE '%$query%' OR LOWER(m.Specialite) LIKE '%$query%'
    UNION
    SELECT 'Service' AS Type, NULL AS Nom, NULL AS Prenom, s.Nom_Service AS Specialite, s.Description_Service AS Bureau 
    FROM ServiceLab s
    WHERE LOWER(s.Nom_Service) LIKE '%$query%'
    UNION
    SELECT 'Laboratoire' AS Type, NULL AS Nom, NULL AS Prenom, l.Nom AS Specialite, CONCAT('Salle: ', l.Salle, ', Téléphone: ', l.Telephone, ', Email: ', l.Email, ', Adresse: ', l.Adresse) AS Bureau 
    FROM Laboratoire l
    WHERE LOWER(l.Nom) LIKE '%$query%' OR LOWER(l.Adresse) LIKE '%$query%'
";

// Exécuter la requête
$result = $conn->query($sql);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
    echo "<h1>Résultats de la recherche pour '$query':</h1>";
    echo "<ul>";
    // Afficher les résultats
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        if ($row['Type'] == 'Medecin') {
            echo "Médecin: " . $row['Nom'] . " " . $row['Prenom'] . " - Spécialité: " . $row['Specialite'] . " - Bureau: " . $row['Bureau'];
        } elseif ($row['Type'] == 'Service') {
            echo "Service: " . $row['Specialite'] . " - Description: " . $row['Bureau'];
        } elseif ($row['Type'] == 'Laboratoire') {
            echo "Laboratoire: " . $row['Specialite'] . " - " . $row['Bureau'];
        }
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Aucun résultat trouvé pour '$query'";
}

// Fermer la connexion
$conn->close();
?>
