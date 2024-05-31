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
    SELECT 'Medecin' AS Type, u.Id_User AS Id, u.Nom, u.Prenom, u.Telephone, u.Mail, m.Specialite, m.Bureau, m.Photo, m.Disponibilite AS Disponibilite 
    FROM Utilisateur u 
    JOIN Medecin m ON u.Id_User = m.Id_Medecin 
    WHERE LOWER(u.Nom) LIKE '%$query%' OR LOWER(u.Prenom) LIKE '%$query%' OR LOWER(m.Specialite) LIKE '%$query%'
    UNION
    SELECT 'Service' AS Type, s.Nom_Service AS Id, NULL AS Nom, NULL AS Prenom, NULL AS Telephone, NULL AS Mail, s.Nom_Service AS Specialite, s.Description_Service AS Bureau, s.Photo, NULL AS Disponibilite 
    FROM ServiceLab s
    WHERE LOWER(s.Nom_Service) LIKE '%$query%'
    UNION
    SELECT 'Laboratoire' AS Type, l.Id_Lab AS Id, NULL AS Nom, NULL AS Prenom, l.Telephone AS Telephone, l.Email AS Mail, l.Nom AS Specialite, CONCAT('Salle: ', l.Salle, ', Téléphone: ', l.Telephone, ', Email: ', l.Email, ', Adresse: ', l.Adresse) AS Bureau, l.Photo, NULL AS Disponibilite 
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
            echo "Médecin (ID: " . $row['Id'] . "): " . $row['Nom'] . " " . $row['Prenom'] . " - Spécialité: " . $row['Specialite'] . " - Bureau: " . $row['Bureau'];
            echo " - Téléphone: " . $row['Telephone'] . " - Email: " . $row['Mail'];
            echo " - Disponibilité: " . $row['Disponibilite'];
            echo " - <img src='" . $row['Photo'] . "' alt='Photo de " . $row['Nom'] . "' width='100'>";
        } elseif ($row['Type'] == 'Service') {
            echo "Service (ID: " . $row['Id'] . "): " . $row['Specialite'] . " - Description: " . $row['Bureau'];
            echo " - <img src='" . $row['Photo'] . "' alt='Photo du service " . $row['Specialite'] . "' width='100'>";
        } elseif ($row['Type'] == 'Laboratoire') {
            echo "Laboratoire (ID: " . $row['Id'] . "): " . $row['Specialite'] . " - " . $row['Bureau'];
            echo " - <img src='" . $row['Photo'] . "' alt='Photo du laboratoire " . $row['Specialite'] . "' width='100'>";
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
