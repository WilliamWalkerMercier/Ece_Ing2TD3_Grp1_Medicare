// Importer la bibliothèque Twilio
const twilio = require('twilio');

// Vos identifiants Twilio
const accountSid = 'AC747b02359b8b7119b35d47ad0ee73181'; // Remplacez par votre SID de compte
const authToken = '24f65666109a63ca718ca62e0a01bc09'; // Remplacez par votre token d'authentification

// Créer un client Twilio
const client = new twilio(accountSid, authToken);

// Fonction pour envoyer un SMS
function sendSms(to, body) {
    client.messages.create({
        body: body, // Le contenu du message
        to: to, // Le numéro de téléphone du destinataire
        from: '+14238885060' // Votre numéro Twilio
    })
        .then((message) => console.log('Message sent: ' + message.sid))
        .catch((error) => console.error('Error sending message: ' + error));
}

// Utilisation de la fonction pour envoyer un SMS
sendSms('+33783948554', 'Votre rendez-vous a bien été confirmé, Vous avez été débité de 6€');
