<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password_mysql = "mysql";
$dbname = "medicare";

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
$sql = "SELECT * FROM Utilisateur WHERE Mail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Vérifier le mot de passe
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["Mdp"])) {
        // Connexion réussie
        session_start();
        $_SESSION['user_id'] = $row['Id_User'];
        $_SESSION['user_name'] = $row['Nom'];
        // Redirection vers une page sécurisée
        header("Location: accueil.php");
        exit();
    } else {
        // Mot de passe incorrect
        header("Location: PasConnecte.html");
        exit();
    }
} else {
    // L'utilisateur n'existe pas
    header("Location: PasConnecte.html");
    exit();
}

// Fermer la connexion
$conn->close();
?>
