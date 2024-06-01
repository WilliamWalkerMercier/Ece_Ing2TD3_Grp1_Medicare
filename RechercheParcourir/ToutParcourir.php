<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tout Parcourir</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="ToutParcourir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
</head>
<body>
<section class="ToutParcourir">
    <h1>Parcourir</h1>
    <div class="nav2">
        <nav>
            <ul>
                <form action="Generaliste.php" method="get">
                    <li><a href="Generaliste.php" class="bouton" type="submit">Médecine Généraliste</a></li>
                </form>
                <li><a href="Specialiste.php" class="bouton">Médecins Spécialistes</a></li>
                <form action="Laboratoire.php" method="get">
                    <li><a href="Laboratoire.php" class="bouton">Laboratoire de biologie médical</a></li>
                </form>
            </ul>
        </nav>
    </div>
</section>
<header>
    <div class="logo">
        <a href="../Acceuil/Accueil.php"><img src="../Acceuil/imageAccueil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="../Acceuil/Accueil.php">Accueil</a></li>
            <li class="SousMenu1">
                <a href="ToutParcourir.html" class="active">Tout Parcourir</a>
                <ul class="SousMenu5">
                    <li><a href="Generaliste.php">Médecin généraliste</a></li>
                    <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                    <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                </ul>
            </li>
            <li><a href="RechercheHTML.php">Recherche</a></li>
            <li><a href="#">Rendez-vous</a></li>
        </ul>
    </nav>
    <div class="CompteLogo">
        <a href="#"><img src="../Acceuil/imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<foooter>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="../Acceuil/Accueil.php" class="active">Accueil</a></li>
                    <li class="SousMenu3">
                        <a href="ToutParcourir.html">Tout Parcourir</a>
                        <ul class="SousMenu4">
                            <li><a href="Generaliste.php">Médecin généraliste</a></li>
                            <li><a href="Specialiste.php">Médecin spécialistes</a></li>
                            <li><a href="Laboratoire.php">Laboratoire de biologie médicale</a></li>
                        </ul>
                    </li>
                    <li><a href="RechercheHTML.php">Recherche</a></li>
                    <li><a href="#">Rendez-vous</a></li>
                </ul>
            </nav2>
        </div>
    </div>
    <div class="copyright">
        <div class="copyright2">
            <p>Medicare &copy; 2024 Tous droits réservés.</p>
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
</foooter>
</body>
</html>