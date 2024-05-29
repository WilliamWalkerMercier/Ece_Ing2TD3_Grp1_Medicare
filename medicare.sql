-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 mai 2024 à 22:22
-- Version du serveur : 8.0.35
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `medicare`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `Id_Client` int NOT NULL,
  `Type_Carte` varchar(50) DEFAULT NULL,
  `Num_Cb` int DEFAULT NULL,
  `Date_Expiration` date DEFAULT NULL,
  `Code_Securite` int DEFAULT NULL,
  `Solde` int DEFAULT NULL,
  PRIMARY KEY (`Id_Client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`Id_Client`, `Type_Carte`, `Num_Cb`, `Date_Expiration`, `Code_Securite`, `Solde`) VALUES
(44, 'Visa', 1111233444, '2026-05-29', 123, 1000),
(45, 'MasterCard', 44441111, '2025-11-15', 456, 1500),
(46, 'American Express', 57778888, '2024-07-23', 789, 500),
(47, 'Discover', 99998766, '2027-01-01', 321, 800),
(48, 'Visa', 33334566, '2028-03-17', 654, 2000);

-- --------------------------------------------------------

--
-- Structure de la table `dispenses`
--

DROP TABLE IF EXISTS `dispenses`;
CREATE TABLE IF NOT EXISTS `dispenses` (
  `Id_Lab` int NOT NULL,
  `Nom_Service` varchar(100) NOT NULL,
  PRIMARY KEY (`Id_Lab`,`Nom_Service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `dispenses`
--

INSERT INTO `dispenses` (`Id_Lab`, `Nom_Service`) VALUES
(1, 'Biologie de la femme enceinte'),
(1, 'Biologie de routine'),
(1, 'Biologie preventive'),
(1, 'Cancerologie'),
(1, 'Depistage covid-19'),
(1, 'Gynecologie');

-- --------------------------------------------------------

--
-- Structure de la table `laboratoire`
--

DROP TABLE IF EXISTS `laboratoire`;
CREATE TABLE IF NOT EXISTS `laboratoire` (
  `Id_Lab` int NOT NULL AUTO_INCREMENT,
  `Salle` varchar(50) DEFAULT NULL,
  `Telephone` int DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Nom` varchar(100) DEFAULT NULL,
  `Adresse` varchar(100) DEFAULT NULL,
  `Photo` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Lab`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `laboratoire`
--

INSERT INTO `laboratoire` (`Id_Lab`, `Salle`, `Telephone`, `Email`, `Nom`, `Adresse`, `Photo`) VALUES
(1, 'Em-009', 123456789, 'Labo1@lab.co', 'Laboratoire des trois champignons', '10 rue Sextius Michel', 'images/laboratoire.png');

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin` (
  `Id_Medecin` int NOT NULL,
  `Specialite` varchar(100) DEFAULT NULL,
  `CV` varchar(100) DEFAULT NULL,
  `Disponibilite` varchar(12) DEFAULT NULL,
  `Bureau` varchar(50) DEFAULT NULL,
  `Photo` varchar(100) DEFAULT NULL,
  `Photo2` varchar(50) DEFAULT NULL,
  `Photo3` varchar(50) DEFAULT NULL,
  `video` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Medecin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`Id_Medecin`, `Specialite`, `CV`, `Disponibilite`, `Bureau`, `Photo`, `Photo2`, `Photo3`, `video`) VALUES
(61, 'Addictologie', 'CV de Jean Dupont', '111001011110', 'sc-200', 'images/dupont.jpg', NULL, NULL, NULL),
(62, 'Addictologie', 'CV de Marie Lefevre', '101110011101', 'em-250', 'images/lefevre.jpg', NULL, NULL, NULL),
(63, 'Andrologie', 'CV de François Durand', '111001011110', 'sc-201', 'images/durand.jpg', NULL, NULL, NULL),
(64, 'Andrologie', 'CV de Sophie Lemoine', '101110011101', 'em-251', 'images/sophie.jpg', NULL, NULL, NULL),
(65, 'Cardiologie', 'CV de Nicolas Girard', '111100011110', 'em-202', 'images/nicolas.jpg', NULL, NULL, NULL),
(66, 'Orthopediste', 'CV de Jonathan Kouy', '101101111101', 'sc-252', 'images/jonathan.jpg', NULL, NULL, NULL),
(67, 'Dermatologie', 'CV de Thomas Roux', '110110100011', 'em-302', 'images/roux.jpg', NULL, NULL, NULL),
(68, 'Gastro- Hepato-Enterologie', 'CV de Jean Lefevre', '110011001100', 'sc-200', 'images/jean.jpg', NULL, NULL, NULL),
(69, 'Gastro- Hepato-Enterologie', 'CV de Marie Martin', '101100110011', 'em-201', 'images/martin.jpg', NULL, NULL, NULL),
(70, 'Gynecologie', 'CV de Sophie Leroy', '001100110011', 'em-203', 'images/sophie.jpg', NULL, NULL, NULL),
(71, 'Gynecologie', 'CV de Nicolas Roux', '110011001100', 'sc-204', 'images/roux.jpg', NULL, NULL, NULL),
(72, 'I.S.T.', 'CV de Jean Lefevre', '110011001100', 'sc-200', 'images/jean.jpg', NULL, NULL, NULL),
(73, 'I.S.T.', 'CV de Marie Martin', '101100110011', 'em-201', 'images/marie.jpg', NULL, NULL, NULL),
(74, 'Osteopathie', 'CV de Sophie Leroy', '001100110011', 'em-203', 'images/sophie.jpg', NULL, NULL, NULL),
(75, 'Osteopathie', 'CV de Nicolas Roux', '110011001100', 'sc-204', 'images/roux.jpg', NULL, NULL, NULL),
(76, 'Generaliste', 'CV du Schtroumpf Bricoleur', '101010101010', 'Maison Champignon Rouge', 'images/bricoleur.jpg', NULL, NULL, NULL),
(77, 'Generaliste', 'CV du Schtroumpf Gourmand', '010101010101', 'Maison Champignon Bleu', 'images/gourmand.jpg', NULL, NULL, NULL),
(78, 'Generaliste', 'CV du Schtroumpf Jardinier', '110011001100', 'Maison Champignon Vert', 'images/jardinier.jpg', NULL, NULL, NULL),
(79, 'Generaliste', 'CV du Schtroumpf Coquet', '001100110011', 'Maison Champignon Jaune', 'images/coquet.jpg', NULL, NULL, NULL),
(80, 'Generaliste', 'CV du Schtroumpf Costaud', '111000111000', 'Maison Champignon Noir', 'images/costaud.jpg', NULL, NULL, NULL),
(81, 'Generaliste', 'CV du Schtroumpf Farceur', '000111000111', 'Maison Champignon Blanc', 'images/farceur.jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
CREATE TABLE IF NOT EXISTS `rdv` (
  `Id_Client` int NOT NULL,
  `Id_Medecin` int NOT NULL,
  `Id_Lab` int NOT NULL,
  `Nom_Service` varchar(100) NOT NULL,
  `Date_Heure` datetime NOT NULL,
  PRIMARY KEY (`Id_Client`,`Id_Medecin`,`Id_Lab`,`Nom_Service`,`Date_Heure`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `servicelab`
--

DROP TABLE IF EXISTS `servicelab`;
CREATE TABLE IF NOT EXISTS `servicelab` (
  `Nom_Service` varchar(100) NOT NULL,
  `Description_Service` varchar(1024) DEFAULT NULL,
  `Photo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Nom_Service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `servicelab`
--

INSERT INTO `servicelab` (`Nom_Service`, `Description_Service`, `Photo`) VALUES
('Biologie de la femme enceinte', 'Tests et analyses pour les femmes enceintes', 'images/enceinte.png'),
('Biologie de routine', 'Analyses medicales courantes', 'images/biologie.png'),
('Biologie preventive', 'Analyses pour prevenir les maladies', 'images/preventive.png'),
('Cancerologie', 'Tests et analyses pour la detection du cancer', 'images/cancer.png'),
('Depistage covid-19', 'Test de depistage pour le virus Covid-19', 'images/covid.png'),
('Gynecologie', 'Analyses et tests en gynecologie', 'images/gynecologie.png');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Id_User` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) DEFAULT NULL,
  `Prenom` varchar(100) DEFAULT NULL,
  `Mail` varchar(100) DEFAULT NULL,
  `Telephone` int DEFAULT NULL,
  `Mdp` varchar(255) DEFAULT NULL,
  `Type` int DEFAULT NULL,
  `Pays` varchar(50) DEFAULT NULL,
  `Ville` varchar(100) DEFAULT NULL,
  `Code_Postal` int DEFAULT NULL,
  `Adresse1` varchar(100) DEFAULT NULL,
  `Adresse2` varchar(100) DEFAULT NULL,
  `Carte_Vitale` int DEFAULT NULL,
  PRIMARY KEY (`Id_User`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_User`, `Nom`, `Prenom`, `Mail`, `Telephone`, `Mdp`, `Type`, `Pays`, `Ville`, `Code_Postal`, `Adresse1`, `Adresse2`, `Carte_Vitale`) VALUES
(61, 'Dupont', 'Jean', 'jean.dupont@medecine.ece.fr', 123456789, 'password123456789012345', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Lefevre', 'Marie', 'marie.lefevre@medecine.ece.fr', 234567891, 'password223456789012345', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'Durand', 'François', 'francois.durand@medecine.ece.fr', 123456789, 'password123456789012345', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Lemoine', 'Sophie', 'sophie.lemoine@medecine.ece.fr', 234567891, 'password223456789012345', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Girard', 'Nicolas', 'nicolas.girard@medecine.ece.fr', 456789123, 'password423456789012345', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Kouy', 'Jonathan', 'jonathan.kouy@medecine.ece.fr', 567891234, 'password523456789012345', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Roux', 'Thomas', 'thomas.roux@medecine.ece.fr', 678912345, 'password623456789012345', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Lermite', 'Bernard', 'Bernard.lermite@medecine.ece.fr', 314159265, 'abcde12345abcde12345abcde1', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Martin', 'Marie', 'marie.martin@medecine.ece.fr', 234567891, 'bcdef23456bcdef23456bcdef2', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Leroy', 'Sophie', 'sophie.leroy@medecine.ece.fr', 456789123, 'defgh45678defgh45678defgh4', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'Roux', 'Nicolas', 'nicolas.roux@medecine.ece.fr', 567891234, 'efghi56789efghi56789efghi5', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Lefevre', 'Jean', 'jean.lefevre@medecine.ece.fr', 123456789, 'abcde12345abcde12345abcde1', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Martin', 'Marie', 'marie.martin@medecine.ece.fr', 234567891, 'bcdef23456bcdef23456bcdef2', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Leroy', 'Sophie', 'sophie.leroy@medecine.ece.fr', 456789123, 'defgh45678defgh45678defgh4', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Roux', 'Nicolas', 'nicolas.roux@medecine.ece.fr', 567891234, 'efghi56789efghi56789efghi5', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Schtroumpf', 'Bricoleur', 'bricoleur.schtroumpf@Gargamel.medecine.fr', 678392451, 'Abc123def456ghi', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 1', 'Lieu-dit', NULL),
(77, 'Schtroumpf', 'Gourmand', 'gourmand.schtroumpf@Gargamel.medecine.fr', 678234951, 'Def456ghi789jkl', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 2', 'Lieu-dit', NULL),
(78, 'Schtroumpf', 'Jardinier', 'jardinier.schtroumpf@Gargamel.medecine.fr', 678234591, 'Ghi789jkl012mno', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 3', 'Lieu-dit', NULL),
(79, 'Schtroumpf', 'Coquet', 'coquet.schtroumpf@Gargamel.medecine.fr', 678234952, 'Jkl012mno345pqr', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 4', 'Lieu-dit', NULL),
(80, 'Schtroumpf', 'Costaud', 'costaud.schtroumpf@Gargamel.medecine.fr', 678234953, 'Mno345pqr678stu', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 5', 'Lieu-dit', NULL),
(81, 'Schtroumpf', 'Farceur', 'farceur.schtroumpf@Gargamel.medecine.fr', 678234954, 'Pqr678stu901vwx', 1, 'Pays des Schtroumpfs', 'Village des Schtroumpfs', 12345, 'Maison Champignon 6', 'Lieu-dit', NULL),
(82, 'Vader', 'Anakin', 'anakin.vader@empire.com', 111222333, 'darkside123', 0, 'Tatooine', 'Mos Eisley', 12345, 'Rue des Siths', 'Appartement 66', 987654321),
(83, 'Solo', 'Kylo', 'kylo.solo@firstorder.com', 444555666, 'darkness456', 0, 'Unknown', 'Unknown', 0, 'Unknown', 'Unknown', 123456789),
(84, 'Maul', 'Darth', 'darth.maul@sith.com', 777888999, 'doubleblade789', 0, 'Dathomir', 'Nightbrother Village', 54321, 'Dark Side Alley', 'Cave 13', 987654321),
(85, 'Tano', 'Ahsoka', 'ahsoka.tano@jediorder.com', 888999000, 'fulcrum123', 0, 'Shili', 'Jedi Temple', 11122, 'Padawan Lane', 'Room 7', 456789012),
(86, 'Fett', 'Boba', 'boba.fett@bountyhunters.com', 222333444, 'mandalorian456', 0, 'Kamino', 'Tipoca City', 33344, 'Clone Way', 'Block 27', 234567890),
(87, 'R2D2', NULL, NULL, NULL, NULL, 0, 'Tatooine', 'Mos Eisley', 12345, 'Droid St0eet', NULL, NULL),
(88, 'C3PO', NULL, NULL, NULL, NULL, 0, 'Tatooine', 'Mos Eisley', 12345, 'Droid Avenue', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
