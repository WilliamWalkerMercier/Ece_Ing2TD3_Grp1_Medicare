<?php
session_start();
// Vérifie si 'isLogged' a été défini dans la session
if (!isset($_SESSION['LogedIn'])) {
    $_SESSION['LogedIn'] = false;  // Initialise 'isLogged' à false si non défini
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="Accueil.css">
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="icon" href="imageAccueil/LogoMedicare.ico">
</head>
<body>
<div id="intro">
    <div class="Intro">
        <img src="imageAccueil/LogoMedicare.png" alt="Medicare Logo" class="Intrologo">
    </div>
</div>
<section class="ScrollingAcceuil">
    <img src="imageAccueil/fond1.png" class="fond1">
    <img src="imageAccueil/fond2.png" class="fond2">
    <img src="imageAccueil/fond3.png" class="fond3">
    <h1 class="titre">Medicare</h1>
    <img src="imageAccueil/fond4.png" class="fond4">
    <img src="imageAccueil/fond5.png" class="fond5">
    <img src="imageAccueil/fond6.png" class="fond6">
</section>
<header>
    <div class="logo">
        <a href="Accueil.php"><img src="imageAccueil/LogoMedicare.png" alt="Medicare Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="Accueil.php" class="active">Accueil</a></li>
            <li class="SousMenu1">
                <a href="../RechercheParcourir/ToutParcourir.php">Tout Parcourir</a>
                <ul class="SousMenu2">
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
        <a href="../MonCompte/RedirectConnection.php"><img src="imageAccueil/MonCompte.png" alt="Compte Logo"></a>
    </div>
</header>
<main>
    <section class="Bienvenus">
        <div>
            <h2 class="titre2">Bienvenue sur Medicare !</h2><br>
            <p>Nous sommes ravis de vous accueillir au sein de notre communauté. Chez Medicare, nous nous engageons à
                fournir des services de santé de qualité et à répondre à tous vos besoins médicaux. Que vous ayez besoin de
                consulter un spécialiste, de gérer vos prescriptions ou de trouver des informations sur les soins de santé,
                nous sommes là pour vous aider à chaque étape.
                Notre mission est de rendre les soins de santé accessibles et faciles à comprendre pour tous. N'hésitez pas
                à explorer notre site et à découvrir les nombreuses ressources que nous offrons pour vous et votre famille.
                Merci de nous faire confiance pour votre santé et votre bien-être.
                L'équipe Medicare</p>
        </div>
    </section>
    <section class="evenement">
        <div class="EvenementContenu">
            <div class="EvenementImage">
                <img src="imageAccueil/evenement1.png" class="Evenement1">
            </div>
            <div class="EvenementText">
                <h2 class="titre3">Evenement de la semaine</h2><br>
                <p> l'introduction et l'adoption généralisée de thérapies ciblées et d'immunothérapies:</p>
                <br>
                <p>Ces avancées ont révolutionné le traitement du cancer en ciblant spécifiquement les cellules cancéreuses
                    tout en minimisant les dommages aux cellules saines.</p>
                <br>
                <p>Les thérapies ciblées fonctionnent en bloquant les mécanismes spécifiques de croissance et de propagation
                    des cellules cancéreuses, souvent en ciblant des protéines spécifiques présentes à la surface des
                    cellules tumorales. Cette approche personnalisée permet des traitements plus efficaces avec moins
                    d'effets secondaires.</p>
                <br>
                <p>D'autre part, l'immunothérapie stimule le système immunitaire du patient pour qu'il reconnaisse et
                    attaque les cellules cancéreuses. Des traitements comme les inhibiteurs de points de contrôle
                    immunitaire ont démontré des résultats spectaculaires dans certains types de cancer, offrant de
                    nouvelles options là où les traitements traditionnels étaient limités.</p>
                <br>
                <p>Ces développements ont apporté de l'espoir à de nombreux patients atteints de cancer, transformant la
                    manière dont la maladie est traitée et ouvrant la voie à une approche plus précise et personnalisée de
                    la lutte contre le cancer.</p>
            </div>
        </div>
    </section>
    <section class="carousel">
        <h2>Nos Médecins</h2><br>
        <div class="contenu">
            <input type="radio" name="case" id="c1">
            <label for="c1" class="carte">
                <div class="CD_row">
                    <div class="ImgMed">1</div>
                    <div class="DescriptionMed">
                        <h4>Kevin Dubois</h4>
                        <p>Médecin généraliste, spécialiste de santé polyvalent.</p>
                    </div>
                </div>
            </label>
            <input type="radio" name="case" id="c2">
            <label for="c2" class="carte">
                <div class="CD_row">
                    <div class="ImgMed">2</div>
                    <div class="DescriptionMed">
                        <h4>Jean Louis</h4>
                        <p>Médecin Cardiologue, spécialisé dans les maladies cardiaques</p>
                    </div>
                </div>
            </label>
            <input type="radio" name="case" id="c3">
            <label for="c3" class="carte">
                <div class="CD_row">
                    <div class="ImgMed">3</div>
                    <div class="DescriptionMed">
                        <h4>Virginie Kirman</h4>
                        <p>Médecin Gynécologue, spécialisé dans la santé reproductive</p>
                    </div>
                </div>
            </label>
            <input type="radio" name="case" id="c4">
            <label for="c4" class="carte">
                <div class="CD_row">
                    <div class="ImgMed">4</div>
                    <div class="DescriptionMed">
                        <h4>Sophie Dupont</h4>
                        <p>Médecin Dermathologue, spécialisé dans les maladies de la peau</p>
                    </div>
                </div>
            </label>
            <input type="radio" name="case" id="c5">
            <label for="c5" class="carte">
                <div class="CD_row">
                    <div class="ImgMed">5</div>
                    <div class="DescriptionMed">
                        <h4>Lucas Lopez</h4>
                        <p>Médecin généraliste, spécialiste de santé polyvalent.</p>
                    </div>
                </div>
            </label>
        </div>
    </section>
</main>
<footer>
    <div class="menu-footer">
        <div class="menu-footer2">
            <nav2>
                <ul>
                    <li><a href="Accueil.php">Accueil</a></li>
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
            <div class="insta">
                <a href="#"><img src="imageAccueil/insta.png"></a>
            </div>
            <div class="x">
                <a href="#"><img src="imageAccueil/twitter.png"></a>
            </div>
        </div>
    </div>
    <div class="Map">
        <div class="GoogleMap">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31228.433482034532!2d2.6514271858837017!3d48.4001966329627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e5f500761f24f1%3A0xdf36a3bc130b8970!2sLaboratoire%20de%20biologie%20m%C3%A9dicale!5e0!3m2!1sfr!2sfr!4v1716939694993!5m2!1sfr!2sfr"
                    width="600"
                    height="450"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</footer>
<script src="Accueil.js"></script>
</body>
</html>