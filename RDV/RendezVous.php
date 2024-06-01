<?php
session_start();
include '../MonCompte/VerifConnection.php';
checkUserLoggedIn(); // Vérifie si l'utilisateur est connecté
checkPermission(2);

// Vérifiez le type d'utilisateur et redirigez en conséquence
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == 1) {
        header("Location: AfficherRDVmedecins.php");
        exit;
    } elseif ($_SESSION['user_type'] == 2) {
        header("Location: infoUtilisateur.php");
        exit;
    } else {
        // Optionnel : Redirigez vers une page d'erreur ou une page par défaut si le type d'utilisateur n'est pas reconnu
        header("Location: ../Acceuil/Accueil.php");
        exit;
    }
} else {
    // Optionnel : Redirigez vers une page d'erreur ou une page par défaut si le type d'utilisateur n'est pas défini
    header("Location: ../Acceuil/Accueil.php");
    exit;
}
?>
