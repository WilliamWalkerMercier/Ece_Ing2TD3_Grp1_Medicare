-- Medecin 1
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Dupont', 'Jean', 'jean.dupont@medecine.ece.fr', '0123456789', 'password123456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Addictologie', 'CV de Jean Dupont', '111001011110', 'sc-200');

-- Medecin 2
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Lefevre', 'Marie', 'marie.lefevre@medecine.ece.fr', '0234567891', 'password223456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Addictologie', 'CV de Marie Lefevre', '101110011101', 'em-250');


-- Medecin 1
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Durand', 'François', 'francois.durand@medecine.ece.fr', '0123456789', 'password123456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Andrologie', 'CV de François Durand', '111001011110', 'sc-201');

-- Medecin 2
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Lemoine', 'Sophie', 'sophie.lemoine@medecine.ece.fr', '0234567891', 'password223456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Andrologie', 'CV de Sophie Lemoine', '101110011101', 'em-251');

-- Medecin 3
-- Medecin 1 en Cardiologie
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Girard', 'Nicolas', 'nicolas.girard@medecine.ece.fr', '0456789123', 'password423456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Cardiologie', 'CV de Nicolas Girard', '111100011110', 'em-202');

-- Medecin 2 en Cardiologie
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Leroy', 'Julie', 'julie.leroy@medecine.ece.fr', '0567891234', 'password523456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Cardiologie', 'CV de Julie Leroy', '101101111101', 'sc-252');

-- Medecin 1 en Dermatologie
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Roux', 'Thomas', 'thomas.roux@medecine.ece.fr', '0678912345', 'password623456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Dermatologie', 'CV de Thomas Roux', '110110100011', 'em-302');
-- Medecins specialises en Gastro- Hepato-Enterologie
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)

 VALUES ('Lermite', 'Bernard', 'Bernard.lermite@medecine.ece.fr', 0314159265, 'abcde12345abcde12345abcde1', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gastro- Hepato-Enterologie', 'CV de Jean Lefevre', '110011001100', 'sc-200');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)
 VALUES ('Martin', 'Marie', 'marie.martin@medecine.ece.fr', 0234567891, 'bcdef23456bcdef23456bcdef2', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gastro- Hepato-Enterologie', 'CV de Marie Martin', '101100110011', 'em-201');


-- Medecins specialises en Gynecologie
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)
 VALUES ('Leroy', 'Sophie', 'sophie.leroy@medecine.ece.fr', 0456789123, 'defgh45678defgh45678defgh4', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gynecologie', 'CV de Sophie Leroy', '001100110011', 'em-203');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)
 VALUES ('Roux', 'Nicolas', 'nicolas.roux@medecine.ece.fr', 0567891234, 'efghi56789efghi56789efghi5', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) 
VALUES (LAST_INSERT_ID(), 'Gynecologie', 'CV de Nicolas Roux', '110011001100', 'sc-204');

 -- Medecins specialises en I.S.T.
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Lefevre', 'Jean', 'jean.lefevre@medecine.ece.fr', 0123456789, 'abcde12345abcde12345abcde1', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'I.S.T.', 'CV de Jean Lefevre', '110011001100', 'sc-200');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Martin', 'Marie', 'marie.martin@medecine.ece.fr', 0234567891, 'bcdef23456bcdef23456bcdef2', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'I.S.T.', 'CV de Marie Martin', '101100110011', 'em-201');

-- Medecins specialises en Osteopathie
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Leroy', 'Sophie', 'sophie.leroy@medecine.ece.fr', 0456789123, 'defgh45678defgh45678defgh4', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'Osteopathie', 'CV de Sophie Leroy', '001100110011', 'em-203');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Roux', 'Nicolas', 'nicolas.roux@medecine.ece.fr', 0567891234, 'efghi56789efghi56789efghi5', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'Osteopathie', 'CV de Nicolas Roux', '110011001100', 'sc-204');

