create database if not exists librairieDB_v2;
use librairieDB_v2;
-- ==========================================================
-- TABLE PRODUIT
-- ==========================================================
CREATE TABLE produit (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    code_barre VARCHAR(50) UNIQUE,
    libelle VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    remise DECIMAL(5,2) DEFAULT 0,
    image_url VARCHAR(255),
    description varchar(255) default '',
    rating DECIMAL(3,2) DEFAULT 0,
    nombre_rater INT DEFAULT 0,
    categorie VARCHAR(100),
    marque VARCHAR(100),
    quantite_stock INT DEFAULT 0,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- ==========================================================
-- TABLE SAC : sac est un produit
-- ==========================================================
CREATE TABLE collection (
    id_produit INT PRIMARY KEY,
    genre ENUM('garçon','fille','mixte'),
    type ENUM('panier','trousse','sac a dos','sac a chariot' , 'chariot'),
    niveau_scolaire ENUM(
        'Préscolaire',
        '1ère Primaire',
        '2ème Primaire',
        '3ème Primaire',
        '4ème Primaire',
        '5ème Primaire',
        '6ème Primaire',
        '7ème Base',
        '8ème Base',
        '9ème Base',
        '1ère Secondaire',
        '2ème Secondaire',
        '3ème Secondaire',
        '4ème Secondaire'
    ),
    couleur VARCHAR(50),
	marque varchar(50),
    matiere VARCHAR(100),
    roulettes BOOLEAN DEFAULT FALSE,
    nombre_compartiments INT,
    CONSTRAINT fk_sac_produit
        FOREIGN KEY (id_produit)
        REFERENCES produit(id_produit)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
-- ==========================================================
-- TABLE LIVRE : livre est un produit
-- ==========================================================
CREATE TABLE livre (
    id_produit INT PRIMARY KEY,
    niveau_scolaire ENUM(
        'Préscolaire',
        '1ère Primaire',
        '2ème Primaire',
        '3ème Primaire',
        '4ème Primaire',
        '5ème Primaire',
        '6ème Primaire',
        '7ème Base',
        '8ème Base',
        '9ème Base',
        '1ère Secondaire',
        '2ème Secondaire',
        '3ème Secondaire',
        '4ème Secondaire'
    ),
    matiere varchar(255) ,
    CONSTRAINT fk_livre_produit
        FOREIGN KEY (id_produit)
        REFERENCES produit(id_produit)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
-- ==========================================================
-- TABLE PARASCOLAIRE : parascolaire est un livre
-- ==========================================================
CREATE TABLE parascolaire (
    id_produit INT PRIMARY KEY,
    type_parascolaire VARCHAR(100),
    collection VARCHAR(100),
    CONSTRAINT fk_parascolaire_livre
        FOREIGN KEY (id_produit)
        REFERENCES livre(id_produit)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ==========================================================
-- TABLE PACK : pack est un produit
-- ==========================================================

create table pack(
	id_pack int ,
    `type` varchar(255) check (type in ("livre","fourniture")),
	categorie varchar(255) check(categorie in ("primaire","college","secondaire","bac")),
    annee_scolaire varchar(255),
    primary key(id_pack),
    foreign key (id_pack) references produit(id_produit) on delete cascade on update cascade
);
show columns from pack;
-- ==========================================================
-- TABLE PACKARTICLE
-- ==========================================================
create table packArticle(
	id_pack int,
    id_produit int ,
    quantite int default 1,
    primary key(id_pack, id_produit),
    foreign key(id_pack) references produit(id_produit) on delete cascade on update cascade,
    foreign key(id_produit) references produit(id_produit) on delete cascade on update cascade
);
-- ==========================================================
-- TABLE CLIENT
-- ==========================================================
create table client(
	id_client int auto_increment primary key,
    nom varchar(50),
    prenom varchar(50),
    tel varchar(50),
    email varchar(100) check (email like "%@gmail.com")unique not null,
    addresse varchar(100) ,
	password varchar(255) not null ,
    role varchar(50) check(role in("client","admin")) default 'client'
);
-- ==========================================================
-- TABLE COMMANDE
-- ==========================================================
create table commande(
	id_commande int auto_increment primary key,
    id_client int,
    date_commande datetime not null,
	statut varchar(50) check(statut in('attente','confirmée','annulée','livrée')),
    adresse varchar(255) not null,
    ville varchar(100),
    code_postal varchar(20),
    prix_totale decimal(8,3),
    commentaire varchar(255),
    foreign key(id_client) references client(id_client)
);

-- ==========================================================
-- TABLE LIGNE COMMANDE
-- ==========================================================
create table ligne_commande(
    id_commande int references commande(id_commande),
    id_produit int references produit(id_produit) , 
    quantite int not null,
    sous_total decimal(8,3),
    primary key(id_commande,id_produit),
    foreign key(id_commande) references commande(id_commande) on delete cascade on update cascade,
    foreign key(id_produit) references produit(id_produit) on delete cascade on update cascade
    
);

-- ==========================================================
-- TABLE USER LOGIN
-- ==========================================================
create table userLogin(
    id int auto_increment,
    id_client int not null,
    loginAt datetime not null default current_timestamp,
    primary key(id),
    foreign key(id_client) references client(id_client)
);

-- ==========================================================
-- TABLE Games LOGIN
-- ==========================================================
create table games(
	id_game int primary key references produit(id_produit),
    genre varchar(255) default "mixte" not null
);

use librairiedb_v2;
-- ==========================================================
-- TRIGGER before_insert_into_ligne_commande
-- ==========================================================
DELIMITER $$
	create trigger before_insert_into_ligne_commande
    before insert on ligne_commande
    for each row
    begin
		declare price float ;
		declare quantity int;
		set quantity = new.quantite;
        select prix into price from produit where id_produit = new.id_produit;
		-- tna9eslk el quantité ta3 el produit fl stock
		if(select quantite_stock from produit where id_produit= new.id_produit) < new.quantite then
			signal sqlstate '45000'
			set message_text = "Stock du l'article est insuffisant !!!";
		end if;
		set new.sous_total = price * quantity;
    


	end$$
DELIMITER;

-- triggers
DELIMITER $$
create trigger after_ligne_commande_insert
after insert on ligne_commande
for each row 

begin 
	update produit 
	set quantite_stock = quantite_stock - new.quantite 
	where id_produit = new.id_produit;
	-- te7seblk el total automatique
end$$
DELIMITER ;



-- ==========================================================
-- DONNEES DE TEST
-- ==========================================================

-- ---------------- PRODUIT + SAC (20 lignes) ----------------
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (1, 'SAC000001', 'Sac à dos Mixte Rouge - Beckmann', 59.29, 0, '/assets/images/uploadedImg/articles/000ac1f3dd576cb63272b76ad640251e.jpeg', 'Sac à dos robuste et confortable, coloris rouge, ideal pour le niveau 4ème Primaire.', 4.19, 114, 'Sac', 'Beckmann', 189);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (2, 'SAC000002', 'Sac à dos Fille Blanc - Beckmann', 33.48, 0, '/assets/images/uploadedImg/articles/d25e8473ae7888f314991f1150feaee2.webp', 'Sac à dos robuste et confortable, coloris blanc, ideal pour le niveau Préscolaire.', 3.76, 3, 'Sac', 'Beckmann', 193);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (3, 'SAC000003', 'Sac à dos Fille Marine - Wanapix', 83.81, 0, '/assets/images/uploadedImg/articles/b915a0ee3e39fa1997ec612d3232b987.webp', 'Sac à dos robuste et confortable, coloris marine, ideal pour le niveau 3ème Primaire.', 4.4, 20, 'Sac', 'Wanapix', 228);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (4, 'SAC000004', 'Sac à dos Fille Vert - Kanguru', 55.74, 20, '/assets/images/uploadedImg/articles/f865750c0326633f64d6a03b0915ad3e.webp', 'Sac à dos robuste et confortable, coloris vert, ideal pour le niveau 2ème Primaire.', 2.76, 48, 'Sac', 'Kanguru', 74);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (5, 'SAC000005', 'Sac à dos Mixte Vert - Sportex', 126.76, 15, '/assets/images/uploadedImg/articles/54554ecfa45411389928b21343e82604.webp', 'Sac à dos robuste et confortable, coloris vert, ideal pour le niveau 4ème Primaire.', 3.84, 118, 'Sac', 'Sportex', 146);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (6, 'SAC000006', 'Sac à dos Fille Marine - Beckmann', 105.34, 20, '/assets/images/uploadedImg/articles/83f10c275fccd2339c198cc2d197f530.webp', 'Sac à dos robuste et confortable, coloris marine, ideal pour le niveau 4ème Secondaire.', 3.94, 90, 'Sac', 'Beckmann', 67);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (7, 'SAC000007', 'Sac à dos Fille Noir - Bagtrotter', 132.54, 20, '/assets/images/uploadedImg/articles/000ac1f3dd576cb63272b76ad640251e.jpeg', 'Sac à dos robuste et confortable, coloris noir, ideal pour le niveau 1ère Primaire.', 3.45, 58, 'Sac', 'Bagtrotter', 212);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (8, 'SAC000008', 'Sac à dos Fille Rose - Sportex', 55.04, 0, '/assets/images/uploadedImg/articles/e826fb6a3fbf62bee268c492f3069403.jpeg', 'Sac à dos robuste et confortable, coloris rose, ideal pour le niveau 5ème Primaire.', 4.02, 21, 'Sac', 'Sportex', 186);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (9, 'SAC000009', 'Sac à dos Fille Rose - Wanapix', 62.29, 15, '/assets/images/uploadedImg/articles/d25e8473ae7888f314991f1150feaee2.webp', 'Sac à dos robuste et confortable, coloris rose, ideal pour le niveau 6ème Primaire.', 4.21, 107, 'Sac', 'Wanapix', 246);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (10, 'SAC000010', 'Sac à dos Garçon Noir - Bagtrotter', 67.75, 0, '/assets/images/uploadedImg/articles/e826fb6a3fbf62bee268c492f3069403.jpeg', 'Sac à dos robuste et confortable, coloris noir, ideal pour le niveau 3ème Secondaire.', 3.03, 120, 'Sac', 'Bagtrotter', 195);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (11, 'SAC000011', 'Sac à dos Mixte Noir - Sportex', 77.38, 15, '/assets/images/uploadedImg/articles/54554ecfa45411389928b21343e82604.webp', 'Sac à dos robuste et confortable, coloris noir, ideal pour le niveau 7ème Base.', 2.86, 17, 'Sac', 'Sportex', 113);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (12, 'SAC000012', 'Sac à dos Fille Marine - SchoolPack', 100.05, 10, '/assets/images/uploadedImg/articles/95147eda221570410e7134106f6a1e8f.webp', 'Sac à dos robuste et confortable, coloris marine, ideal pour le niveau 2ème Secondaire.', 3.4, 17, 'Sac', 'SchoolPack', 180);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (13, 'SAC000013', 'Sac à dos Garçon Bleu - Trolly+', 43.06, 15, '/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg', 'Sac à dos robuste et confortable, coloris bleu, ideal pour le niveau 4ème Secondaire.', 4.48, 54, 'Sac', 'Trolly+', 202);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (14, 'SAC000014', 'Sac à dos Fille Violet - Beckmann', 149.43, 10, '/assets/images/uploadedImg/articles/22dfa1829658d8db9b6e33be00285f28.webp', 'Sac à dos robuste et confortable, coloris violet, ideal pour le niveau 9ème Base.', 4.93, 110, 'Sac', 'Beckmann', 291);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (15, 'SAC000015', 'Sac à dos Mixte Bleu - Bagtrotter', 120.01, 20, '/assets/images/uploadedImg/articles/f865750c0326633f64d6a03b0915ad3e.webp', 'Sac à dos robuste et confortable, coloris bleu, ideal pour le niveau 8ème Base.', 2.78, 55, 'Sac', 'Bagtrotter', 90);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (16, 'SAC000016', 'Sac à dos Mixte Rouge - Trolly+', 61.51, 10, '/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg', 'Sac à dos robuste et confortable, coloris rouge, ideal pour le niveau 2ème Secondaire.', 3.77, 13, 'Sac', 'Trolly+', 272);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (17, 'SAC000017', 'Sac à dos Mixte Marine - Eastro', 48.24, 20, '/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg', 'Sac à dos robuste et confortable, coloris marine, ideal pour le niveau 3ème Primaire.', 3.85, 99, 'Sac', 'Eastro', 286);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (18, 'SAC000018', 'Sac à dos Mixte Rouge - SchoolPack', 88.53, 0, '/assets/images/uploadedImg/articles/83f10c275fccd2339c198cc2d197f530.webp', 'Sac à dos robuste et confortable, coloris rouge, ideal pour le niveau 5ème Primaire.', 4.7, 106, 'Sac', 'SchoolPack', 256);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (19, 'SAC000019', 'Sac à dos Garçon Noir - Eastro', 135.26, 0, '/assets/images/uploadedImg/articles/e826fb6a3fbf62bee268c492f3069403.jpeg', 'Sac à dos robuste et confortable, coloris noir, ideal pour le niveau 3ème Primaire.', 4.33, 104, 'Sac', 'Eastro', 67);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (20, 'SAC000020', 'Sac à dos Garçon Rose - SchoolPack', 86.93, 10, '/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg', 'Sac à dos robuste et confortable, coloris rose, ideal pour le niveau 1ère Secondaire.', 3.16, 111, 'Sac', 'SchoolPack', 205);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (1, 'Mixte', '3ème Secondaire', 'Noir', 'Kanguru', 'Nylon', FALSE, 4);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (2, 'Mixte', '7ème Base', 'Orange', 'Sportex', 'Polyester', TRUE, 2);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (3, 'Garçon', '9ème Base', 'Vert', 'Beckmann', 'Nylon', TRUE, 1);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (4, 'Garçon', '1ère Primaire', 'Rouge', 'Beckmann', 'Polyester', FALSE, 1);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (5, 'Fille', '1ère Secondaire', 'Noir', 'SchoolPack', 'Cuir synthétique', TRUE, 5);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (6, 'Mixte', '7ème Base', 'Blanc', 'Deuter', 'Nylon', FALSE, 4);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (7, 'Garçon', '1ère Secondaire', 'Bleu', 'Wanapix', 'Cuir synthétique', FALSE, 4);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (8, 'Mixte', 'Préscolaire', 'Orange', 'Kanguru', 'Polyester', TRUE, 4);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (9, 'Garçon', '3ème Primaire', 'Bleu', 'Sportex', 'Nylon', FALSE, 2);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (10, 'Fille', '7ème Base', 'Rose', 'Kanguru', 'Nylon', TRUE, 4);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (11, 'Garçon', '1ère Secondaire', 'Bleu', 'SchoolPack', 'Polyester', TRUE, 2);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (12, 'Fille', '7ème Base', 'Violet', 'Deuter', 'Nylon', FALSE, 1);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (13, 'Garçon', '6ème Primaire', 'Violet', 'Deuter', 'Toile', FALSE, 3);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (14, 'Mixte', '2ème Secondaire', 'Marine', 'Kanguru', 'Cuir synthétique', TRUE, 2);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (15, 'Garçon', '9ème Base', 'Noir', 'Eastro', 'Polyester', FALSE, 1);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (16, 'Fille', '8ème Base', 'Blanc', 'Bagtrotter', 'Nylon', TRUE, 5);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (17, 'Garçon', '9ème Base', 'Rose', 'Beckmann', 'Polyester', TRUE, 4);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (18, 'Garçon', '9ème Base', 'Blanc', 'Beckmann', 'Polyester', TRUE, 4);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (19, 'Mixte', '5ème Primaire', 'Blanc', 'Nomade', 'Toile', TRUE, 3);
INSERT INTO sac (id_produit, genre, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES (20, 'Fille', '2ème Primaire', 'Gris', 'Wanapix', 'Toile', FALSE, 3);

-- ---------------- PRODUIT + LIVRE (20 lignes) ----------------
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (21, 'LIV000021', 'Livre de Français - Préscolaire', 28.16, 0, '/assets/images/uploadedImg/articles/e826fb6a3fbf62bee268c492f3069403.jpeg', 'Manuel scolaire de Français pour le niveau Préscolaire, edition Maghrébine du Livre.', 4.08, 64, 'Livre', 'Maghrébine du Livre', 117);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (22, 'LIV000022', 'Livre de Arabe - 5ème Primaire', 36.16, 5, '/assets/images/uploadedImg/articles/b20f47d3bee46e04cf76379f2c9c4111.jpeg', 'Manuel scolaire de Arabe pour le niveau 5ème Primaire, edition Nathan.', 3.32, 69, 'Livre', 'Nathan', 230);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (23, 'LIV000023', 'Livre de Sciences - 9ème Base', 9.14, 5, '/assets/images/uploadedImg/articles/000ac1f3dd576cb63272b76ad640251e.jpeg', 'Manuel scolaire de Sciences pour le niveau 9ème Base, edition Ellipses.', 4.88, 17, 'Livre', 'Ellipses', 117);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (24, 'LIV000024', 'Livre de Français - 1ère Primaire', 13.72, 5, '/assets/images/uploadedImg/articles/3787aecca17b36bc44c88c56252c5a02.webp', 'Manuel scolaire de Français pour le niveau 1ère Primaire, edition Ellipses.', 4.44, 26, 'Livre', 'Ellipses', 225);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (25, 'LIV000025', 'Livre de Sciences - 8ème Base', 16.68, 0, '/assets/images/uploadedImg/articles/e826fb6a3fbf62bee268c492f3069403.jpeg', 'Manuel scolaire de Sciences pour le niveau 8ème Base, edition Maghrébine du Livre.', 4.27, 35, 'Livre', 'Maghrébine du Livre', 61);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (26, 'LIV000026', 'Livre de Mathématiques - 5ème Primaire', 28.65, 5, '/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg', 'Manuel scolaire de Mathématiques pour le niveau 5ème Primaire, edition Hachette.', 4.48, 70, 'Livre', 'Hachette', 230);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (27, 'LIV000027', 'Livre de Physique - 8ème Base', 12.37, 0, '/assets/images/uploadedImg/articles/0a0c1b3a70bed4af70f6b90cfc5bc6be.webp', 'Manuel scolaire de Physique pour le niveau 8ème Base, edition Nathan.', 4.67, 74, 'Livre', 'Nathan', 191);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (28, 'LIV000028', 'Livre de Arabe - 6ème Primaire', 10.2, 5, '/assets/images/uploadedImg/articles/0a0c1b3a70bed4af70f6b90cfc5bc6be.webp', 'Manuel scolaire de Arabe pour le niveau 6ème Primaire, edition Hachette.', 4.8, 26, 'Livre', 'Hachette', 224);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (29, 'LIV000029', 'Livre de Anglais - 1ère Secondaire', 19.86, 10, '/assets/images/uploadedImg/articles/fe8fa0c5fcc75676c92c3923be42013b.jpg', 'Manuel scolaire de Anglais pour le niveau 1ère Secondaire, edition Nathan.', 4.85, 30, 'Livre', 'Nathan', 271);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (30, 'LIV000030', 'Livre de Arabe - 3ème Secondaire', 36.22, 0, '/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg', 'Manuel scolaire de Arabe pour le niveau 3ème Secondaire, edition Hachette.', 4.47, 42, 'Livre', 'Hachette', 250);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (31, 'LIV000031', 'Livre de Physique - 3ème Secondaire', 17.17, 0, '/assets/images/uploadedImg/articles/95147eda221570410e7134106f6a1e8f.webp', 'Manuel scolaire de Physique pour le niveau 3ème Secondaire, edition Hachette.', 4.74, 60, 'Livre', 'Hachette', 106);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (32, 'LIV000032', 'Livre de Anglais - 4ème Secondaire', 19.74, 0, '/assets/images/uploadedImg/articles/d25e8473ae7888f314991f1150feaee2.webp', 'Manuel scolaire de Anglais pour le niveau 4ème Secondaire, edition Maghrébine du Livre.', 3.05, 24, 'Livre', 'Maghrébine du Livre', 152);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (33, 'LIV000033', 'Livre de Histoire-Géographie - 4ème Primaire', 38.87, 5, '/assets/images/uploadedImg/articles/83f10c275fccd2339c198cc2d197f530.webp', 'Manuel scolaire de Histoire-Géographie pour le niveau 4ème Primaire, edition Nathan.', 4.28, 51, 'Livre', 'Nathan', 223);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (34, 'LIV000034', 'Livre de Philosophie - 5ème Primaire', 12.48, 5, '/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg', 'Manuel scolaire de Philosophie pour le niveau 5ème Primaire, edition Nathan.', 4.16, 33, 'Livre', 'Nathan', 59);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (35, 'LIV000035', 'Livre de Français - 9ème Base', 19.62, 5, '/assets/images/uploadedImg/articles/492e054c017befd2e41665cc3ab55914.webp', 'Manuel scolaire de Français pour le niveau 9ème Base, edition Maghrébine du Livre.', 4.21, 65, 'Livre', 'Maghrébine du Livre', 79);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (36, 'LIV000036', 'Livre de Physique - 9ème Base', 16.8, 10, '/assets/images/uploadedImg/articles/b915a0ee3e39fa1997ec612d3232b987.webp', 'Manuel scolaire de Physique pour le niveau 9ème Base, edition Hachette.', 4.04, 68, 'Livre', 'Hachette', 225);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (37, 'LIV000037', 'Livre de Anglais - 5ème Primaire', 11.07, 5, '/assets/images/uploadedImg/articles/f865750c0326633f64d6a03b0915ad3e.webp', 'Manuel scolaire de Anglais pour le niveau 5ème Primaire, edition Maghrébine du Livre.', 4.33, 15, 'Livre', 'Maghrébine du Livre', 234);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (38, 'LIV000038', 'Livre de Sciences - 8ème Base', 29.57, 5, '/assets/images/uploadedImg/articles/95147eda221570410e7134106f6a1e8f.webp', 'Manuel scolaire de Sciences pour le niveau 8ème Base, edition Edudia.', 4.39, 70, 'Livre', 'Edudia', 82);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (39, 'LIV000039', 'Livre de Anglais - 6ème Primaire', 29.9, 0, '/assets/images/uploadedImg/articles/b20f47d3bee46e04cf76379f2c9c4111.jpeg', 'Manuel scolaire de Anglais pour le niveau 6ème Primaire, edition Maghrébine du Livre.', 3.81, 0, 'Livre', 'Maghrébine du Livre', 127);
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES (40, 'LIV000040', 'Livre de Sciences - 3ème Primaire', 33.26, 5, '/assets/images/uploadedImg/articles/54554ecfa45411389928b21343e82604.webp', 'Manuel scolaire de Sciences pour le niveau 3ème Primaire, edition Maghrébine du Livre.', 3.88, 27, 'Livre', 'Maghrébine du Livre', 180);
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (21, '3ème Secondaire', 'Informatique');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (22, '1ère Secondaire', 'Arabe');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (23, '4ème Primaire', 'Français');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (24, '1ère Secondaire', 'Philosophie');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (25, '5ème Primaire', 'Éducation Islamique');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (26, '4ème Secondaire', 'Français');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (27, '1ère Secondaire', 'Anglais');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (28, '3ème Primaire', 'Sciences');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (29, '2ème Primaire', 'Anglais');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (30, 'Préscolaire', 'Mathématiques');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (31, '7ème Base', 'Anglais');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (32, '4ème Secondaire', 'Éducation Islamique');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (33, '7ème Base', 'Français');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (34, '1ère Secondaire', 'Physique');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (35, '3ème Primaire', 'Éducation Islamique');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (36, '7ème Base', 'Physique');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (37, '3ème Primaire', 'Physique');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (38, '1ère Secondaire', 'Arabe');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (39, '3ème Secondaire', 'Mathématiques');
INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES (40, '3ème Secondaire', 'Français');

-- ---------------- PARASCOLAIRE (20 lignes) ----------------
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (21, 'Guide pédagogique', 'Hachette');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (22, 'Annales', 'Collection Réussite');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (23, 'Guide pédagogique', 'Nathan');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (24, 'Annales', 'Nathan');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (25, 'Guide pédagogique', 'Hachette');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (26, 'Guide pédagogique', 'Collection Réussite');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (27, 'Résumé de cours', 'Maghrébine du Livre');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (28, 'Guide pédagogique', 'Ellipses');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (29, 'Guide pédagogique', 'Hachette');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (30, 'Guide pédagogique', 'Maghrébine du Livre');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (31, 'Résumé de cours', 'Hachette');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (32, 'Résumé de cours', 'Ellipses');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (33, 'Guide pédagogique', 'Collection Réussite');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (34, 'Annales', 'Edudia');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (35, 'Guide pédagogique', 'Nathan');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (36, 'Résumé de cours', 'Hachette');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (37, 'Résumé de cours', 'Edudia');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (38, 'Résumé de cours', 'Ellipses');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (39, 'Cahier d''exercices', 'Hachette');
INSERT INTO parascolaire (id_produit, type_parascolaire, collection) VALUES (40, 'Annales', 'Hachette');

-- ---------------- PRODUIT + PACK (20 lignes) ----------------
select * from pack;
-- ---------------- PRODUIT + PACK (20 lignes) ----------------
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES 
(41, 'PCKL00110', 'Pack Livres Scolaires - 1-primaire', 45.50, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 1-primaire.', 4.5, 12, 'Pack', 'SchoolPack', 50),
(42, 'PCKL00111', 'Pack Livres Scolaires - 2-primaire', 48.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 2-primaire.', 4.2, 8, 'Pack', 'SchoolPack', 45),
(43, 'PCKL00112', 'Pack Livres Scolaires - 3-primaire', 52.30, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-primaire.', 4.7, 20, 'Pack', 'SchoolPack', 60),
(44, 'PCKL00113', 'Pack Livres Scolaires - 4-primaire', 55.00, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 4-primaire.', 4.1, 5, 'Pack', 'SchoolPack', 30),
(45, 'PCKL00114', 'Pack Livres Scolaires - 5-primaire', 58.90, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 5-primaire.', 4.8, 35, 'Pack', 'SchoolPack', 70),
(46, 'PCKL00115', 'Pack Livres Scolaires - 6-primaire', 62.00, 15, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 6-primaire.', 4.9, 50, 'Pack', 'SchoolPack', 85),
(47, 'PCKL00116', 'Pack Livres Scolaires - 7-base', 75.50, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 7-base.', 4.3, 14, 'Pack', 'SchoolPack', 40),
(48, 'PCKL00117', 'Pack Livres Scolaires - 8-base', 82.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 8-base.', 4.6, 22, 'Pack', 'SchoolPack', 55),
(49, 'PCKL00118', 'Pack Livres Scolaires - 9-base', 89.90, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 9-base.', 4.8, 41, 'Pack', 'SchoolPack', 90),
(50, 'PCKL00119', 'Pack Livres Scolaires - 1-secondaire', 95.00, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 1-secondaire.', 4.4, 18, 'Pack', 'SchoolPack', 35),
(51, 'PCKL00120', 'Pack Livres Scolaires - 2-sciences', 105.50, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 2-sciences.', 4.5, 27, 'Pack', 'SchoolPack', 48),
(52, 'PCKL00121', 'Pack Livres Scolaires - 2-informatique', 102.00, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 2-informatique.', 4.7, 15, 'Pack', 'SchoolPack', 25),
(53, 'PCKL00122', 'Pack Livres Scolaires - 3-math', 115.00, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-math.', 4.9, 60, 'Pack', 'SchoolPack', 100),
(54, 'PCKL00123', 'Pack Livres Scolaires - 3-economie', 108.50, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-economie.', 4.2, 11, 'Pack', 'SchoolPack', 30),
(55, 'PCKL00124', 'Pack Livres Scolaires - 3-technique', 112.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-technique.', 4.6, 24, 'Pack', 'SchoolPack', 42),
(56, 'PCKL00125', 'Pack Livres Scolaires - bac-math', 135.00, 15, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-math.', 4.9, 85, 'Pack', 'SchoolPack', 120),
(57, 'PCKL00126', 'Pack Livres Scolaires - bac-sciences', 130.00, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-sciences.', 4.8, 70, 'Pack', 'SchoolPack', 110),
(58, 'PCKL00127', 'Pack Livres Scolaires - bac-informatique', 125.50, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-informatique.', 4.7, 45, 'Pack', 'SchoolPack', 65),
(59, 'PCKL00128', 'Pack Livres Scolaires - bac-technique', 128.00, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-technique.', 4.6, 38, 'Pack', 'SchoolPack', 50),
(60, 'PCKL00129', 'Pack Livres Scolaires - bac-lettres', 118.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-lettres.', 4.4, 21, 'Pack', 'SchoolPack', 40);

-- ---------------- PACK (20 lignes avec la nouvelle structure) ----------------
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (41, 'fourniture', 'primaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (42, 'fourniture', 'secondaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (43, 'fourniture', 'college', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (44, 'fourniture', 'bac', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (45, 'fourniture', 'primaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (46, 'fourniture', 'secondaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (47, 'fourniture', 'college', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (48, 'fourniture', 'bac', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (49, 'fourniture', 'primaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (50, 'fourniture', 'secondaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (51, 'fourniture', 'college', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (52, 'fourniture', 'bac', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (53, 'fourniture', 'primaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (54, 'fourniture', 'secondaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (55, 'fourniture', 'college', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (56, 'fourniture', 'bac', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (57, 'fourniture', 'primaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (58, 'fourniture', 'secondaire', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (59, 'fourniture', 'college', NULL);
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (60, 'fourniture', 'bac', NULL);

select * from pack;
-- ---------------- PACKARTICLE (>=20 lignes) ----------------
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (41, 1, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (41, 30, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (42, 13, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (42, 33, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (43, 7, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (43, 23, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (44, 8, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (44, 24, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (45, 10, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (45, 40, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (46, 19, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (46, 22, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (47, 18, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (47, 34, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (48, 12, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (48, 23, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (49, 11, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (49, 21, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (50, 16, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (50, 24, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (51, 12, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (51, 35, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (52, 5, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (52, 34, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (53, 17, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (53, 29, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (54, 18, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (54, 36, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (55, 14, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (55, 39, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (56, 11, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (56, 28, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (57, 9, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (57, 35, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (58, 15, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (58, 39, 2);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (59, 13, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (59, 31, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (60, 16, 1);
INSERT INTO packArticle (id_pack, id_produit, quantite) VALUES (60, 31, 1);

-- ---------------- CLIENT (20 lignes) ----------------
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (1, 'Ben Ali', 'Ahmed', '29179730', 'client1@gmail.com', 'Rue 46, Manouba', '$2b$10$hashPlaceholderTestData0001xxxxxxxxxxxxxxxxxxxxx', 'admin');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (2, 'Trabelsi', 'Mohamed', '25334434', 'client2@gmail.com', 'Rue 36, Sousse', '$2b$10$hashPlaceholderTestData0002xxxxxxxxxxxxxxxxxxxxx', 'admin');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (3, 'Gharbi', 'Fatma', '25635017', 'client3@gmail.com', 'Rue 2, Monastir', '$2b$10$hashPlaceholderTestData0003xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (4, 'Sassi', 'Amira', '29667566', 'client4@gmail.com', 'Rue 11, Manouba', '$2b$10$hashPlaceholderTestData0004xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (5, 'Jendoubi', 'Youssef', '25049282', 'client5@gmail.com', 'Rue 63, Sfax', '$2b$10$hashPlaceholderTestData0005xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (6, 'Cherif', 'Sana', '25031966', 'client6@gmail.com', 'Rue 83, Bizerte', '$2b$10$hashPlaceholderTestData0006xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (7, 'Mansour', 'Nour', '29234615', 'client7@gmail.com', 'Rue 102, Bizerte', '$2b$10$hashPlaceholderTestData0007xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (8, 'Bouazizi', 'Karim', '21289293', 'client8@gmail.com', 'Rue 38, Ariana', '$2b$10$hashPlaceholderTestData0008xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (9, 'Khemiri', 'Rania', '24717770', 'client9@gmail.com', 'Rue 89, Sfax', '$2b$10$hashPlaceholderTestData0009xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (10, 'Rekik', 'Sami', '25081983', 'client10@gmail.com', 'Rue 85, Nabeul', '$2b$10$hashPlaceholderTestData0010xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (11, 'Souissi', 'Salma', '27191135', 'client11@gmail.com', 'Rue 71, Bizerte', '$2b$10$hashPlaceholderTestData0011xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (12, 'Zribi', 'Wassim', '29907391', 'client12@gmail.com', 'Rue 55, Sousse', '$2b$10$hashPlaceholderTestData0012xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (13, 'Hamdi', 'Emna', '26549757', 'client13@gmail.com', 'Rue 90, Sousse', '$2b$10$hashPlaceholderTestData0013xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (14, 'Bouzid', 'Hedi', '28612582', 'client14@gmail.com', 'Rue 40, Nabeul', '$2b$10$hashPlaceholderTestData0014xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (15, 'Loussaief', 'Ines', '25217853', 'client15@gmail.com', 'Rue 16, Manouba', '$2b$10$hashPlaceholderTestData0015xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (16, 'Fakhfakh', 'Anis', '24231028', 'client16@gmail.com', 'Rue 16, Sousse', '$2b$10$hashPlaceholderTestData0016xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (17, 'Ayari', 'Mariem', '29990305', 'client17@gmail.com', 'Rue 25, Ben Arous', '$2b$10$hashPlaceholderTestData0017xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (18, 'Bel Haj', 'Bilel', '24630331', 'client18@gmail.com', 'Rue 36, Bizerte', '$2b$10$hashPlaceholderTestData0018xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (19, 'Ghariani', 'Rahma', '29801946', 'client19@gmail.com', 'Rue 37, Kairouan', '$2b$10$hashPlaceholderTestData0019xxxxxxxxxxxxxxxxxxxxx', 'client');
INSERT INTO client (id_client, nom, prenom, tel, email, addresse, password, role) VALUES (20, 'Nasri', 'Malek', '22686548', 'client20@gmail.com', 'Rue 38, Manouba', '$2b$10$hashPlaceholderTestData0020xxxxxxxxxxxxxxxxxxxxx', 'client');

-- ---------------- COMMANDE (20 lignes) ----------------
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (1, 1, '2026-02-02 9:07:00', 'confirmée', 'Avenue 185, Manouba', 'Manouba', '1037', 114.338, '');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (2, 2, '2026-03-03 10:14:00', 'annulée', 'Avenue 65, Monastir', 'Monastir', '1074', 158.926, '');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (3, 3, '2026-04-04 11:21:00', 'livrée', 'Avenue 150, Monastir', 'Monastir', '1111', 357.786, 'Livraison rapide svp');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (4, 4, '2026-05-05 12:28:00', 'attente', 'Avenue 53, Bizerte', 'Bizerte', '1148', 440.178, 'Appeler avant livraison');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (5, 5, '2026-06-06 13:35:00', 'confirmée', 'Avenue 241, Nabeul', 'Nabeul', '1185', 254.996, 'Merci de verifier l''emballage');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (6, 6, '2026-07-07 14:42:00', 'annulée', 'Avenue 27, Ben Arous', 'Ben Arous', '1222', 148.665, 'RAS');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (7, 7, '2026-08-08 15:49:00', 'livrée', 'Avenue 34, Ariana', 'Ariana', '1259', 218.332, '');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (8, 8, '2026-09-09 16:56:00', 'attente', 'Avenue 28, Kairouan', 'Kairouan', '1296', 101.312, 'Appeler avant livraison');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (9, 9, '2026-10-10 17:03:00', 'confirmée', 'Avenue 44, Nabeul', 'Nabeul', '1333', 497.142, '');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (10, 10, '2026-11-11 8:10:00', 'annulée', 'Avenue 214, Monastir', 'Monastir', '1370', 314.969, 'Appeler avant livraison');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (11, 11, '2026-12-12 9:17:00', 'livrée', 'Avenue 268, Manouba', 'Manouba', '1407', 208.778, 'RAS');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (12, 12, '2026-01-13 10:24:00', 'attente', 'Avenue 220, Nabeul', 'Nabeul', '1444', 173.529, 'Appeler avant livraison');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (13, 13, '2026-02-14 11:31:00', 'confirmée', 'Avenue 51, Tunis', 'Tunis', '1481', 475.367, 'Livraison rapide svp');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (14, 14, '2026-03-15 12:38:00', 'annulée', 'Avenue 136, Manouba', 'Manouba', '1518', 340.401, 'Livraison rapide svp');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (15, 15, '2026-04-16 13:45:00', 'livrée', 'Avenue 89, Manouba', 'Manouba', '1555', 289.436, 'Livraison rapide svp');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (16, 16, '2026-05-17 14:52:00', 'attente', 'Avenue 210, Tunis', 'Tunis', '1592', 241.737, 'Appeler avant livraison');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (17, 17, '2026-06-18 15:59:00', 'confirmée', 'Avenue 150, Bizerte', 'Bizerte', '1629', 45.341, 'Merci de verifier l''emballage');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (18, 18, '2026-07-19 16:06:00', 'annulée', 'Avenue 233, Nabeul', 'Nabeul', '1666', 63.454, 'Livraison rapide svp');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (19, 19, '2026-08-20 17:13:00', 'livrée', 'Avenue 102, Nabeul', 'Nabeul', '1703', 229.815, 'Appeler avant livraison');
INSERT INTO commande (id_commande, id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire) VALUES (20, 20, '2026-09-21 8:20:00', 'attente', 'Avenue 77, Manouba', 'Manouba', '1740', 456.953, 'Livraison rapide svp');

-- ---------------- LIGNE_COMMANDE (20 lignes) ----------------
-- NB: la colonne sous_total est recalculee automatiquement par le trigger before_insert_into_ligne_commande
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (1, 2, 1, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (2, 5, 1, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (3, 8, 2, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (4, 11, 3, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (5, 14, 3, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (6, 17, 4, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (7, 20, 1, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (8, 23, 4, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (9, 26, 3, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (10, 29, 4, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (11, 32, 3, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (12, 35, 4, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (13, 38, 4, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (14, 41, 1, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (15, 44, 1, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (16, 47, 4, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (17, 50, 3, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (18, 53, 3, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (19, 56, 1, 0);
INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total) VALUES (20, 59, 1, 0);

-- ---------------- USERLOGIN (20 lignes) ----------------
INSERT INTO userLogin (id_client, loginAt) VALUES (1, '2026-02-02 8:11:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (2, '2026-03-03 9:22:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (3, '2026-04-04 10:33:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (4, '2026-05-05 11:44:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (5, '2026-06-06 12:55:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (6, '2026-07-07 13:06:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (7, '2026-08-08 14:17:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (8, '2026-09-09 15:28:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (9, '2026-10-10 16:39:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (10, '2026-11-11 17:50:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (11, '2026-12-12 18:01:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (12, '2026-01-13 7:12:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (13, '2026-02-14 8:23:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (14, '2026-03-15 9:34:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (15, '2026-04-16 10:45:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (16, '2026-05-17 11:56:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (17, '2026-06-18 12:07:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (18, '2026-07-19 13:18:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (19, '2026-08-20 14:29:00');
INSERT INTO userLogin (id_client, loginAt) VALUES (20, '2026-09-21 15:40:00');

	

INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES
(90, '9782753111190', 'Manuel de Mathématiques - 1ère Primaire', 12.50, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Livre scolaire officiel pour la 1ère année', 4.5, 12, 'Livre Scolaire', 'CNP', 150),
(91, '9782753111191', 'Livre de Lecture Arabe - 1ère Primaire', 11.00, 5, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Apprentissage de l''alphabet et lecture de base', 4.8, 34, 'Livre Scolaire', 'CNP', 200),
(92, '9782753111192', 'Livre de Français - 2ème Primaire', 14.20, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Initiation à la langue française', 4.2, 18, 'Livre Scolaire', 'Hatier', 80),
(93, '9782753111193', 'Éveil Scientifique - 2ème Primaire', 10.50, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Découverte du monde et de la nature', 4.0, 8, 'Livre Scolaire', 'CNP', 120),
(94, '9782753111194', 'Let''s Learn English - 3ème Primaire', 15.00, 10, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Premier manuel d''anglais', 4.9, 45, 'Livre Scolaire', 'Oxford', 90),
(95, '9782753111195', 'Mathématiques Avancées - 3ème Primaire', 13.80, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Exercices et problèmes mathématiques', 4.4, 22, 'Livre Scolaire', 'CNP', 110),
(96, '9782753111196', 'Histoire et Géo - 4ème Primaire', 16.50, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Histoire de la Tunisie et géographie de base', 4.1, 15, 'Livre Scolaire', 'CNP', 75),
(97, '9782753111197', 'Grammaire Française - 4ème Primaire', 14.00, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Règles de grammaire et conjugaison', 4.6, 29, 'Livre Scolaire', 'Nathan', 60),
(98, '9782753111198', 'Littérature Arabe - 5ème Primaire', 12.90, 5, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Textes choisis et poésie', 4.7, 31, 'Livre Scolaire', 'CNP', 140),
(99, '9782753111199', 'Sciences de la Vie - 5ème Primaire', 15.20, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Biologie et environnement', 4.3, 19, 'Livre Scolaire', 'CNP', 100),
(100, '9782753111200', 'Préparation Concours Maths - 6ème Primaire', 18.00, 15, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Annales pour le concours de la 6ème', 4.9, 150, 'Parascolaire', 'Sigmaths', 300),
(101, '9782753111201', 'Informatique et TIC - 6ème Primaire', 11.50, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Initiation à l''ordinateur et programmation par blocs', 4.0, 11, 'Livre Scolaire', 'CNP', 65),
(102, '9782753111202', 'Mathématiques Algèbre - 7ème Base', 17.50, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Nouveau programme du collège', 4.5, 42, 'Livre Scolaire', 'CNP', 210),
(103, '9782753111203', 'Sciences Physiques - 7ème Base', 16.80, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Introduction à la physique et chimie', 4.2, 27, 'Livre Scolaire', 'CNP', 130),
(104, '9782753111204', 'SVT - 8ème Base', 18.20, 5, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Sciences de la vie et de la terre', 4.6, 38, 'Livre Scolaire', 'CNP', 115),
(105, '9782753111205', 'English Practice - 8ème Base', 19.00, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Cahier d''activités et leçons', 4.4, 21, 'Livre Scolaire', 'Cambridge', 95),
(106, '9782753111206', 'Préparation BEM Maths - 9ème Base', 22.00, 20, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Exercices corrigés pour le diplôme de base', 4.8, 88, 'Parascolaire', 'Oxygène', 250),
(107, '9782753111207', 'Expression Écrite - 9ème Base', 14.50, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Techniques de rédaction en français', 4.1, 14, 'Livre Scolaire', 'Nathan', 50),
(108, '9782753111208', 'Syntaxe Arabe - 1ère Secondaire', 16.00, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Livre de grammaire approfondie (Nahw)', 4.3, 17, 'Livre Scolaire', 'CNP', 105),
(109, '9782753111209', 'Algorithmique - 1ère Secondaire', 20.50, 10, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Bases de la programmation et algorithmes', 4.7, 56, 'Livre Scolaire', 'CNP', 140),
(110, '9782753111210', 'Mathématiques (Section Sciences) - 2ème Secondaire', 24.00, 5, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Analyse et géométrie dans l''espace', 4.5, 63, 'Livre Scolaire', 'CNP', 180),
(111, '9782753111211', 'Physique Chimie - 2ème Secondaire', 23.50, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Mécanique et réactions chimiques', 4.4, 49, 'Livre Scolaire', 'CNP', 160),
(112, '9782753111212', 'Philosophie Générale - 3ème Secondaire', 21.00, 0, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Introduction aux concepts philosophiques', 4.8, 72, 'Livre Scolaire', 'Hatier', 90),
(113, '9782753111213', 'Génétique et Évolution - 3ème Secondaire', 25.00, 15, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Programme SVT section sciences expérimentales', 4.6, 81, 'Livre Scolaire', 'CNP', 200),
(114, '9782753111214', 'Annales Bac Maths - 4ème Secondaire', 28.50, 25, 'https://images.epagine.fr/158/9782753111158_1_75.jpg', 'Sujets corrigés du baccalauréat tunisien', 4.9, 210, 'Parascolaire', 'Sigmaths', 400);


INSERT INTO livre (id_produit, niveau_scolaire, matiere) VALUES
(90, '1ère Primaire', 'Mathématiques'),
(91, '1ère Primaire', 'Arabe'),
(92, '2ème Primaire', 'Français'),
(93, '2ème Primaire', 'Sciences'),
(94, '3ème Primaire', 'Anglais'),
(95, '3ème Primaire', 'Mathématiques'),
(96, '4ème Primaire', 'Histoire-Géo'),
(97, '4ème Primaire', 'Français'),
(98, '5ème Primaire', 'Arabe'),
(99, '5ème Primaire', 'Sciences'),
(100, '6ème Primaire', 'Mathématiques'),
(101, '6ème Primaire', 'Informatique'),
(102, '7ème Base', 'Mathématiques'),
(103, '7ème Base', 'Physique'),
(104, '8ème Base', 'Sciences'),
(105, '8ème Base', 'Anglais'),
(106, '9ème Base', 'Mathématiques'),
(107, '9ème Base', 'Français'),
(108, '1ère Secondaire', 'Arabe'),
(109, '1ère Secondaire', 'Informatique'),
(110, '2ème Secondaire', 'Mathématiques'),
(111, '2ème Secondaire', 'Physique'),
(112, '3ème Secondaire', 'Philosophie'),
(113, '3ème Secondaire', 'Sciences'),
(114, '4ème Secondaire', 'Mathématiques');

select * from produit;
-- ###########################################################################################
-- ajouter des pack de type livre 
INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock) VALUES 
(200, 'PCKL00200', 'Pack Livres Scolaires - 1-primaire', 45.50, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 1-primaire.', 4.5, 12, 'Pack', 'SchoolPack', 50),
(201, 'PCKL00201', 'Pack Livres Scolaires - 2-primaire', 48.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 2-primaire.', 4.2, 8, 'Pack', 'SchoolPack', 45),
(202, 'PCKL00202', 'Pack Livres Scolaires - 3-primaire', 52.30, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-primaire.', 4.7, 20, 'Pack', 'SchoolPack', 60),
(203, 'PCKL00203', 'Pack Livres Scolaires - 4-primaire', 55.00, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 4-primaire.', 4.1, 5, 'Pack', 'SchoolPack', 30),
(204, 'PCKL00204', 'Pack Livres Scolaires - 5-primaire', 58.90, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 5-primaire.', 4.8, 35, 'Pack', 'SchoolPack', 70),
(205, 'PCKL00205', 'Pack Livres Scolaires - 6-primaire', 62.00, 15, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 6-primaire.', 4.9, 50, 'Pack', 'SchoolPack', 85),
(206, 'PCKL00206', 'Pack Livres Scolaires - 7-base', 75.50, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 7-base.', 4.3, 14, 'Pack', 'SchoolPack', 40),
(207, 'PCKL00207', 'Pack Livres Scolaires - 8-base', 82.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 8-base.', 4.6, 22, 'Pack', 'SchoolPack', 55),
(208, 'PCKL00208', 'Pack Livres Scolaires - 9-base', 89.90, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 9-base.', 4.8, 41, 'Pack', 'SchoolPack', 90),
(209, 'PCKL00209', 'Pack Livres Scolaires - 1-secondaire', 95.00, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 1-secondaire.', 4.4, 18, 'Pack', 'SchoolPack', 35),
(210, 'PCKL00210', 'Pack Livres Scolaires - 2-sciences', 105.50, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 2-sciences.', 4.5, 27, 'Pack', 'SchoolPack', 48),
(211, 'PCKL00211', 'Pack Livres Scolaires - 2-informatique', 102.00, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 2-informatique.', 4.7, 15, 'Pack', 'SchoolPack', 25),
(212, 'PCKL00212', 'Pack Livres Scolaires - 3-math', 115.00, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-math.', 4.9, 60, 'Pack', 'SchoolPack', 100),
(213, 'PCKL00213', 'Pack Livres Scolaires - 3-economie', 108.50, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-economie.', 4.2, 11, 'Pack', 'SchoolPack', 30),
(214, 'PCKL00214', 'Pack Livres Scolaires - 3-technique', 112.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour 3-technique.', 4.6, 24, 'Pack', 'SchoolPack', 42),
(215, 'PCKL00215', 'Pack Livres Scolaires - bac-math', 135.00, 15, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-math.', 4.9, 85, 'Pack', 'SchoolPack', 120),
(216, 'PCKL00216', 'Pack Livres Scolaires - bac-sciences', 130.00, 10, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-sciences.', 4.8, 70, 'Pack', 'SchoolPack', 110),
(217, 'PCKL00217', 'Pack Livres Scolaires - bac-informatique', 125.50, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-informatique.', 4.7, 45, 'Pack', 'SchoolPack', 65),
(218, 'PCKL00218', 'Pack Livres Scolaires - bac-technique', 128.00, 0, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-technique.', 4.6, 38, 'Pack', 'SchoolPack', 50),
(219, 'PCKL00219', 'Pack Livres Scolaires - bac-lettres', 118.00, 5, '/assets/images/Designes/packLivre.png', 'Ensemble des manuels officiels pour bac-lettres.', 4.4, 21, 'Pack', 'SchoolPack', 40);



INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (200, 'livre', 'primaire', '1-primaire');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (201, 'livre', 'primaire', '2-primaire');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (202, 'livre', 'primaire', '3-primaire');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (203, 'livre', 'primaire', '4-primaire');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (204, 'livre', 'primaire', '5-primaire');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (205, 'livre', 'primaire', '6-primaire');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (206, 'livre', 'college', '7-base');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (207, 'livre', 'college', '8-base');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (208, 'livre', 'college', '9-base');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (209, 'livre', 'secondaire', '1-secondaire');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (210, 'livre', 'secondaire', '2-sciences');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (211, 'livre', 'secondaire', '2-informatique');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (212, 'livre', 'secondaire', '3-math');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (213, 'livre', 'secondaire', '3-economie');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (214, 'livre', 'secondaire', '3-technique');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (215, 'livre', 'bac', 'bac-math');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (216, 'livre', 'bac', 'bac-sciences');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (217, 'livre', 'bac', 'bac-informatique');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (218, 'livre', 'bac', 'bac-technique');
INSERT INTO pack (id_pack, type, categorie, annee_scolaire) VALUES (219, 'livre', 'bac', 'bac-lettres');
select * from produit;
-- ###########################################################################################
-- ############################################################################################
-- Vérifications utiles (reprises du script de base)
-- ############################################################################################
update client set role="admin" where id_client =21;


-- ============================================
-- Données de test : produit (20 nouvelles lignes - uniquement des jeux)
-- ============================================
INSERT INTO produit
(id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock)
VALUES
(221, 'GM0000021', 'FIFA 25',                       69.900, 5, 'https://picsum.photos/seed/fifa25/400',       'Jeu vidéo de football FIFA 25',                4.60, 48, 'jeux', 'EA Sports',    18),
(222, 'GM0000022', 'Minecraft',                     34.900, 0, 'https://picsum.photos/seed/minecraft2/400',   'Jeu bac à sable de construction',              4.90, 90, 'jeux', 'Mojang',       25),
(223, 'GM0000023', 'GTA V',                         49.900, 0, 'https://picsum.photos/seed/gta5b/400',        'Jeu action-aventure en monde ouvert',          4.80, 132,'jeux', 'Rockstar',     14),
(224, 'GM0000024', 'Mario Kart 8 Deluxe',           39.900, 0, 'https://picsum.photos/seed/mariokart2/400',   'Jeu de course avec personnages Nintendo',      4.85, 97, 'jeux', 'Nintendo',     20),
(225, 'GM0000025', 'Just Dance 2025',               44.900, 3, 'https://picsum.photos/seed/justdance2/400',   'Jeu de danse et rythme',                       4.30, 44, 'jeux', 'Ubisoft',      16),
(226, 'GM0000026', 'Barbie Dreamhouse Adventures',  29.900, 0, 'https://picsum.photos/seed/barbiegame2/400',  'Jeu de vie et aventures Barbie',               4.20, 10, 'jeux', 'Gameloft',     11),
(227, 'GM0000027', 'Call of Duty Modern Warfare',   74.900, 0, 'https://picsum.photos/seed/cod1/400',         'Jeu de tir à la première personne',            4.50, 210,'jeux', 'Activision',   9),
(228, 'GM0000028', 'The Sims 4',                    39.900, 5, 'https://picsum.photos/seed/sims4/400',        'Simulation de vie quotidienne',                4.40, 76, 'jeux', 'EA',           22),
(229, 'GM0000029', 'Animal Crossing New Horizons',  49.900, 0, 'https://picsum.photos/seed/animalcrossing/400','Jeu de vie sur une île paradisiaque',         4.90, 150,'jeux', 'Nintendo',     19),
(230, 'GM0000030', 'Fortnite Battle Pass',          19.900, 0, 'https://picsum.photos/seed/fortnite1/400',    'Jeu de survie et construction en ligne',       4.10, 300,'jeux', 'Epic Games',   50),
(231, 'GM0000031', 'League of Legends Skin Pack',   14.900, 0, 'https://picsum.photos/seed/lol1/400',         'Pack de skins pour jeu de stratégie en ligne', 4.00, 180,'jeux', 'Riot Games',   60),
(232, 'GM0000032', 'Super Mario Odyssey',           39.900, 0, 'https://picsum.photos/seed/mario1/400',       'Jeu de plateforme avec Mario',                 4.90, 120,'jeux', 'Nintendo',     17),
(233, 'GM0000033', 'Zelda Tears of the Kingdom',    59.900, 0, 'https://picsum.photos/seed/zelda1/400',       'Jeu d’aventure et exploration',                4.95, 210,'jeux', 'Nintendo',     13),
(234, 'GM0000034', 'Overwatch 2',                    0.000, 0, 'https://picsum.photos/seed/overwatch1/400',   'Jeu de tir en équipe free-to-play',            4.20, 95, 'jeux', 'Blizzard',     40),
(235, 'GM0000035', 'Roblox Robux Pack',              9.900, 0, 'https://picsum.photos/seed/roblox1/400',      'Pack de monnaie virtuelle Roblox',             4.00, 400,'jeux', 'Roblox Corp',  100),
(236, 'GM0000036', 'Candy Crush Boost Pack',         4.900, 0, 'https://picsum.photos/seed/candycrush1/400',  'Pack de boosts pour puzzle mobile',            3.90, 60, 'jeux', 'King',         80),
(237, 'GM0000037', 'Gran Turismo 7',                 64.900, 0,'https://picsum.photos/seed/gt7/400',          'Simulation de course automobile',              4.70, 55, 'jeux', 'Sony',         12),
(238, 'GM0000038', 'Pokemon Écarlate',               54.900, 0,'https://picsum.photos/seed/pokemon1/400',     'Jeu de rôle et capture de créatures',          4.80, 175,'jeux', 'Nintendo',     15),
(239, 'GM0000039', 'Assassin''s Creed Mirage',       49.900, 5,'https://picsum.photos/seed/assassin1/400',    'Jeu d’aventure et infiltration',               4.30, 70, 'jeux', 'Ubisoft',      10),
(240, 'GM0000040', 'Tetris Effect Connected',        29.900, 0,'https://picsum.photos/seed/tetris1/400',      'Jeu de puzzle classique revisité',             4.60, 30, 'jeux', 'Enhance',      28);

-- ============================================
-- Données de test : games (20 lignes, une par produit ci-dessus)
-- ============================================
INSERT INTO games (id_game, genre) VALUES
(221, 'mixte'),   -- FIFA 25
(222, 'garcon'),  -- Minecraft
(223, 'garcon'),  -- GTA V
(224, 'mixte'),   -- Mario Kart 8 Deluxe
(225, 'mixte'),   -- Just Dance 2025
(226, 'fille'),   -- Barbie Dreamhouse Adventures
(227, 'garcon'),  -- Call of Duty Modern Warfare
(228, 'mixte'),   -- The Sims 4
(229, 'mixte'),   -- Animal Crossing New Horizons
(230, 'garcon'),  -- Fortnite Battle Pass
(231, 'garcon'),  -- League of Legends Skin Pack
(232, 'mixte'),   -- Super Mario Odyssey
(233, 'mixte'),   -- Zelda Tears of the Kingdom
(234, 'garcon'),  -- Overwatch 2
(235, 'mixte'),   -- Roblox Robux Pack
(236, 'fille'),   -- Candy Crush Boost Pack
(237, 'garcon'),  -- Gran Turismo 7
(238, 'mixte'),   -- Pokemon Écarlate
(239, 'garcon'),  -- Assassin's Creed Mirage
(240, 'mixte');   -- Tetris Effect Connected

-- ==========================================================
-- DONNEES DE TEST : PRODUIT (id 300 -> 320)
-- ==========================================================

INSERT INTO produit (id_produit, code_barre, libelle, prix, remise, image_url, description, rating, nombre_rater, categorie, marque, quantite_stock, date_ajout) VALUES
(300, 'BC0000000300', 'Sac à dos Explorer Bleu', 89.900, 10.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Sac à dos résistant avec plusieurs compartiments', 4.50, 120, 'Sacs à dos', 'Eastpak', 35, '2025-01-10 09:00:00'),
(301, 'BC0000000301', 'Cartable Roulettes Licorne', 129.900, 0.00, 'https://images.unsplash.com/photo-1596462502278-27bfdc403348', 'Cartable à roulettes pour fille avec motif licorne', 4.80, 95, 'Sacs à chariot', 'Jeune Premier', 20, '2025-01-11 09:00:00'),
(302, 'BC0000000302', 'Trousse Scolaire Simple', 19.900, 5.00, 'https://images.unsplash.com/photo-1512909006721-3d6018887383', 'Trousse simple compartiment', 4.10, 60, 'Trousses', 'Générique', 80, '2025-01-12 09:00:00'),
(303, 'BC0000000303', 'Panier Scolaire Préscolaire', 39.900, 0.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Panier léger pour enfants du préscolaire', 4.30, 40, 'Paniers', 'Générique', 50, '2025-01-13 09:00:00'),
(304, 'BC0000000304', 'Sac à dos Sport Garçon', 99.900, 15.00, 'https://images.unsplash.com/photo-1547949003-9792a18a2645', 'Sac à dos robuste pour le sport et l\'école', 4.40, 75, 'Sacs à dos', 'Nike', 25, '2025-01-14 09:00:00'),
(305, 'BC0000000305', 'Chariot Scolaire XL', 149.900, 0.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Chariot scolaire grande capacité', 4.60, 30, 'Chariots', 'Générique', 15, '2025-01-15 09:00:00'),
(306, 'BC0000000306', 'Sac à dos Mixte Gris', 79.900, 5.00, 'https://images.unsplash.com/photo-1491637639811-60e2756cbb93', 'Sac à dos unisexe couleur grise', 4.20, 50, 'Sacs à dos', 'Adidas', 40, '2025-01-16 09:00:00'),
(307, 'BC0000000307', 'Trousse Double Compartiment', 24.900, 0.00, 'https://images.unsplash.com/photo-1512909006721-3d6018887383', 'Trousse avec deux compartiments', 4.00, 33, 'Trousses', 'Générique', 70, '2025-01-17 09:00:00'),
(308, 'BC0000000308', 'Cartable Superman', 119.900, 10.00, 'https://images.unsplash.com/photo-1596462502278-27bfdc403348', 'Cartable à roulettes motif super-héros', 4.70, 88, 'Sacs à chariot', 'Jeune Premier', 18, '2025-01-18 09:00:00'),
(309, 'BC0000000309', 'Sac à dos Primaire Rose', 69.900, 0.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Sac à dos rose pour filles du primaire', 4.35, 55, 'Sacs à dos', 'Générique', 45, '2025-01-19 09:00:00'),
(310, 'BC0000000310', 'Panier Maternelle Ourson', 34.900, 0.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Panier léger motif ourson', 4.25, 20, 'Paniers', 'Générique', 30, '2025-01-20 09:00:00'),
(311, 'BC0000000311', 'Sac à dos Secondaire Noir', 109.900, 20.00, 'https://images.unsplash.com/photo-1491637639811-60e2756cbb93', 'Sac à dos élégant pour lycéens', 4.55, 65, 'Sacs à dos', 'Eastpak', 28, '2025-01-21 09:00:00'),
(312, 'BC0000000312', 'Trousse Motif Étoiles', 22.900, 0.00, 'https://images.unsplash.com/photo-1512909006721-3d6018887383', 'Trousse compacte motif étoiles', 4.15, 41, 'Trousses', 'Générique', 60, '2025-01-22 09:00:00'),
(313, 'BC0000000313', 'Chariot Léger Bleu Marine', 139.900, 0.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Chariot scolaire léger et solide', 4.45, 22, 'Chariots', 'Générique', 12, '2025-01-23 09:00:00'),
(314, 'BC0000000314', 'Sac à dos Base Vert', 74.900, 5.00, 'https://images.unsplash.com/photo-1547949003-9792a18a2645', 'Sac à dos coloré pour cycle de base', 4.30, 48, 'Sacs à dos', 'Générique', 38, '2025-01-24 09:00:00'),
(315, 'BC0000000315', 'Cartable Princesse Rose', 124.900, 0.00, 'https://images.unsplash.com/photo-1596462502278-27bfdc403348', 'Cartable à roulettes motif princesse', 4.75, 90, 'Sacs à chariot', 'Jeune Premier', 16, '2025-01-25 09:00:00'),
(316, 'BC0000000316', 'Sac à dos Mixte Camouflage', 84.900, 0.00, 'https://images.unsplash.com/photo-1491637639811-60e2756cbb93', 'Sac à dos motif camouflage unisexe', 4.20, 37, 'Sacs à dos', 'Adidas', 33, '2025-01-26 09:00:00'),
(317, 'BC0000000317', 'Trousse Cuir Simili', 29.900, 0.00, 'https://images.unsplash.com/photo-1512909006721-3d6018887383', 'Trousse en simili cuir robuste', 4.05, 27, 'Trousses', 'Générique', 55, '2025-01-27 09:00:00'),
(318, 'BC0000000318', 'Panier Préscolaire Voiture', 37.900, 0.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Panier motif voiture pour garçon', 4.20, 19, 'Paniers', 'Générique', 25, '2025-01-28 09:00:00'),
(319, 'BC0000000319', 'Sac à dos Secondaire Bordeaux', 114.900, 10.00, 'https://images.unsplash.com/photo-1547949003-9792a18a2645', 'Sac à dos couleur bordeaux pour lycéens', 4.60, 70, 'Sacs à dos', 'Eastpak', 24, '2025-01-29 09:00:00'),
(320, 'BC0000000320', 'Chariot Compact Rouge', 134.900, 0.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', 'Chariot scolaire compact et pratique', 4.40, 29, 'Chariots', 'Générique', 14, '2025-01-30 09:00:00');


-- ==========================================================
-- DONNEES DE TEST : COLLECTION (id_produit 300 -> 320)
-- ==========================================================

INSERT INTO collection (id_produit, genre, type, niveau_scolaire, couleur, marque, matiere, roulettes, nombre_compartiments) VALUES
(300, 'garçon', 'sac a dos', '6ème Primaire', 'Bleu', 'Eastpak', 'Polyester', FALSE, 3),
(301, 'fille', 'sac a chariot', '2ème Primaire', 'Rose', 'Jeune Premier', 'Polyester renforcé', TRUE, 4),
(302, 'mixte', 'trousse', '4ème Primaire', 'Noir', 'Générique', 'Toile', FALSE, 1),
(303, 'mixte', 'panier', 'Préscolaire', 'Jaune', 'Générique', 'Tissu coton', FALSE, 1),
(304, 'garçon', 'sac a dos', '1ère Secondaire', 'Noir/Rouge', 'Nike', 'Nylon', FALSE, 3),
(305, 'mixte', 'chariot', '7ème Base', 'Gris', 'Générique', 'Polyester rigide', TRUE, 5),
(306, 'mixte', 'sac a dos', '9ème Base', 'Gris', 'Adidas', 'Polyester', FALSE, 2),
(307, 'fille', 'trousse', '3ème Primaire', 'Violet', 'Générique', 'Toile', FALSE, 2),
(308, 'garçon', 'sac a chariot', '1ère Primaire', 'Bleu/Rouge', 'Jeune Premier', 'Polyester renforcé', TRUE, 4),
(309, 'fille', 'sac a dos', '5ème Primaire', 'Rose', 'Générique', 'Polyester', FALSE, 2),
(310, 'mixte', 'panier', 'Préscolaire', 'Marron', 'Générique', 'Tissu coton', FALSE, 1),
(311, 'garçon', 'sac a dos', '4ème Secondaire', 'Noir', 'Eastpak', 'Nylon', FALSE, 3),
(312, 'fille', 'trousse', '2ème Primaire', 'Bleu ciel', 'Générique', 'Toile', FALSE, 1),
(313, 'mixte', 'chariot', '8ème Base', 'Bleu marine', 'Générique', 'Polyester rigide', TRUE, 4),
(314, 'garçon', 'sac a dos', '9ème Base', 'Vert', 'Générique', 'Polyester', FALSE, 3),
(315, 'fille', 'sac a chariot', '3ème Primaire', 'Rose', 'Jeune Premier', 'Polyester renforcé', TRUE, 4),
(316, 'mixte', 'sac a dos', '2ème Secondaire', 'Kaki', 'Adidas', 'Nylon', FALSE, 2),
(317, 'garçon', 'trousse', '6ème Primaire', 'Marron', 'Générique', 'Simili cuir', FALSE, 2),
(318, 'garçon', 'panier', 'Préscolaire', 'Rouge', 'Générique', 'Tissu coton', FALSE, 1),
(319, 'garçon', 'sac a dos', '3ème Secondaire', 'Bordeaux', 'Eastpak', 'Polyester', FALSE, 3),
(320, 'mixte', 'chariot', '1ère Secondaire', 'Rouge', 'Générique', 'Polyester rigide', TRUE, 4);






select * from produit p , collection c where p.id_produit = c.id_produit;

-- find du données de teste 

show columns from sac;
use librairieDB_v2;

select * from pack pa , ligne_commande lc , commande c where lc.id_commande = c.id_commande and lc.id_produit = pa.id_pack;

select * from produit;
select * from commande;
select * from games;
select count(*) from games;	
show tables;
use librairiedb_v2;
select * from produit where categorie="autres";	


select * from commande where id_commande = 6;
select * from ligne_commande where id_commande=6;
select * from collection;
select prix * 4 from produit where id_produit=17;

show tables;
select * from pack;
select * from client;	
select count(*) from games g , produit p where p.id_produit = g.id_game;
show columns from games;
select * from client where id_client = 21;



select p.* , g.genre from produit p , games g where g.id_game = p.id_produit ;


-- remove niveau scolaire marque , couleur roulettes nombre_compartiments 
alter table collection 
drop column marque;
update client set role= "admin" where id_client = 23;
select count(*) from games;