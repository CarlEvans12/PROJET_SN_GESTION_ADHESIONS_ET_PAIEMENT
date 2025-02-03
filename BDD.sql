-- Création de la base de données
CREATE DATABASE GestionAbonnements;
USE GestionAbonnements;
-- Table ADMINISTRATION
CREATE TABLE ADMINISTRATION (
    id_administration INT AUTO_INCREMENT PRIMARY KEY,
    nom_admin VARCHAR(100) NOT NULL,
    prenom_admin VARCHAR(100) NOT NULL,
    email_admin VARCHAR(150) UNIQUE NOT NULL,
    motDePasse VARCHAR(255) NOT NULL
);
-- Table MEMBRE
CREATE TABLE MEMBRE (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom_membre VARCHAR(100) NOT NULL,
    prenom_membre VARCHAR(100) NOT NULL,
    email_membre VARCHAR(150) UNIQUE NOT NULL,
    motDePasse VARCHAR(255) NOT NULL,
    photoProfil VARCHAR(255),
    telephone VARCHAR(15),
    date_naissance DATE NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut BOOLEAN DEFAULT 1,
    id_administration INT,
    CONSTRAINT fk_membre_administration FOREIGN KEY (id_administration) REFERENCES ADMINISTRATION(id_administration)
);

-- Table ABONNEMENT 
CREATE TABLE ABONNEMENT (
    id_abonnement INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    description TEXT,
    type_abonnement ENUM('mensuelle', 'trimestrielle', 'semestrielle', 'annuelle') NOT NULL, 
    statut ENUM('actif', 'inactif', 'annulé') DEFAULT 'actif',
    id_membre INT NOT NULL,
    CONSTRAINT fk_abonnement_membre FOREIGN KEY (id_membre) REFERENCES MEMBRE(id_membre)
);

-- Table PAIEMENT
CREATE TABLE PAIEMENT (
    id_paiement INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10, 2) NOT NULL,
    date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP,
    methode_paiement VARCHAR(50) NOT NULL,
    reference_transaction VARCHAR(100) UNIQUE,
    statut ENUM('en_attente', 'validé', 'refusé') DEFAULT 'en_attente',
    id_abonnement INT NOT NULL,
    CONSTRAINT fk_paiement_abonnement FOREIGN KEY (id_abonnement) REFERENCES ABONNEMENT(id_abonnement)
);

-- Table NOTIFICATION
CREATE TABLE NOTIFICATION (
    id_notif INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    date_envoie DATETIME DEFAULT CURRENT_TIMESTAMP,
    type ENUM('rappel', 'information', 'paiement'),
    statut ENUM('envoyée', 'lue') DEFAULT 'envoyée',
    id_membre INT NOT NULL,
    CONSTRAINT fk_notification_membre FOREIGN KEY (id_membre) REFERENCES MEMBRE(id_membre)
);
