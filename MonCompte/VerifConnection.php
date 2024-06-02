<?php
session_start();
//Vérifie si l'utiisateur est connecté à un compte ou non
function checkUserLoggedIn() {
    if (!isset($_SESSION['LogedIn']) || $_SESSION['LogedIn'] !== true) {
        header("Location: ../MonCompte/PasConnecte.html");
        exit;
    }
}
//Vérifie si l'utiliateur à le bon type pour accèder à la page en question
function checkPermission($requiredType) {
    if ($_SESSION['user_type'] != $requiredType) {
        header("Location: ../Acceuil/Accueil.php");
        exit;
    }
}

?>

