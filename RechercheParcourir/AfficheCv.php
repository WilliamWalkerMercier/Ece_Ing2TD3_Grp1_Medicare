<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CV du Médecin</title>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="stylesheet" href="Recherche.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <style>
        main{
            margin-top: 80px;
        }

        .cv-container {
            position: relative;
            padding: 20px;
            gap: 20px;
            width: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .photo-container {
            position: absolute;
            top: 20px;
            right: 20px;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            padding: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .photo-container img {
            border-radius: 8px;
            width: 150px;
            height: auto;
        }

        h1, h2 {
            color: #333;
        }

        h1 {
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }

        h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        p {
            line-height: 1.6;
        }

        .section {
            margin-bottom: 20px;
        }

        .section ul {
            list-style-type: none;
            padding: 0;
        }

        .section li {
            margin-bottom: 10px;
        }

        .section-title {
            color: #4CAF50;
            font-weight: bold;
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
    <div class="cv-container">
        <?php
        //Permet de récupérer la photo et le cv nécessaire
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['medecin_id'])) {
                $medecin_id = intval($_GET['medecin_id']);

                // Connexion à la base de données
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "medicare";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT CV, Photo FROM medecin WHERE Id_Medecin = $medecin_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $xmlFilePath = $row['CV'];
                    $photoPath = $row['Photo'];

                    if (file_exists($xmlFilePath)) {
                        $xml = simplexml_load_file($xmlFilePath);
                        if ($xml === false) {
                            echo "<p>Failed to load XML file.</p>";
                        } else {
                            // Display the photo
                            echo "<div class='photo-container'><img src='$photoPath' alt='Photo du médecin'></div>";

                            echo "<h1>CV de " . $xml->Prenom . " " . $xml->Nom . "</h1>";
                            echo "<p><strong>Spécialité :</strong> " . $xml->Specialite . "</p>";

                            // Formations
                            echo "<div class='section'>";
                            echo "<h2>Formations</h2>";
                            foreach ($xml->CV->Formations->Formation as $formation) {
                                echo "<p><strong>" . $formation->Diplome . "</strong> - " . $formation->Etablissement . " (" . $formation->Annee . ")</p>";
                            }
                            echo "</div>";

                            // Expériences
                            echo "<div class='section'>";
                            echo "<h2>Expériences</h2>";
                            foreach ($xml->CV->Experiences->Experience as $experience) {
                                echo "<p><strong>" . $experience->Poste . "</strong> - " . $experience->Lieu . " (" . $experience->Duree . ")</p>";
                                echo "<p>" . $experience->Description . "</p>";
                            }
                            echo "</div>";

                            // Publications
                            echo "<div class='section'>";
                            echo "<h2>Publications</h2>";
                            foreach ($xml->CV->Publications->Publication as $publication) {
                                echo "<p><strong>" . $publication->Titre . "</strong> - " . $publication->Journal . " (" . $publication->Annee . ")</p>";
                            }
                            echo "</div>";

                            // Distinctions
                            echo "<div class='section'>";
                            echo "<h2>Distinctions</h2>";
                            foreach ($xml->CV->Distinctions->Distinction as $distinction) {
                                echo "<p><strong>" . $distinction->Titre . "</strong> (" . $distinction->Annee . ")</p>";
                                echo "<p>" . $distinction->Description . "</p>";
                            }
                            echo "</div>";

                            // Compétences
                            echo "<div class='section'>";
                            echo "<h2>Compétences</h2>";
                            echo "<ul>";
                            foreach ($xml->CV->Competences->Competence as $competence) {
                                echo "<li>" . $competence . "</li>";
                            }
                            echo "</ul>";
                            echo "</div>";

                            // Langues
                            echo "<div class='section'>";
                            echo "<h2>Langues</h2>";
                            echo "<ul>";
                            foreach ($xml->CV->Langues->Langue as $langue) {
                                echo "<li><strong>" . $langue->Nom . ":</strong> " . $langue->Niveau . "</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Le fichier XML n'existe pas.</p>";
                    }
                } else {
                    echo "<p>Médecin introuvable.</p>";
                }

                $conn->close();
            } else {
                echo "<p>ID Médecin non reçu.</p>";
            }
        } else {
            echo "<p>Méthode de requête invalide.</p>";
        }
        ?>
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
