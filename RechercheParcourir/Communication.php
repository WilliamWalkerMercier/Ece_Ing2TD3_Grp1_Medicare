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
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="Recherche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <style>
        main{
            display: flex;
            justify-content: center;
            margin-top: 80px;
        }

        .contact-options {
            display: flex;
            flex-direction: column;
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            justify-content: center;
            width: 400px;
        }
        .contact-options h1 {
            color: #080909;
        }
        .contact-options a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            background-color: #144b1f;
        }
        .contact-options a:hover {
            background-color: #1f7230;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <a href="../Acceuil/Accueil.php"><img src="../Acceuil/imageAccueil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="../Acceuil/Accueil.php">Accueil</a></li>
            <li class="SousMenu1">
                <a href="../RechercheParcourir/ToutParcourir.php">Tout Parcourir</a>
                <ul class="SousMenu5">
                    <li><a href="../RechercheParcourir/Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="../RechercheParcourir/Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="../RechercheParcourir/Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="../RechercheParcourir/RechercheHTML.php">Recherche</a></li>
            <li><a href="../RDV/RendezVous.php">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<main>
    <div class="contact-options">
        <h1>Contact</h1>
        <a href="../ChatRoom/Chat.php">ChatRoom</a>
        <a href="callto:william.walkermercier@edu.ece.fr">Call via Microsoft Teams</a>
        <a href="tel:+33783948554">Envoyez nous un message: +33783948554</a>
        <a href="mailto:william.walkermercier@edu.ece.fr">Email Us: william.walkermercier@edu.ece.fr</a>
    </div>
</main>
<footer>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="../Acceuil/Accueil.php">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="../RechercheParcourir/ToutParcourir.php">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="../RechercheParcourir/Generaliste.php">Médecin généraliste</a></li>
                            <li><a href="../RechercheParcourir/Specialiste.php">Médecin spécialistes</a></li>
                            <li><a href="../RechercheParcourir/Laboratoire.php">Laboratoire de biologie médicale</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="../RechercheParcourir/RechercheHTML.php">Recherche</a></li>
                    <li><a href="../RDV/RendezVous.php">Rendez-vous</a></li>
                </ul>
            </nav2>
        </div>
    </div>
    <div class="copyright">
        <div class="copyright2">
            <p>Medicare &copy; 2024 Tous droits réservés.</p>
        </div>
        <div class="copyright3">
            <p>Medicare@medecine.fr</p>
        </div>
        <div class="copyright3">
            <p>06 25 78 98 67</p>
        </div>
        <div class="copyright3">
            <div class="insta">
                <a href="#"><img src="../Acceuil/imageAccueil/insta.png"></a>
            </div>
            <div class="x">
                <a href="#"><img src="../Acceuil/imageAccueil/twitter.png"></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