-- Insertion des utilisateurs
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type, Pays, Ville, Code_Postal, Adresse1, Adresse2) VALUES 
('Schtroumpf', 'Bricoleur', 'bricoleur.schtroumpf@Gargamel.medecine.fr', '0678392451', 'Abc123def456ghi', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 1', 'Lieu-dit'),
('Schtroumpf', 'Gourmand', 'gourmand.schtroumpf@Gargamel.medecine.fr', '0678234951', 'Def456ghi789jkl', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 2', 'Lieu-dit'),
('Schtroumpf', 'Jardinier', 'jardinier.schtroumpf@Gargamel.medecine.fr', '0678234591', 'Ghi789jkl012mno', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 3', 'Lieu-dit'),
('Schtroumpf', 'Coquet', 'coquet.schtroumpf@Gargamel.medecine.fr', '0678234952', 'Jkl012mno345pqr', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 4', 'Lieu-dit'),
('Schtroumpf', 'Costaud', 'costaud.schtroumpf@Gargamel.medecine.fr', '0678234953', 'Mno345pqr678stu', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 5', 'Lieu-dit'),
('Schtroumpf', 'Farceur', 'farceur.schtroumpf@Gargamel.medecine.fr', '0678234954', 'Pqr678stu901vwx', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 6', 'Lieu-dit');

-- Insertion des medecins
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau, Photo) VALUES 
((SELECT Id_User FROM Utilisateur WHERE Prenom='Bricoleur' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Bricoleur', '101010101010', 'Maison Champignon Rouge', 'images/bricoleur.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Gourmand' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Gourmand', '010101010101', 'Maison Champignon Bleu', 'images/gourmand.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Jardinier' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Jardinier', '110011001100', 'Maison Champignon Vert', 'images/jardinier.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Coquet' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Coquet', '001100110011', 'Maison Champignon Jaune', 'images/coquet.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Costaud' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Costaud', '111000111000', 'Maison Champignon Noir', 'images/costaud.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Farceur' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Farceur', '000111000111', 'Maison Champignon Blanc', 'images/farceur.jpg');

INSERT INTO Laboratoire VALUES ('1','Em-009','123456789','Labo1@lab.co','Laboratoire des trois champignons', '10 rue Sextius Michel'); 

INSERT INTO ServiceLab (Nom_Service, Description_Service) VALUES 
('Depistage covid-19', 'Test de depistage pour le virus Covid-19'),
('Biologie preventive', 'Analyses pour prevenir les maladies'),
('Biologie de la femme enceinte', 'Tests et analyses pour les femmes enceintes'),
('Biologie de routine', 'Analyses medicales courantes'),
('Cancerologie', 'Tests et analyses pour la detection du cancer'),
('Gynecologie', 'Analyses et tests en gynecologie');

INSERT INTO Dispenses (Id_Lab, Nom_Service) VALUES 
(1, 'Depistage covid-19'),
(1, 'Biologie preventive'),
(1, 'Biologie de la femme enceinte'),
(1, 'Biologie de routine'),
(1, 'Cancerologie'),
(1, 'Gynecologie');


-- Insertion des utilisateurs
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type, Pays, Ville, Code_Postal, Adresse1, Adresse2, Carte_Vitale)
VALUES 
    ('Vader', 'Anakin', 'anakin.vader@empire.com', 111222333, 'darkside123', 0, 'Tatooine', 'Mos Eisley', 12345, 'Rue des Siths', 'Appartement 66', 987654321),
    ('Solo', 'Kylo', 'kylo.solo@firstorder.com', 444555666, 'darkness456', 0, 'Unknown', 'Unknown', 00000, 'Unknown', 'Unknown', 123456789),
    ('Maul', 'Darth', 'darth.maul@sith.com', 777888999, 'doubleblade789', 0, 'Dathomir', 'Nightbrother Village', 54321, 'Dark Side Alley', 'Cave 13', 987654321),
    ('Tano', 'Ahsoka', 'ahsoka.tano@jediorder.com', 888999000, 'fulcrum123', 0, 'Shili', 'Jedi Temple', 11122, 'Padawan Lane', 'Room 7', 456789012),
    ('Fett', 'Boba', 'boba.fett@bountyhunters.com', 222333444, 'mandalorian456', 0, 'Kamino', 'Tipoca City', 33344, 'Clone Way', 'Block 27', 234567890),
    ('R2D2', NULL, NULL, NULL, NULL, 0, 'Tatooine', 'Mos Eisley', 12345, 'Droid St0eet', NULL, NULL),
    ('C3PO', NULL, NULL, NULL, NULL, 0, 'Tatooine', 'Mos Eisley', 12345, 'Droid Avenue', NULL, NULL);

--Modifier les nombres au besoin
INSERT INTO Client (Id_Client, Type_Carte, Num_Cb, Date_Expiration, Code_Securite, Solde)
VALUES 
    (44, 'Visa', 1111233444, '2026-05-29', 123, 1000),
    (45, 'MasterCard', 44441111, '2025-11-15', 456, 1500),
    (46, 'American Express', 57778888, '2024-07-23', 789, 500),
    (47, 'Discover', 99998766, '2027-01-01', 321, 800),
    (48, 'Visa', 33334566, '2028-03-17', 654, 2000);


