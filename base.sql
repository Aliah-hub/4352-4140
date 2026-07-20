PRAGMA foreign_keys = OFF;

DROP VIEW IF EXISTS v_operations_details;
DROP TABLE IF EXISTS operateur;
DROP TABLE IF EXISTS operations;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS baremes;
DROP TABLE IF EXISTS type_operations;
DROP TABLE IF EXISTS prefixes;


CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
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
    nom VARCHAR(100),
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
    c.nom AS client_nom,
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

-- Mot de passe en clair pour "admin123"
INSERT INTO operateur (nom, password, created_at) VALUES 
('Opérateur', 'admin123', datetime('now'));

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

-- Insertion des types d'opérations
INSERT INTO type_operations (id, code, libelle, actif) VALUES 
(1, 'depot', 'Dépôt', 1),
(2, 'retrait', 'Retrait', 1),
(3, 'transfert', 'Transfert', 1);

-- Insertion des barèmes pour chaque opérateur
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
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 0, 100000, 700);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 0, 100000, 700);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 100001, 150000, 1050);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 100001, 150000, 1050);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 150001, 200000, 1400);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 150001, 200000, 1400);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 200001, 250000, 1750);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 200001, 250000, 1750);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 250001, 300000, 2100);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 250001, 300000, 2100);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 300001, 400000, 2800);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 300001, 400000, 2800);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 400001, 500000, 3500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 400001, 500000, 3500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 500001, 750000, 5250);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 500001, 750000, 5250);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 750001, 1000000, 7000);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 750001, 1000000, 7000);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 1000001, 1500000, 10500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 1000001, 1500000, 10500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 2, 1500001, 2000000, 14000);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Orange', 3, 1500001, 2000000, 14000);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 0, 1000, 100);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 0, 1000, 50);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 1001, 5000, 150);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 1001, 5000, 50);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 5001, 10000, 275);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 5001, 10000, 100);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 10001, 20000, 550);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 10001, 20000, 200);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 20001, 25000, 650);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 20001, 25000, 300);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 25001, 30000, 1300);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 25001, 30000, 300);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 30001, 40000, 1300);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 30001, 40000, 400);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 40001, 50000, 1300);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 40001, 50000, 600);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 50001, 60000, 1900);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 50001, 60000, 600);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 60001, 80000, 1900);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 60001, 80000, 800);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 80001, 100000, 1900);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 80001, 100000, 800);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 100001, 150000, 3400);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 100001, 150000, 1500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 150001, 250000, 3400);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 150001, 250000, 1500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 250001, 500000, 4700);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 250001, 500000, 1500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 500001, 1000000, 8800);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 500001, 1000000, 2500);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 1000001, 2000000, 14700);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 1000001, 2000000, 3000);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 2, 2000001, 3000000, 19600);
INSERT INTO baremes (operateur_nom, type_operation_id, montant_min, montant_max, frais) VALUES ('Airtel', 3, 2000001, 3000000, 3000);



INSERT INTO clients (telephone, nom, solde, actif, created_at) VALUES 
('0321234567', 'Alice', 150000, 1, datetime('now')),
('0331234567', 'Bob', 80000, 1, datetime('now'));

PRAGMA foreign_keys = ON;