<?php

session_start();
if (isset($_GET['logout'])) {

    //Message de sortie simple
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>" .
        $_SESSION['name'] . "</b> a quitté la session de chat.</span><br></div>";


    $myfile = fopen(__DIR__ . "/log.html", "a") or die("Impossible d'ouvrir le fichier!" . __DIR__ . "/log.html");
    fwrite($myfile, $logout_message);
    fclose($myfile);

    session_destroy();
    sleep(1);
    header("Location: chat.php"); //Rediriger l'utilisateur
}

if (isset($_POST['enter'])) {
    if ($_POST['name'] != "") {
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    } else {
        echo '<span class="error">Veuillez saisir votre nom</span>';
    }
}

function loginForm()
{
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "medicare");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Fetch the user name from the database
    $sql = "SELECT Nom FROM utilisateur WHERE Id_User = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($userName);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    echo '<div id="loginform">
            <p>Bienvenue, ' . htmlspecialchars($userName) . '! Vous allez être redirigé vers le chat.</p>
            <form action="Chat.php" method="post">
                <input type="hidden" name="name" id="name" value="' . htmlspecialchars($userName) . '" />
                <input type="submit" name="enter" id="enter" value="Continuer" />
            </form>
          </div>';
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Exemple Chat Texto</title>
    <link rel="stylesheet" href="Chat.css"/>
    <link rel="stylesheet" href="../HeaderFooter.css">
    <link rel="icon" href="../Acceuil/imageAccueil/LogoMedicare.ico">
    <link rel="stylesheet" href="../RechercheParcourir/Recherche.css">
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
        <a href="../MonCompte/RedirectConnection.php"><img src="../Acceuil/imageAccueil/MonCompte.png"
                                                           alt="Compte Logo"></a>
    </div>
</header>
<main>
    <?php
    if (!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>
    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Bienvenue, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="../RechercheParcourir/RechercheHTML.php">Quitter la conversation</a>
            </p>
        </div>

        <div id="chatbox">
            <?php
            if (file_exists("log.html") && filesize("log.html") > 0) {
                $contents = file_get_contents("log.html");
                echo $contents;
            }
            ?>
        </div>

        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg"/>
            <input name="submitmsg" type="submit" id="submitmsg" value="Envoyer"/>
        </form>
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
</footer>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    // jQuery Document
    $(document).ready(function () {
        $("#submitmsg").click(function () {
            var clientmsg = $("#usermsg").val();
            $.post("post.php", {text: clientmsg});
            $("#usermsg").val("");
            return false;
        });

        function loadLog() {
            var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Hauteur de défilement avant la requête

            $.ajax({
                url: "log.html",
                cache: false,
                success: function (html) {
                    $("#chatbox").html(html); //Insérez le log de chat dans la #chatbox div

                    //Auto-scroll
                    var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Hauteur de défilement apres la requête
                    if (newscrollHeight > oldscrollHeight) {
                        $("#chatbox").animate({scrollTop: newscrollHeight}, 'normal'); //Défilement automatique
                    }
                }
            });
        }

        setInterval(loadLog, 2500);

        $("#exit").click(function () {
            var exit = confirm("Voulez-vous vraiment mettre fin à la session ?");
            if (exit == true) {
                window.location = "chat.php?logout=true";
            }
        });
    });
</script>
</body>
</html>
<?php
}
?>
