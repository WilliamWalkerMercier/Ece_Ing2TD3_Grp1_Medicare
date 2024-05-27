<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$dbname = "medicare"; // Nom de la base de données
$password_mysql = "mysql"; // Mot de passe mysql

// Déclaration des variables
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password_mysql, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Préparer et exécuter la requête pour vérifier si l'utilisateur existe déjà
$sql = "SELECT * FROM Utilisateur WHERE Mail='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Vérifier le mot de passe
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["Mdp"])) {
        echo "Connexion réussie.";
        // Rediriger l'utilisateur ou démarrer une session, etc.
    } else {
        echo "Mot de passe incorrect.";
        echo '<br><a href="connexion.html">Retourner à la page de connexion</a>';
    }
} else {
    echo "L'utilisateur n'existe pas.";
    echo '<br><a href="connexion.html">Retourner à la page de connexion</a>';
}

// Fermer la connexion
$conn->close();
?>
