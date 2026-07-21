PRAGMA foreign_keys = OFF;

DROP VIEW IF EXISTS v_operations_details;
DROP TABLE IF EXISTS operateur;
DROP TABLE IF EXISTS operations;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS baremes;
DROP TABLE IF EXISTS type_operations;
DROP TABLE IF EXISTS prefixes;
DROP TABLE IF EXISTS config;

CREATE TABLE config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cle VARCHAR(100) NOT NULL UNIQUE,
    valeur VARCHAR(255) NOT NULL,
    description TEXT
);

INSERT INTO config (cle, valeur, description) VALUES ('commission_transfert_externe', '10', 'Pourcentage de commission en plus pour les transferts vers les autres opérateurs (%)');


CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL,
    created_at TEXT
);

CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    valeur VARCHAR(20) NOT NULL,
    actif INTEGER DEFAULT 1,
    created_at TEXT
);

CREATE TABLE type_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(50) NOT NULL,
    libelle VARCHAR(100) NOT NULL,
    actif INTEGER DEFAULT 1
);

CREATE TABLE baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operateur_nom TEXT NOT NULL DEFAULT 'Yas',
    type_operation_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,
    FOREIGN KEY (type_operation_id) REFERENCES type_operations(id) ON DELETE CASCADE
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone VARCHAR(20) NOT NULL,
    solde REAL DEFAULT 0,
    actif INTEGER DEFAULT 1,
    created_at TEXT
);

CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    type_operation_id INTEGER NOT NULL,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0,
    solde_avant REAL NOT NULL,
    solde_apres REAL NOT NULL,
    destinataire VARCHAR(20),
    description TEXT,
    created_at TEXT,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (type_operation_id) REFERENCES type_operations(id) ON DELETE CASCADE
);

CREATE VIEW v_operations_details AS 
SELECT 
    o.id,
    o.client_id,
    c.telephone AS client_telephone,
    o.type_operation_id,
    t.code AS type_code,
    t.libelle AS type_libelle,
    o.montant,
    o.frais,
    o.solde_avant,
    o.solde_apres,
    o.destinataire,
    o.description,
    o.created_at
FROM operations o
JOIN clients c ON o.client_id = c.id
JOIN type_operations t ON o.type_operation_id = t.id;


INSERT INTO operateur (nom, created_at) VALUES 
('Yas', datetime('now'));

INSERT INTO prefixes (valeur, actif, created_at) VALUES 
('032', 1, datetime('now')),
('033', 1, datetime('now')),
('034', 1, datetime('now')),
('035', 1, datetime('now')),
('037', 1, datetime('now')),
('038', 1, datetime('now')),
('+261', 1, datetime('now')),
('0202', 1, datetime('now')),
('0205', 1, datetime('now')),
('0206', 1, datetime('now')),
('0207', 1, datetime('now')),
('0208', 1, datetime('now')),
('0209', 1, datetime('now'));

INSERT INTO type_operations (id, code, libelle, actif) VALUES 
(1, 'depot', 'Dépôt', 1),
(2, 'retrait', 'Retrait', 1),
(3, 'transfert', 'Transfert', 1);

INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 100, 1000, 100);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 1001, 5000, 150);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 5001, 10000, 275);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 10001, 20000, 550);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 20001, 25000, 650);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 25001, 50000, 1300);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 50001, 100000, 1900);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 100001, 250000, 3400);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 250001, 500000, 4700);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 500001, 1000000, 8800);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 1000001, 2000000, 14700);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 2000001, 3000000, 19600);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 3000001, 4000000, 24500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 4000001, 5000000, 29400);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 2, 5000001, 20000000, 50000);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 100, 1000, 70);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 1001, 5000, 70);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 5001, 10000, 150);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 10001, 25000, 250);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 25001, 50000, 500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 50001, 100000, 1000);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 100001, 250000, 1900);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 250001, 500000, 1900);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 500001, 1000000, 3200);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 1000001, 2000000, 3800);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Yas', 3, 2000001, 20000000, 5000);




INSERT INTO clients (id, telephone, solde, actif, created_at) VALUES 
(1, '0321234567', 150000, 1, datetime('now')),
(2, '0331234567', 80000, 1, datetime('now')),
(3, '0341234567', 250000, 1, datetime('now')),
(4, '0329876543', 50000, 1, datetime('now')),
(5, '0339876543', 120000, 1, datetime('now')),
(6, '0349876543', 300000, 1, datetime('now'));

INSERT INTO operations (client_id, type_operation_id, montant, frais, solde_avant, solde_apres, destinataire, description, created_at) VALUES
(1, 1, 50000, 0, 80000, 130000, NULL, 'Depot de 50 000 Ar', datetime('now', '-2 days')),
(2, 2, 20000, 550, 100550, 80000, NULL, 'Retrait de 20 000 Ar', datetime('now', '-1 day')),
(3, 3, 50000, 500, 322750, 272250, '0349876543', 'Transfert vers 0349876543', datetime('now', '-5 hours')),
(6, 3, 50000, 0, 250000, 300000, '0341234567', 'Réception de 0341234567 — 50 000 Ar', datetime('now', '-5 hours')),
(3, 3, 20000, 2250, 272250, 250000, '0321234567', 'Transfert vers 0321234567 (Inter-opérateur)', datetime('now', '-2 hours')),
(1, 3, 20000, 0, 130000, 150000, '0341234567', 'Réception de 0341234567 — 20 000 Ar', datetime('now', '-2 hours'));

INSERT INTO config (cle,valeur,description) VALUES ('promotion_transfert_meme_operateur', '10', 'Pourcentage de reduction sur les frais de transfert de meme operateur (%)');

PRAGMA foreign_keys = ON;