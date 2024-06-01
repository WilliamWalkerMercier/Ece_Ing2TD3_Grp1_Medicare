<?php
session_start();

// Configuration de la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicare";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtenir les données du formulaire
$email = $_POST['email'];
$pwd = $_POST['password'];

// Échapper les données pour éviter les injections SQL
$email = $conn->real_escape_string($email);

// Requête SQL pour récupérer le mot de passe haché et les informations de l'utilisateur
$sql = "SELECT Id_User, Type, Mdp FROM utilisateur WHERE Mail = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    // Vérifier le mot de passe
    if (password_verify($pwd, $user['Mdp'])) {
        // Si les informations sont correctes, enregistrer les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['Id_User'];
        $_SESSION['user_type'] = $user['Type'];
        $_SESSION['LogedIn'] = true;

        // Redirection vers la page appropriée en fonction du type d'utilisateur
        switch ($user['Type']) {
            case 0:
                header("Location: Admin/AdminMenu.php");
                break;
            case 1:
                header("Location: Doctor/DoctorMenu.html");
                break;
            case 2:
                header("Location: Client/ClientMenu.php");
                break;
            default:
                // Par sécurité, rediriger vers une page par défaut ou afficher un message d'erreur
                header("Location: Acceuil.html");
                break;
        }
    } else {
        // Si le mot de passe est incorrect, rediriger vers la page de connexion avec un message d'erreur
        $_SESSION['login_error'] = "Invalid email or password";
        header("Location: PasConnecte.html");
    }
} else {
    // Si l'email est incorrect, rediriger vers la page de connexion avec un message d'erreur
    $_SESSION['login_error'] = "Invalid email or password";
    header("Location: PasConnecte.html");
}

$conn->close();
?>
