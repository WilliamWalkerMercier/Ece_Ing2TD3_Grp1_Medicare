-- Médecin 1
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Dupont', 'Jean', 'jean.dupont@medecine.ece.fr', '0123456789', 'password123456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Addictologie', 'CV de Jean Dupont', '111001011110', 'sc-200');

-- Médecin 2
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Lefevre', 'Marie', 'marie.lefevre@medecine.ece.fr', '0234567891', 'password223456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Addictologie', 'CV de Marie Lefevre', '101110011101', 'em-250');

-- Médecin 3
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Martin', 'Pierre', 'pierre.martin@medecine.ece.fr', '0345678912', 'password323456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Addictologie', 'CV de Pierre Martin', '110111100011', 'sc-300');

-- Médecin 1
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Durand', 'François', 'francois.durand@medecine.ece.fr', '0123456789', 'password123456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Andrologie', 'CV de François Durand', '111001011110', 'sc-201');

-- Médecin 2
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Lemoine', 'Sophie', 'sophie.lemoine@medecine.ece.fr', '0234567891', 'password223456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Andrologie', 'CV de Sophie Lemoine', '101110011101', 'em-251');

-- Médecin 3
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Moreau', 'Lucas', 'lucas.moreau@medecine.ece.fr', '0345678912', 'password323456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Andrologie', 'CV de Lucas Moreau', '110111100011', 'sc-301');

-- Médecin 1 en Cardiologie
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Girard', 'Nicolas', 'nicolas.girard@medecine.ece.fr', '0456789123', 'password423456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Cardiologie', 'CV de Nicolas Girard', '111100011110', 'em-202');

-- Médecin 2 en Cardiologie
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Leroy', 'Julie', 'julie.leroy@medecine.ece.fr', '0567891234', 'password523456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Cardiologie', 'CV de Julie Leroy', '101101111101', 'sc-252');

-- Médecin 1 en Dermatologie
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Roux', 'Thomas', 'thomas.roux@medecine.ece.fr', '0678912345', 'password623456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Dermatologie', 'CV de Thomas Roux', '110110100011', 'em-302');

-- Médecin 2 en Dermatologie
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Morel', 'Emma', 'emma.morel@medecine.ece.fr', '0789123456', 'password723456789012345', 1);
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau)
VALUES (LAST_INSERT_ID(), 'Dermatologie', 'CV de Emma Morel', '111011100011', 'sc-303');

-- Médecins spécialisés en Gastro- Hépato-Entérologie
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)

 VALUES ('Lefevre', 'Jean', 'jean.lefevre@medecine.ece.fr', 0123456789, 'abcde12345abcde12345abcde1', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gastro- Hépato-Entérologie', 'CV de Jean Lefevre', '110011001100', 'sc-200');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)
 VALUES ('Martin', 'Marie', 'marie.martin@medecine.ece.fr', 0234567891, 'bcdef23456bcdef23456bcdef2', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gastro- Hépato-Entérologie', 'CV de Marie Martin', '101100110011', 'em-201');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) 
VALUES ('Dubois', 'Pierre', 'pierre.dubois@medecine.ece.fr', 0345678912, 'cdefg34567cdefg34567cdefg3', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gastro- Hépato-Entérologie', 'CV de Pierre Dubois', '011001100110', 'sc-202');

-- Médecins spécialisés en Gynécologie
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)
 VALUES ('Leroy', 'Sophie', 'sophie.leroy@medecine.ece.fr', 0456789123, 'defgh45678defgh45678defgh4', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gynécologie', 'CV de Sophie Leroy', '001100110011', 'em-203');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)
 VALUES ('Roux', 'Nicolas', 'nicolas.roux@medecine.ece.fr', 0567891234, 'efghi56789efghi56789efghi5', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) 
VALUES (LAST_INSERT_ID(), 'Gynécologie', 'CV de Nicolas Roux', '110011001100', 'sc-204');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type)
VALUES ('Moreau', 'Claire', 'claire.moreau@medecine.ece.fr', 0678912345, 'fghij67890fghij67890fghij6', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau)
 VALUES (LAST_INSERT_ID(), 'Gynécologie', 'CV de Claire Moreau', '101100110011', 'em-205');

 -- Médecins spécialisés en I.S.T.
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Lefevre', 'Jean', 'jean.lefevre@medecine.ece.fr', 0123456789, 'abcde12345abcde12345abcde1', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'I.S.T.', 'CV de Jean Lefevre', '110011001100', 'sc-200');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Martin', 'Marie', 'marie.martin@medecine.ece.fr', 0234567891, 'bcdef23456bcdef23456bcdef2', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'I.S.T.', 'CV de Marie Martin', '101100110011', 'em-201');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Dubois', 'Pierre', 'pierre.dubois@medecine.ece.fr', 0345678912, 'cdefg34567cdefg34567cdefg3', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'I.S.T.', 'CV de Pierre Dubois', '011001100110', 'sc-202');

-- Médecins spécialisés en Ostéopathie
INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Leroy', 'Sophie', 'sophie.leroy@medecine.ece.fr', 0456789123, 'defgh45678defgh45678defgh4', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'Ostéopathie', 'CV de Sophie Leroy', '001100110011', 'em-203');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Roux', 'Nicolas', 'nicolas.roux@medecine.ece.fr', 0567891234, 'efghi56789efghi56789efghi5', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'Ostéopathie', 'CV de Nicolas Roux', '110011001100', 'sc-204');

