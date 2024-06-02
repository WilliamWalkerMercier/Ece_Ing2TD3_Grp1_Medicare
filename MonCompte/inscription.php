<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password_mysql = "";
$dbname = "medicare";

// Déclaration des variables 
$prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : ""; 
$nom = isset($_POST["nom"]) ? $_POST["nom"] : ""; 
$adresse1 = isset($_POST["adresse1"]) ? $_POST["adresse1"] : ""; 
$adresse2 = isset($_POST["adresse2"]) ? $_POST["adresse2"] : ""; 
$ville = isset($_POST["ville"]) ? $_POST["ville"] : ""; 
$code_postal = isset($_POST["codePostal"]) ? $_POST["codePostal"] : ""; 
$pays = isset($_POST["pays"]) ? $_POST["pays"] : ""; 
$email = isset($_POST["email"]) ? $_POST["email"] : ""; 
$password = isset($_POST["password"]) ? $_POST["password"] : ""; 
$telephone = isset($_POST["telephone"]) ? $_POST["telephone"] : ""; 
$carte_vitale = isset($_POST["carteVitale"]) ? $_POST["carteVitale"] : ""; 
$erreur = ""; 

// Vérification des champs
if ($prenom == "") { 
    $erreur .= "Le champ Prénom est vide. <br>"; 
} 
if ($nom == "") { 
    $erreur .= "Le champ Nom est vide. <br>"; 
} 
if ($adresse1 == "") { 
    $erreur .= "Le champ Adresse ligne 1 est vide. <br>"; 
} 
if ($ville == "") { 
    $erreur .= "Le champ Ville est vide. <br>"; 
} 
if ($code_postal == "") { 
    $erreur .= "Le champ Code Postal est vide. <br>"; 
} 
if ($pays == "") { 
    $erreur .= "Le champ Pays est vide. <br>"; 
} 
if ($email == "") { 
    $erreur .= "Le champ Email est vide. <br>"; 
} 
if ($password == "") { 
    $erreur .= "Le champ Mot de passe est vide. <br>"; 
} 
if ($telephone == "") { 
    $erreur .= "Le champ Numéro de téléphone est vide. <br>"; 
} 
if ($carte_vitale == "") { 
    $erreur .= "Le champ Carte Vitale est vide. <br>"; 
}

// Si des erreurs sont présentes, afficher les erreurs et retourner à la page d'inscription
if ($erreur != "") { 
    echo "Erreur: <br>" . $erreur;
    echo '<br><a href="inscription.html">Retourner à la page d\'inscription</a>';
    exit();
} 

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password_mysql, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Préparer et exécuter la requête pour vérifier si l'utilisateur existe déjà
/*
 * https://www.php.net/manual/fr/mysqli.quickstart.prepared-statements.php
 * https://www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/#:~:text=Pr%C3%A9parer%20ses%20requ%C3%AAtes%20comporte%20des,donn%C3%A9es%20envoy%C3%A9es%20par%20les%20utilisateurs.
 * */
$sql = "SELECT * FROM Utilisateur WHERE Mail=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Un utilisateur avec cet email existe déjà.";
    echo '<br><a href="inscription.html">Retourner à la page d\'inscription</a>';
} else {
    // Hacher le mot de passe
    //https://www.primfx.com/securiser-mot-de-passe-php-password-hash-verify/
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Convertir le numéro de téléphone en entier
    $telephone = preg_replace('/\D/', '', $telephone);
    if (substr($telephone, 0, 1) === '0') {
        $telephone = '33' . substr($telephone, 1);
    }

    // Assurer que carte_vitale est un entier
    $carte_vitale = intval($carte_vitale);

    // Insérer l'utilisateur dans la table Utilisateur
    $sql = "INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type, Pays, Ville, Code_Postal, Adresse1, Adresse2, Carte_Vitale) 
            VALUES (?, ?, ?, ?, ?, 2, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisssissi", $nom, $prenom, $email, $telephone, $hashed_password, $pays, $ville, $code_postal, $adresse1, $adresse2, $carte_vitale);

    if ($stmt->execute()) {
		header("Location: connection.html");

    } else {
        echo "Erreur: " . $stmt->error;
    }
}

// Fermer la connexion
$conn->close();
?>
