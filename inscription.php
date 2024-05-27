<?php 
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$dbname = "medicare"; // Nom de la base de données
$password_mysql = ""; // Mot de passe mysql

// Déclaration des variables 
$prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : ""; 
$nom = isset($_POST["nom"]) ? $_POST["nom"] : ""; 
$adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : ""; 
$email = isset($_POST["email"]) ? $_POST["email"] : ""; 
$password = isset($_POST["password"]) ? $_POST["password"] : ""; 
$telephone = isset($_POST["telephone"]) ? $_POST["telephone"] : ""; 
$carte_vitale = isset($_POST["carte-vitale"]) ? $_POST["carte-vitale"] : ""; 
$erreur = ""; 

// Vérification des champs
if ($prenom == "") { 
    $erreur .= "Le champ Prénom est vide. <br>"; 
} 
if ($nom == "") { 
    $erreur .= "Le champ Nom est vide. <br>"; 
} 
if ($adresse == "") { 
    $erreur .= "Le champ Adresse est vide. <br>"; 
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
$sql = "SELECT * FROM Utilisateur WHERE Mail='$email'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Un utilisateur avec cet email existe déjà.";
    echo '<br><a href="inscription.html">Retourner à la page d\'inscription</a>';
} else {
    // Hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insérer l'utilisateur dans la table Utilisateur
    $sql = "INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type) 
            VALUES ('$nom', '$prenom', '$email', '$telephone', '$hashed_password', 2)";
    
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        
        // Insérer les informations du client dans la table Client
        $sql = "INSERT INTO Client (Id_Client, Type_Carte, Num_Cb, Date_Expiration, Code_Securite) 
                VALUES ($last_id, 'Vitale', '$carte_vitale', NULL, NULL)";
        
        if ($conn->query($sql) === TRUE) {
            echo "Inscription réussie.";
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

// Fermer la connexion
$conn->close();
?>