INSERT INTO Utilisateur(Nom, Prenom, Mail, Telephone, Mdp, Type) VALUES ('Moreau', 'Claire', 'claire.moreau@medecine.ece.fr', 0678912345, 'fghij67890fghij67890fghij6', 1);
INSERT INTO Medecin(Id_Medecin, Specialite, CV, Disponibilite, Bureau) VALUES (LAST_INSERT_ID(), 'Ostéopathie', 'CV de Claire Moreau', '101100110011', 'em-205');

-- Insertion des utilisateurs
INSERT INTO Utilisateur (Nom, Prenom, Mail, Telephone, Mdp, Type, Pays, Ville, Code_Postal, Adresse1, Adresse2) VALUES 
('Schtroumpf', 'Bricoleur', 'bricoleur.schtroumpf@Gargamel.medecine.fr', '0678392451', 'Abc123def456ghi', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 1', 'Lieu-dit'),
('Schtroumpf', 'Gourmand', 'gourmand.schtroumpf@Gargamel.medecine.fr', '0678234951', 'Def456ghi789jkl', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 2', 'Lieu-dit'),
('Schtroumpf', 'Jardinier', 'jardinier.schtroumpf@Gargamel.medecine.fr', '0678234591', 'Ghi789jkl012mno', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 3', 'Lieu-dit'),
('Schtroumpf', 'Coquet', 'coquet.schtroumpf@Gargamel.medecine.fr', '0678234952', 'Jkl012mno345pqr', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 4', 'Lieu-dit'),
('Schtroumpf', 'Costaud', 'costaud.schtroumpf@Gargamel.medecine.fr', '0678234953', 'Mno345pqr678stu', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 5', 'Lieu-dit'),
('Schtroumpf', 'Farceur', 'farceur.schtroumpf@Gargamel.medecine.fr', '0678234954', 'Pqr678stu901vwx', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 6', 'Lieu-dit'),
('Schtroumpf', 'Poète', 'poete.schtroumpf@Gargamel.medecine.fr', '0678234955', 'Stu901vwx234yzA', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 7', 'Lieu-dit'),
('Schtroumpf', 'Paysan', 'paysan.schtroumpf@Gargamel.medecine.fr', '0678234956', 'Vwx234yzA567BCD', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 8', 'Lieu-dit'),
('Schtroumpf', 'Dormeur', 'dormeur.schtroumpf@Gargamel.medecine.fr', '0678234957', 'YZABcdEfghijkLM', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 9', 'Lieu-dit'),
('Schtroumpf', 'Peureux', 'peureux.schtroumpf@Gargamel.medecine.fr', '0678234958', 'MNoPQRStuvWXYZa', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 10', 'Lieu-dit');

-- Insertion des médecins
INSERT INTO Medecin (Id_Medecin, Specialite, CV, Disponibilite, Bureau, Photo) VALUES 
((SELECT Id_User FROM Utilisateur WHERE Prenom='Bricoleur' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Bricoleur', '101010101010', 'Maison Champignon Rouge', 'images/bricoleur.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Gourmand' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Gourmand', '010101010101', 'Maison Champignon Bleu', 'images/gourmand.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Jardinier' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Jardinier', '110011001100', 'Maison Champignon Vert', 'images/jardinier.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Coquet' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Coquet', '001100110011', 'Maison Champignon Jaune', 'images/coquet.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Costaud' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Costaud', '111000111000', 'Maison Champignon Noir', 'images/costaud.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Farceur' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Farceur', '000111000111', 'Maison Champignon Blanc', 'images/farceur.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Poète' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Poète', '101101101101', 'Maison Champignon Orange', 'images/poete.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Paysan' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Paysan', '010010010010', 'Maison Champignon Violet', 'images/paysan.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Dormeur' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Dormeur', '100100100100', 'Maison Champignon Gris', 'images/dormeur.jpg'),
((SELECT Id_User FROM Utilisateur WHERE Prenom='Peureux' AND Nom='Schtroumpf'), NULL, 'CV du Schtroumpf Peureux', '011011011011', 'Maison Champignon Rose', 'images/peureux.jpg');

INSERT INTO Laboratoire VALUES ('1','Em-009','123456789','Labo1@lab.co','Laboratoire des trois champignons', '10 rue Sextius Michel'); 

INSERT INTO ServiceLab (Nom_Service, Description_Service) VALUES 
('Dépistage covid-19', 'Test de dépistage pour le virus Covid-19'),
('Biologie préventive', 'Analyses pour prévenir les maladies'),
('Biologie de la femme enceinte', 'Tests et analyses pour les femmes enceintes'),
('Biologie de routine', 'Analyses médicales courantes'),
('Cancérologie', 'Tests et analyses pour la détection du cancer'),
('Gynécologie', 'Analyses et tests en gynécologie');

INSERT INTO Dispenses (Id_Lab, Nom_Service) VALUES 
(1, 'Dépistage covid-19'),
(1, 'Biologie préventive'),
(1, 'Biologie de la femme enceinte'),
(1, 'Biologie de routine'),
(1, 'Cancérologie'),
(1, 'Gynécologie');


