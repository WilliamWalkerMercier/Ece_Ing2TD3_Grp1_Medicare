<?php
session_start();
include 'VerifConnection.php';
checkUserLoggedIn();
if ($_SESSION['user_type'] == 0) {
        header("Location: Admin/AdminMenu.php");
        exit;
    }
if ($_SESSION['user_type'] == 1) {
    header("Location: Medecin/DoctorMenu.php");
    exit;
}
if ($_SESSION['user_type'] == 2) {
    header("Location: Client/ClientMenu.php");
    exit();
}


// 0 admin 1 medecin 2 client
?>
