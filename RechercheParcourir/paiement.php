<?php

session_start();
// Connexion à la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations du client
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal = $_POST['postal'];
    $cvc = $_POST['CVC'];

    // Récupérer les informations de la carte de crédit
    $cardType = $_POST['CardType'];
    $cardName = $_POST['CardName'];
    $cardNumber = $_POST['CardNumber'];
    $expirationDate = $_POST['ExpirationDate'];
    $formattedDate = DateTime::createFromFormat('Y-m-d', $expirationDate)->format('Y-m-d');

    // Préparer la requête SQL pour vérifier si l'utilisateur existe
    $sql = "SELECT * FROM utilisateur WHERE Nom = ? AND Mail = ? AND Adresse1 = ? AND Ville = ? AND Code_Postal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $address, $city, $postal);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'utilisateur existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = $user['Id_User'];

        // Vérifier si l'utilisateur est déjà dans la table client
        $sqlClientCheck = "SELECT * FROM client WHERE Id_Client = ?";
        $stmtClientCheck = $conn->prepare($sqlClientCheck);
        $stmtClientCheck->bind_param("i", $userId);
        $stmtClientCheck->execute();
        $resultClientCheck = $stmtClientCheck->get_result();

        if ($resultClientCheck->num_rows > 0) {
            // L'utilisateur a déjà un compte client, mise à jour des informations
            $sqlUpdateClient = "UPDATE client SET Type_Carte = ?, Num_Cb = ?, Date_Expiration = ?, Code_Securite = ?, Solde = IF(Solde > 6, Solde - 6, 0) WHERE Id_Client = ?";
            $stmtUpdateClient = $conn->prepare($sqlUpdateClient);
            $stmtUpdateClient->bind_param("sssii", $cardType, $cardNumber, $formattedDate, $cvc, $userId);

            if ($stmtUpdateClient->execute()) {
                echo "Les informations du client ont été mises à jour avec succès.<br>";
            } else {
                echo "Erreur lors de la mise à jour des informations du client: " . $conn->error . "<br>";
            }

            $stmtUpdateClient->close();
        } else {
            // L'utilisateur n'a pas encore de compte client, créer un nouveau client
            $sqlInsertClient = "INSERT INTO client (Id_Client, Type_Carte, Num_Cb, Date_Expiration, Code_Securite, Solde) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsertClient = $conn->prepare($sqlInsertClient);
            $soldeInitial = 100;
            $stmtInsertClient->bind_param("issisi", $userId, $cardType, $cardNumber, $formattedDate, $cvc, $soldeInitial);

            if ($stmtInsertClient->execute()) {
                echo "Vos informations ont été récupéré avec succès.<br>";

                // Mettre à jour le solde après la création du compte
                $sqlUpdateBalance = "UPDATE client SET Solde = IF(Solde > 6, Solde - 6, 0) WHERE Id_Client = ?";
                $stmtUpdateBalance = $conn->prepare($sqlUpdateBalance);
                $stmtUpdateBalance->bind_param("i", $userId);
                if ($stmtUpdateBalance->execute()) {
                    echo "Le solde a été mis à jour après la création du compte.<br>";
                } else {
                    echo "Erreur lors de la mise à jour du solde: " . $conn->error . "<br>";
                }
                $stmtUpdateBalance->close();
            } else {
                echo "Erreur lors de la création du compte client: " . $conn->error . "<br>";
            }

            $stmtInsertClient->close();
        }

        $stmtClientCheck->close();

        // Afficher les informations récupérées

        /*
        echo "<h2>Informations du Client</h2>";
        echo "Nom: " . htmlspecialchars($name) . "<br>";
        echo "Courriel: " . htmlspecialchars($email) . "<br>";
        echo "Adresse: " . htmlspecialchars($address) . "<br>";
        echo "Ville: " . htmlspecialchars($city) . "<br>";
        echo "Code Postal: " . htmlspecialchars($postal) . "<br>";

        echo "<h2>Informations de la Carte de Crédit</h2>";
        echo "Type de Carte: " . htmlspecialchars($cardType) . "<br>";
        echo "Nom sur la Carte: " . htmlspecialchars($cardName) . "<br>";
        echo "Numéro de Carte: " . htmlspecialchars($cardNumber) . "<br>";
        echo "Date d'Expiration: " . htmlspecialchars($formattedDate) . "<br>";
        echo "CVC: " . htmlspecialchars($cvc) . "<br>";
        */


        // Commande pour exécuter le script Node.js avec les paramètres
        $command = "node Telephone.js ";

        // Exécuter la commande
        exec($command, $output, $return_var);


        header("Refresh: 0.5;URL=PrendreRDVservice.php");
    } else {
        // Rediriger vers la page d'inscription
        echo '<script type="text/javascript">alert("Utilisateur non trouvé. Vous allez être redirigé vers la page de payement.");</script>';
        header("Refresh: 0.5; URL=checkoutForm.html");
        exit();
    }

    $stmt->close();
} else {
    echo "Aucune donnée soumise.";
}

$conn->close();
?>
