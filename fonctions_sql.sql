-- ============================
-- 1. CREATION D'INDEXES POUR OPTIMISATION
-- ============================
CREATE INDEX idx_membre_email ON MEMBRE(email_membre);
CREATE INDEX idx_paiement_date ON PAIEMENT(date_paiement);
CREATE INDEX idx_abonnement_statut ON ABONNEMENT(statut);

-- ============================
-- 2. VUES POUR FACILITER L'ACCES AUX DONNEES
-- ============================
CREATE VIEW Vue_Abonnements_Actifs AS
SELECT A.id_abonnement, A.date_debut, A.date_fin, A.type_abonnement, M.nom_membre, M.prenom_membre
FROM ABONNEMENT A
JOIN MEMBRE M ON A.id_membre = M.id_membre
WHERE A.statut = 'actif';

CREATE VIEW Vue_Paiements_Valides AS
SELECT P.id_paiement, P.montant, P.date_paiement, P.methode_paiement, M.nom_membre, M.prenom_membre
FROM PAIEMENT P
JOIN ABONNEMENT A ON P.id_abonnement = A.id_abonnement
JOIN MEMBRE M ON A.id_membre = M.id_membre
WHERE P.statut = 'validé';

-- ============================
-- 3. TRIGGERS POUR AUTOMATISER LES MISES A JOUR
-- ============================
-- Désactiver automatiquement un abonnement expiré
DELIMITER $$

CREATE TRIGGER tr_abonnement_expire
BEFORE UPDATE ON ABONNEMENT
FOR EACH ROW
BEGIN
    IF NEW.date_fin < CURDATE() THEN
        SET NEW.statut = 'inactif';
    END IF;
END$$

DELIMITER ;


-- Enregistrer l'historique des paiements
CREATE TABLE HISTORIQUE_PAIEMENT (
    id_historique INT AUTO_INCREMENT PRIMARY KEY,
    id_paiement INT,
    montant DECIMAL(10,2),
    date_paiement DATETIME,
    statut VARCHAR(50),
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELIMITER $$

CREATE TRIGGER tr_paiement_historique
AFTER UPDATE ON PAIEMENT
FOR EACH ROW
BEGIN
    INSERT INTO HISTORIQUE_PAIEMENT (id_paiement, montant, date_paiement, statut)
    VALUES (OLD.id_paiement, OLD.montant, OLD.date_paiement, OLD.statut);
END$$

DELIMITER ;

-- ============================
-- 4. PROCEDURES STOCKEES
-- ============================
-- Ajouter un nouvel abonnement
DELIMITER $$
CREATE PROCEDURE Ajouter_Abonnement(
    IN p_id_membre INT,
    IN p_date_debut DATE,
    IN p_date_fin DATE,
    IN p_type_abonnement ENUM('mensuelle', 'trimestrielle', 'semestrielle', 'annuelle')
)
BEGIN
    INSERT INTO ABONNEMENT (id_membre, date_debut, date_fin, type_abonnement, statut)
    VALUES (p_id_membre, p_date_debut, p_date_fin, p_type_abonnement, 'actif');
END $$
DELIMITER ;

-- Effectuer un paiement sécurisé avec gestion d'erreur
DELIMITER $$

CREATE PROCEDURE Effectuer_Paiement(
    IN p_id_abonnement INT,
    IN p_montant DECIMAL(10,2),
    IN p_methode_paiement VARCHAR(50),
    IN p_reference_transaction VARCHAR(100)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Erreur lors de l''ajout du paiement'; -- Échapper l'apostrophe ici
    END;
    
    START TRANSACTION;
    INSERT INTO PAIEMENT (id_abonnement, montant, methode_paiement, reference_transaction, statut)
    VALUES (p_id_abonnement, p_montant, p_methode_paiement, p_reference_transaction, 'en_attente');
    COMMIT;
END$$

DELIMITER ;

-- ============================
-- 5. GESTION DES UTILISATEURS ET ROLES
-- ============================
-- Création d'un rôle ADMIN
CREATE ROLE admin;
GRANT ALL PRIVILEGES ON GestionAbonnements.* TO admin;

-- Création d'un rôle UTILISATEUR
CREATE ROLE utilisateur;
GRANT SELECT, INSERT, UPDATE ON MEMBRE TO utilisateur;
GRANT SELECT, INSERT ON ABONNEMENT TO utilisateur;

-- Ajout d'un administrateur
CREATE USER 'admin1'@'localhost' IDENTIFIED BY 'password';
GRANT admin TO 'admin1'@'localhost';

-- Ajout d'un utilisateur standard
CREATE USER 'user1'@'localhost' IDENTIFIED BY 'password';
GRANT utilisateur TO 'user1'@'localhost';
