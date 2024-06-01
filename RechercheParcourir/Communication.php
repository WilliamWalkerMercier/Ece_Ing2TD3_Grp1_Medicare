<?php
include '../MonCompte/VerifConnection.php';
checkUserLoggedIn(); // Vérifie si l'utilisateur est connecté
checkPermission(2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .contact-options {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .contact-options h1 {
            color: #007bff;
        }
        .contact-options a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            background-color: #007bff;
        }
        .contact-options a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="contact-options">
    <h1>Contact Us</h1>
    <a href="../ChatRoom/Chat.php">ChatRoom</a>
    <a href="callto:william.walkermercier@edu.ece.fr">Call via Microsoft Teams</a>
    <a href="tel:+33783948554">Envoyez nous un message: +33783948554</a>
    <a href="mailto:william.walkermercier@edu.ece.fr">Email Us: william.walkermercier@edu.ece.fr</a>
</div>
</body>
</html>
