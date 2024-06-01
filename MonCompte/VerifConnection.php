<?php
session_start();
function checkUserLoggedIn() {
    if (!isset($_SESSION['LogedIn']) || $_SESSION['LogedIn'] !== true) {
        header("Location: ../MonCompte/PasConnecte.html");
        exit;
    }
}

function checkPermission($requiredType) {
    if ($_SESSION['user_type'] != $requiredType) {
        header("Location: ../Acceuil/Accueil.php");
        exit;
    }
}

?>

