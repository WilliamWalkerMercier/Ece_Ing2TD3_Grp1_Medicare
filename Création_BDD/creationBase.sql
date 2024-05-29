CREATE TABLE Utilisateur(
    Id_User int primary key not null AUTO_INCREMENT,
    Nom varchar(100),
    Prenom varchar(100),
    Mail varchar(100),
    Telephone int,
    Mdp varchar(255),
    Type int
);
CREATE TABLE Medecin(
    Id_Medecin int primary key not null references Utilisateur(Id_User),
    Specialite Varchar(100),
    CV varchar(100),
    Disponibilite varchar(12),
    Bureau varchar(50),
    Photo varchar(100)
);
CREATE TABLE Client(
    Id_Client int primary key not null references Utilisateur(Id_User),
    Type_Carte varchar(50),
    Num_Cb int,
    Date_Expiration date,
    Code_Securite int
);
CREATE TABLE ServiceLab(
    Nom_Service varchar(100) primary key not null,
    Description_Service varchar(1024)
);
Create TABLE Laboratoire(
    Id_Lab int primary key not null AUTO_INCREMENT,
    Salle varchar(50),
    Telephone int,
    Email varchar(100),
    Nom Varchar(100),
    Adresse varchar(100)
);
CREATE TABLE Dispenses(
    Id_Lab int not null,
    Nom_Service varchar(100) not null,
    primary key(Id_Lab,Nom_Service)
);
CREATE TABLE RDV(
    Id_Client int not null references Medecin(Id_Medecin),
    Id_Medecin int not null references Client(Id_Client),
    Id_Lab int not null references Laboratoire(Id_Lab),
    Nom_Service varchar(100) references ServiceLab(Nom_Service),
    Date_Heure datetime,
    primary key (Id_Client,Id_Medecin,Id_Lab,Nom_Service,Date_Heure)
);

ALTER TABLE Utilisateur ADD (Pays Varchar(50),Ville Varchar(100),Code_Postal int, Adresse1 Varchar(100), Adresse2 Varchar(100));
ALTER TABLE Client ADD Solde INT;
ALTER TABLE Utilisateur ADD Carte_Vitale INT;