-- =====================================================================
-- base.sql
-- Système de simulation d'opérateur Mobile Money
-- Base de données : SQLite
-- Contient : création des tables, vues et données de démarrage
-- Version 1 + Version 2 (fichier unique, mis à jour à chaque livraison)
-- =====================================================================

PRAGMA foreign_keys = ON;

-- ---------------------------------------------------------------------
-- Table des opérateurs (comptes back-office)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS operateurs;
CREATE TABLE operateurs (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    nom        VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------------
-- Table des préfixes.
-- type = 'interne'  -> préfixes de notre opérateur (ex: 033, 037)
-- type = 'externe'  -> préfixes des autres opérateurs (ex: 032, 031)
--                      operateur_nom identifie l'opérateur concurrent
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS prefixes;
CREATE TABLE prefixes (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe        VARCHAR(5) NOT NULL UNIQUE,
    type           VARCHAR(10) NOT NULL DEFAULT 'interne',   -- interne | externe
    operateur_nom  VARCHAR(100) NULL,                        -- rempli seulement si type = externe
    actif          INTEGER NOT NULL DEFAULT 1,
    created_at     DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------------
-- Table des types d'opération (dépôt, retrait, transfert)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS types_operation;
CREATE TABLE types_operation (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    code    VARCHAR(20) NOT NULL UNIQUE,   -- depot | retrait | transfert
    libelle VARCHAR(50) NOT NULL
);

-- ---------------------------------------------------------------------
-- Table des barèmes de frais par tranche de montant (modifiable)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS baremes;
CREATE TABLE baremes (
    id                INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min       DECIMAL(15,2) NOT NULL,
    montant_max       DECIMAL(15,2) NOT NULL,
    frais             DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id) ON DELETE CASCADE
);

-- ---------------------------------------------------------------------
-- Table des paramètres généraux (clé / valeur), ex: commission externe
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS parametres;
CREATE TABLE parametres (
    id     INTEGER PRIMARY KEY AUTOINCREMENT,
    cle    VARCHAR(100) NOT NULL UNIQUE,
    valeur VARCHAR(255) NOT NULL
);

-- ---------------------------------------------------------------------
-- Table des clients (créés automatiquement à la première connexion)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS clients;
CREATE TABLE clients (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone  VARCHAR(20) NOT NULL UNIQUE,
    solde      DECIMAL(15,2) NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------------------
-- Table des transactions (historique dépôt / retrait / transfert)
-- destination_type : 'interne' (vers un client de notre opérateur)
--                     ou 'externe' (vers un numéro d'un autre opérateur)
-- commission_externe : commission additionnelle (%) prélevée uniquement
--                       sur les transferts vers les autres opérateurs
-- frais_retrait_inclus : montant supplémentaire envoyé par l'expéditeur
--                         pour couvrir le futur frais de retrait du
--                         destinataire (option "inclure frais de retrait")
-- lot_id : regroupe les transactions d'un même envoi multiple
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS transactions;
CREATE TABLE transactions (
    id                    INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id             INTEGER NOT NULL,
    type_operation_id     INTEGER NOT NULL,
    montant               DECIMAL(15,2) NOT NULL,
    frais                 DECIMAL(15,2) NOT NULL DEFAULT 0,
    commission_externe    DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_retrait_inclus  DECIMAL(15,2) NOT NULL DEFAULT 0,
    destination_type      VARCHAR(10) NULL,          -- interne | externe (transfert uniquement)
    destinataire_id       INTEGER NULL,               -- rempli seulement si destinataire = client interne
    destinataire_telephone VARCHAR(20) NULL,          -- toujours rempli pour un transfert
    lot_id                VARCHAR(50) NULL,
    solde_apres           DECIMAL(15,2) NOT NULL,
    date_creation         DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id),
    FOREIGN KEY (destinataire_id) REFERENCES clients(id)
);

-- ---------------------------------------------------------------------
-- Vue : gains de l'opérateur (frais perçus) par type d'opération,
-- avec séparation interne / vers autres opérateurs pour les transferts
-- ---------------------------------------------------------------------
DROP VIEW IF EXISTS v_gains_par_type;
CREATE VIEW v_gains_par_type AS
SELECT
    t.code               AS type_code,
    t.libelle            AS type_libelle,
    COUNT(tr.id)          AS nb_operations,
    COALESCE(SUM(tr.frais + tr.commission_externe), 0) AS total_frais
FROM types_operation t
LEFT JOIN transactions tr ON tr.type_operation_id = t.id
GROUP BY t.id;

DROP VIEW IF EXISTS v_gains_detail;
CREATE VIEW v_gains_detail AS
SELECT
    t.code                                              AS type_code,
    t.libelle                                           AS type_libelle,
    COALESCE(tr.destination_type, 'interne')            AS destination_type,
    COUNT(tr.id)                                        AS nb_operations,
    COALESCE(SUM(tr.frais), 0)                          AS total_frais_base,
    COALESCE(SUM(tr.commission_externe), 0)             AS total_commission_externe,
    COALESCE(SUM(tr.frais + tr.commission_externe), 0)  AS total_gains
FROM transactions tr
JOIN types_operation t ON t.id = tr.type_operation_id
WHERE t.code IN ('retrait', 'transfert')
GROUP BY t.id, destination_type;

-- ---------------------------------------------------------------------
-- Vue : situation des comptes clients
-- ---------------------------------------------------------------------
DROP VIEW IF EXISTS v_situation_clients;
CREATE VIEW v_situation_clients AS
SELECT
    c.id,
    c.telephone,
    c.solde,
    c.created_at,
    (SELECT COUNT(*) FROM transactions t WHERE t.client_id = c.id) AS nb_transactions
FROM clients c;

-- ---------------------------------------------------------------------
-- Vue : montants à envoyer (à régler) à chaque autre opérateur, sur la
-- base des transferts sortants effectués par nos clients vers leurs
-- préfixes.
-- ---------------------------------------------------------------------
DROP VIEW IF EXISTS v_montants_a_envoyer;
CREATE VIEW v_montants_a_envoyer AS
SELECT
    p.operateur_nom                    AS operateur_nom,
    COUNT(tr.id)                       AS nb_transferts,
    COALESCE(SUM(tr.montant), 0)       AS total_montant
FROM transactions tr
JOIN prefixes p
    ON p.type = 'externe'
   AND substr(tr.destinataire_telephone, 1, length(p.prefixe)) = p.prefixe
WHERE tr.destination_type = 'externe'
GROUP BY p.operateur_nom;

-- =====================================================================
-- DONNEES DE DEMARRAGE
-- =====================================================================

-- Compte opérateur par défaut : username = admin / mot de passe = admin123
INSERT INTO operateurs (username, password, nom) VALUES
('admin', '$2b$12$RNHStNA2AaRCSYBBNDCl/OiBo2H27jQoPykFLzrOEobjggAnFpLxy', 'Administrateur');

-- Préfixes valables de notre opérateur (v1)
INSERT INTO prefixes (prefixe, type, operateur_nom, actif) VALUES
('033', 'interne', NULL, 1),
('037', 'interne', NULL, 1);

-- Préfixes des autres opérateurs (v2)
INSERT INTO prefixes (prefixe, type, operateur_nom, actif) VALUES
('032', 'externe', 'Opérateur A', 1),
('031', 'externe', 'Opérateur B', 1);

-- Types d'opération
INSERT INTO types_operation (code, libelle) VALUES
('depot', 'Dépôt'),
('retrait', 'Retrait'),
('transfert', 'Transfert');

-- Barème de frais pour le RETRAIT (type_operation_id = 2)
INSERT INTO baremes (type_operation_id, montant_min, montant_max, frais) VALUES
(2, 100,       1000,      50),
(2, 1001,      5000,      50),
(2, 5001,      10000,     100),
(2, 10001,     25000,     200),
(2, 25001,     50000,     400),
(2, 50001,     100000,    800),
(2, 100001,    250000,    1500),
(2, 250001,    500000,    1500),
(2, 500001,    1000000,   2500),
(2, 1000001,   2000000,   3000);

-- Barème de frais pour le TRANSFERT (type_operation_id = 3)
INSERT INTO baremes (type_operation_id, montant_min, montant_max, frais) VALUES
(3, 100,       1000,      50),
(3, 1001,      5000,      50),
(3, 5001,      10000,     100),
(3, 10001,     25000,     200),
(3, 25001,     50000,     400),
(3, 50001,     100000,    800),
(3, 100001,    250000,    1500),
(3, 250001,    500000,    1500),
(3, 500001,    1000000,   2500),
(3, 1000001,   2000000,   3000);

-- Le DEPOT n'a pas de frais (aucune ligne de barème = 0 Ar de frais)

-- Paramètre v2 : commission additionnelle (%) sur les transferts vers
-- les autres opérateurs, en plus du barème de frais normal.
INSERT INTO parametres (cle, valeur) VALUES
('commission_externe_pourcentage', '2');
