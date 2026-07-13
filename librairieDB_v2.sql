create database if not exists librairieDB_v2;
use librairieDB_v2;
create table produit(
	id_produit int primary key auto_increment,
    code_barre varchar(50) ,
    libelle varchar(50),
    prix decimal(8,3) not null check(prix>=0),
    quantite_stock int not null check(quantite_stock >= 0),
    categorie varchar(50) not null,
    marque varchar(50),
    image_url varchar(255),
    remise decimal(6,3) default 0,
    description varchar(255) default ''
);

create table pack(
	id_pack int ,
    type varchar(255) check (type in ("primaire", "secondaire" , "bac", "college")),

    primary key(id_pack),
    foreign key (id_pack) references produit(id_produit) on delete cascade on update cascade
);

create table packArticle(
	id_pack int,
    id_produit int ,
    quantite int default 1,
    primary key(id_pack, id_produit),
    foreign key(id_pack) references produit(id_produit) on delete cascade on update cascade,
    foreign key(id_produit) references produit(id_produit) on delete cascade on update cascade
);
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


create table ligne_commande(
    id_commande int references commande(id_commande),
    id_produit int references produit(id_produit) , 
    quantite int not null,
    sous_total decimal(8,3),
    primary key(id_commande,id_produit),
    foreign key(id_commande) references commande(id_commande) on delete cascade on update cascade,
    foreign key(id_produit) references produit(id_produit) on delete cascade on update cascade
    
);

create table userLogin(
    id int auto_increment,
    id_client int not null,
    loginAt datetime not null default current_timestamp,
    primary key(id),
    foreign key(id_client) references client(id_client)
);



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



-- ############################################################################################
-- ##########################  PRODUIT (17 articles - nouveau jeu de données) #################
-- ############################################################################################
-- Mêmes corrections que dans le script précédent :
--  - id 2 et id 14 avaient le même code_barre (1221354) -> code_barre unique généré pour id 14
--  - id 5 (Feutre de colorisation) avait un prix de 11000.000 (erreur de saisie) -> corrigé à 11.000
--  - id 13 et id 17 avaient un code_barre NULL -> code_barre généré pour cohérence

INSERT INTO produit VALUES
(1,'546515','Stylo bic a 12 stylos',20.000,350,'ecriture','BIC','/assets/images/uploadedImg/articles/b915a0ee3e39fa1997ec612d3232b987.webp',0.000,'pack de stylo bic'),
(2,'1221354','Agrafeuse',20.000,45,'papeterie','Maped','/assets/images/uploadedImg/articles/0a0c1b3a70bed4af70f6b90cfc5bc6be.webp',0.000,'grafeuse'),
(3,'45494984','Papier coloré',2.900,15,'papeterie','Maped','/assets/images/uploadedImg/articles/826fb6a3fbf62bee268c492f3069403.jpeg',1.000,'des papiers multicolors'),
(4,'54164132','Fleurissant',2.500,50,'ecriture','Maped','/assets/images/uploadedImg/articles/000ac1f3dd576cb63272b76ad640251e.jpeg',0.000,'pack de fleurissant'),
(5,'54112321654','Feutre de colorisation',11.000,45,'ecriture','Stabilo','/assets/images/uploadedImg/articles/000ac1f3dd576cb63272b76ad640251e.jpeg',0.000,'jelo feutre multicolor'),
(6,'79445','Stylo point fine',5.000,455,'ecriture','BIC','/assets/images/uploadedImg/articles/fe8fa0c5fcc75676c92c3923be42013b.jpg',0.000,'pack de 6 stylo point fine'),
(7,'1616216515','18 stylo a ecriture',15.000,15,'ecriture','Maped','/assets/images/uploadedImg/articles/0552a3237dd61790f43f6437f294a50d.jpg',0.000,'18 stylo de couleur differents'),
(8,'1165165161','Ciseau bic',12.000,25,'papeterie','BIC','/assets/images/uploadedImg/articles/3787aecca17b36bc44c88c56252c5a02.webp',0.000,'un ciseau professionell pour les e'),
(9,'4161651461','Colle a barre',3.500,15,'papeterie','BIC','/assets/images/uploadedImg/articles/d25e8473ae7888f314991f1150feaee2.webp',0.000,'colle fort tube'),
(10,'456151','Jouet Barbie',20.000,23,'others','other','/assets/images/uploadedImg/articles/22dfa1829658d8db9b6e33be00285f28.webp',0.000,'jouet de fille barbie'),
(11,'15165156','Stylo feutre',15.000,32,'papeterie','Maped','/assets/images/uploadedImg/articles/90fdfab1433d9b100afeb7d5aca4736.webp',0.000,'pack de feutres'),
(12,'16211651','Tabachir',5.600,20,'ecriture','Maped','/assets/images/uploadedImg/articles/b665750c0326633f64d6a03b0915ad3e.webp',0.000,'bakou tabachir abyedh'),
(13,'7000000013','Pack fleurissant',12.500,52,'ecriture','Maped','/assets/images/uploadedImg/articles/83f10c275fccd2339c198cc2d197f530.webp',0.000,'4 ka3bet fleurissant'),
(14,'9812213541','Koura ardheya',10.000,3,'fournitures_bureau','Pilot','/assets/images/uploadedImg/articles/95147eda221570410e7134106f6a1e8f.webp',0.000,'koura ardheya petit size'),
(15,'561651641','Crayon',1.500,20,'ecriture','Maped','/assets/images/uploadedImg/articles/492e054c017befd2e41665cc3ab55914.webp',0.000,'crayon bonne qualité'),
(16,'454649848','Calculatrice scientifique rose',15.000,20,'calcul_sciences','other','/assets/images/uploadedImg/articles/54554ecfa45411389928b21343e82604.webp',0.000,'calculatrice scientifique'),
(17,'7000000017','Chemise a baguette',1.200,50,'papeterie','other','/assets/images/uploadedImg/articles/d82787d63ef8a2732f5076e7ff07ed08.webp',0.000,'chemise a baguette multicolor');

-- NB : pack/packArticle non alimentées (aucun des 17 produits n'est un pack scolaire).


-- ############################################################################################
-- ##########################  CLIENT (30 existants - INCHANGÉ + 20 nouveaux) #################
-- ############################################################################################
-- L'insert original (30 clients) n'avait pas de colonne "addresse" -> gardé identique, non modifié.

INSERT INTO client(nom,prenom,tel,email,password,role) VALUES
('Ali','Ben','20000001','ali1@gmail.com','pass','client'),
('Sara','Triki','20000002','sara2@gmail.com','pass','client'),
('Omar','Haddad','20000003','omar3@gmail.com','pass','client'),
('Yassine','Mabrouk','20000004','yass4@gmail.com','pass','client'),
('Amira','Zouari','20000005','amira5@gmail.com','pass','client'),
('Khalil','Jaziri','20000006','khalil6@gmail.com','pass','client'),
('Nour','Ben Ali','20000007','nour7@gmail.com','pass','client'),
('Mehdi','Kacem','20000008','mehdi8@gmail.com','pass','client'),
('Hiba','Saidi','20000009','hiba9@gmail.com','pass','client'),
('Firas','Messaoudi','20000010','firas10@gmail.com','pass','client'),
('User11','L11','20000011','u11@gmail.com','pass','client'),
('User12','L12','20000012','u12@gmail.com','pass','client'),
('User13','L13','20000013','u13@gmail.com','pass','client'),
('User14','L14','20000014','u14@gmail.com','pass','client'),
('User15','L15','20000015','u15@gmail.com','pass','client'),
('User16','L16','20000016','u16@gmail.com','pass','client'),
('User17','L17','20000017','u17@gmail.com','pass','client'),
('User18','L18','20000018','u18@gmail.com','pass','client'),
('User19','L19','20000019','u19@gmail.com','pass','client'),
('User20','L20','20000020','u20@gmail.com','pass','client'),
('User21','L21','20000021','u21@gmail.com','pass','client'),
('User22','L22','20000022','u22@gmail.com','pass','client'),
('User23','L23','20000023','u23@gmail.com','pass','client'),
('User24','L24','20000024','u24@gmail.com','pass','client'),
('User25','L25','20000025','u25@gmail.com','pass','client'),
('User26','L26','20000026','u26@gmail.com','pass','client'),
('User27','L27','20000027','u27@gmail.com','pass','client'),
('User28','L28','20000028','u28@gmail.com','pass','client'),
('User29','L29','20000029','u29@gmail.com','pass','client'),
('User30','L30','20000030','u30@gmail.com','pass','client');

-- 20 nouveaux clients (ids 31 à 50) - avec addresse renseignée puisque la colonne existe maintenant
INSERT INTO client(nom,prenom,tel,email,addresse,password,role) VALUES
('Wael','Ferchichi','20000031','wael31@gmail.com','Rue de Marseille, Tunis','pass','client'),
('Rania','Chaabane','20000032','rania32@gmail.com','Avenue Habib Bourguiba, Ariana','pass','client'),
('Aymen','Gharbi','20000033','aymen33@gmail.com','Rue Ibn Khaldoun, Sousse','pass','client'),
('Ines','Bouzid','20000034','ines34@gmail.com','Rue de la Liberté, Sfax','pass','client'),
('Karim','Slimani','20000035','karim35@gmail.com','Rue des Jasmins, Nabeul','pass','client'),
('Sirine','Hamdi','20000036','sirine36@gmail.com','Avenue Farhat Hached, Bizerte','pass','client'),
('Bilel','Tlili','20000037','bilel37@gmail.com','Rue de Carthage, Monastir','pass','client'),
('Emna','Rekik','20000038','emna38@gmail.com','Rue El Manar, Mahdia','pass','client'),
('Anis','Cherif','20000039','anis39@gmail.com','Rue de Paris, Tunis','pass','client'),
('Rim','Bahri','20000040','rim40@gmail.com','Avenue Mohamed V, Sfax','pass','client'),
('Skander','Nasri','20000041','skander41@gmail.com','Rue Kheireddine, Sousse','pass','client'),
('Dorra','Yahyaoui','20000042','dorra42@gmail.com','Rue El Amir, Ariana','pass','client'),
('Ghassen','Louati','20000043','ghassen43@gmail.com','Rue de Londres, Tunis','pass','client'),
('Asma','Kahloun','20000044','asma44@gmail.com','Rue des Orangers, Nabeul','pass','client'),
('Fedi','Marzouki','20000045','fedi45@gmail.com','Avenue Taieb Mhiri, Bizerte','pass','client'),
('Mariem','Ayari','20000046','mariem46@gmail.com','Rue Ibn Sina, Monastir','pass','client'),
('Houssem','Dridi','20000047','houssem47@gmail.com','Rue El Jazira, Mahdia','pass','client'),
('Lina','Sassi','20000048','lina48@gmail.com','Rue de Rome, Tunis','pass','client'),
('Nizar','Ouali','20000049','nizar49@gmail.com','Rue des Lauriers, Sfax','pass','client'),
('Syrine','Barhoumi','20000050','syrine50@gmail.com','Rue El Ferdaous, Sousse','pass','client');


-- ############################################################################################
-- ####################  COMMANDE (25 commandes basées sur les 17 nouveaux produits) ##########
-- ############################################################################################
-- IMPORTANT : contrairement au script précédent, le trigger AFTER INSERT ne met plus à jour
-- prix_totale automatiquement (il ne fait que décrémenter le stock). Le total de chaque
-- commande est donc calculé manuellement ici, en cohérence avec la somme des sous_total
-- des lignes de commande associées.
-- date_commande est maintenant DATETIME (une heure a été ajoutée à chaque date).

INSERT INTO commande(id_client,date_commande,statut,adresse,ville,code_postal,prix_totale,commentaire) VALUES
(1, '2026-07-01 09:00:00','livrée','Rue A','Tunis','1000',140.000,''),
(2, '2026-07-01 10:15:00','confirmée','Rue B','Ariana','2000',13.300,''),
(3, '2026-07-02 09:30:00','attente','Rue C','Sousse','4000',22.000,''),
(4, '2026-07-02 14:00:00','livrée','Rue D','Sfax','3000',80.000,''),
(5, '2026-07-03 11:20:00','confirmée','Rue E','Tunis','1000',43.000,''),
(6, '2026-07-03 16:45:00','attente','Rue F','Nabeul','8000',40.000,''),
(7, '2026-07-04 09:10:00','livrée','Rue G','Bizerte','7000',56.200,''),
(8, '2026-07-04 13:30:00','confirmée','Rue H','Monastir','5000',50.000,''),
(9, '2026-07-05 10:00:00','attente','Rue I','Mahdia','6000',10.000,''),
(10,'2026-07-05 15:50:00','livrée','Rue J','Tunis','1000',34.500,''),
(11,'2026-07-06 08:40:00','confirmée','Rue K','Sfax','3000',6.000,''),
(31,'2026-07-06 12:25:00','attente','Rue L','Sousse','4000',225.000,''),
(32,'2026-07-07 09:15:00','livrée','Rue M','Ariana','2000',65.800,''),
(33,'2026-07-07 17:00:00','confirmée','Rue N','Tunis','1000',43.000,''),
(34,'2026-07-08 10:30:00','attente','Rue O','Nabeul','8000',54.000,''),
(35,'2026-07-08 14:50:00','livrée','Rue P','Bizerte','7000',67.000,''),
(36,'2026-07-09 09:05:00','confirmée','Rue Q','Mahdia','6000',56.200,''),
(37,'2026-07-09 16:20:00','attente','Rue R','Monastir','5000',72.500,''),
(38,'2026-07-10 08:50:00','livrée','Rue S','Tunis','1000',34.500,''),
(39,'2026-07-10 11:10:00','confirmée','Rue T','Sfax','3000',207.200,''),
(40,'2026-07-10 13:40:00','livrée','Rue U','Sousse','4000',75.000,''),
(12,'2026-07-10 15:00:00','attente','Rue V','Ariana','2000',205.800,''),
(13,'2026-07-10 17:30:00','confirmée','Rue W','Tunis','1000',50.000,''),
(14,'2026-07-10 18:10:00','livrée','Rue X','Nabeul','8000',4.800,''),
(15,'2026-07-10 19:00:00','annulée','Rue Y','Bizerte','7000',67.000,'');

-- Mapping id_commande (1 à 25) -> id_client, pour référence des lignes ci-dessous :
-- 1..11 -> clients 1..11 | 12..21 -> clients 31..40 | 22..25 -> clients 12..15


-- ############################################################################################
-- ##########################  LIGNE_COMMANDE (relative à commande + produit) #################
-- ############################################################################################
-- Le trigger before_insert_into_ligne_commande recalcule automatiquement sous_total
-- (prix * quantite) à l'insertion, donc les valeurs indiquées ici sont fournies pour
-- lisibilité mais seront écrasées par le trigger avec le même résultat.
-- Quantités choisies pour rester largement sous le quantite_stock de chaque produit.

INSERT INTO ligne_commande VALUES
(1,1,5,100.000),(1,2,2,40.000),
(2,3,2,5.800),(2,4,3,7.500),
(3,5,2,22.000),
(4,6,10,50.000),(4,7,2,30.000),
(5,8,3,36.000),(5,9,2,7.000),
(6,10,2,40.000),
(7,11,3,45.000),(7,12,2,11.200),
(8,13,4,50.000),
(9,14,1,10.000),
(10,15,3,4.500),(10,16,2,30.000),
(11,17,5,6.000),
(12,1,10,200.000),(12,6,5,25.000),
(13,2,3,60.000),(13,3,2,5.800),
(14,4,4,10.000),(14,5,3,33.000),
(15,7,2,30.000),(15,8,2,24.000),
(16,9,2,7.000),(16,10,3,60.000),
(17,11,3,45.000),(17,12,2,11.200),
(18,13,5,62.500),(18,14,1,10.000),
(19,15,3,4.500),(19,16,2,30.000),
(20,17,6,7.200),(20,1,10,200.000),
(21,6,15,75.000),
(22,1,10,200.000),(22,3,2,5.800),
(23,4,5,12.500),(23,13,3,37.500),
(24,17,4,4.800),
(25,2,3,60.000),(25,9,2,7.000);
select * from produit where prix = 120 ;

-- ############################################################################################
-- ####  40 PACKS SUPPLEMENTAIRES (10 par type) - ids 30 a 69 #################################
-- ############################################################################################
-- Les produits se repetent volontairement entre packs (donnees de test).
-- image_url : base /assets/images/uploadedImg/packImg/ + image dediee par type
--   primaire   -> lettres.png
--   secondaire -> secondaire.png
--   college    -> 64e40814acc4075fe1a5bf58b49bea1f.png
--   bac        -> 908853e94a13574e3b588fafb68b7722.png
delete from produit where id_produit = 22;

INSERT INTO produit VALUES
(30,'9PRI0030','Pack Primaire 1',39.500,30,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',3.950,'Pack primaire variante 1 : 1, 3, 9, 4, 17'),
(31,'9PRI0031','Pack Primaire 2',36.200,15,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',3.620,'Pack primaire variante 2 : 1, 3, 4'),
(32,'9PRI0032','Pack Primaire 3',37.200,30,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',3.720,'Pack primaire variante 3 : 4, 17, 15, 12, 1'),
(33,'9PRI0033','Pack Primaire 4',11.300,25,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',1.130,'Pack primaire variante 4 : 9, 4, 17, 3'),
(34,'9PRI0034','Pack Primaire 5',53.600,25,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',5.360,'Pack primaire variante 5 : 15, 9, 1, 12'),
(35,'9PRI0035','Pack Primaire 6',14.100,20,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',1.410,'Pack primaire variante 6 : 15, 9, 3, 4, 17'),
(36,'9PRI0036','Pack Primaire 7',20.500,25,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',2.050,'Pack primaire variante 7 : 12, 9, 3'),
(37,'9PRI0037','Pack Primaire 8',67.100,20,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',6.710,'Pack primaire variante 8 : 17, 9, 1'),
(38,'9PRI0038','Pack Primaire 9',26.700,15,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',2.670,'Pack primaire variante 9 : 12, 3, 9'),
(39,'9PRI0039','Pack Primaire 10',49.300,20,'pack','Divers','/assets/images/uploadedImg/packImg/lettres.png',4.930,'Pack primaire variante 10 : 3, 1, 9'),
(40,'9SEC0040','Pack Secondaire 1',40.900,25,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',4.090,'Pack secondaire variante 1 : 9, 7, 17, 15, 11'),
(41,'9SEC0041','Pack Secondaire 2',58.800,20,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',5.880,'Pack secondaire variante 2 : 11, 17, 6, 3, 9'),
(42,'9SEC0042','Pack Secondaire 3',169.000,15,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',16.900,'Pack secondaire variante 3 : 6, 11, 8, 2, 7'),
(43,'9SEC0043','Pack Secondaire 4',70.400,15,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',7.040,'Pack secondaire variante 4 : 3, 8, 11, 9, 6'),
(44,'9SEC0044','Pack Secondaire 5',75.200,20,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',7.520,'Pack secondaire variante 5 : 8, 6, 17, 2, 15'),
(45,'9SEC0045','Pack Secondaire 6',70.200,15,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',7.020,'Pack secondaire variante 6 : 17, 2, 8, 6, 7'),
(46,'9SEC0046','Pack Secondaire 7',17.500,20,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',1.750,'Pack secondaire variante 7 : 3, 17, 9'),
(47,'9SEC0047','Pack Secondaire 8',21.900,20,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',2.190,'Pack secondaire variante 8 : 15, 6, 17'),
(48,'9SEC0048','Pack Secondaire 9',76.900,20,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',7.690,'Pack secondaire variante 9 : 7, 8, 17, 9, 6'),
(49,'9SEC0049','Pack Secondaire 10',66.500,20,'pack','Divers','/assets/images/uploadedImg/packImg/secondaire.png',6.650,'Pack secondaire variante 10 : 9, 2, 8'),
(50,'9COL0050','Pack College 1',60.000,15,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',6.000,'Pack college variante 1 : 7, 6, 2'),
(51,'9COL0051','Pack College 2',120.000,20,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',12.000,'Pack college variante 2 : 9, 11, 15, 2, 7'),
(52,'9COL0052','Pack College 3',87.000,30,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',8.700,'Pack college variante 3 : 16, 9, 6, 2'),
(53,'9COL0053','Pack College 4',79.500,30,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',7.950,'Pack college variante 4 : 6, 7, 2, 9, 8'),
(54,'9COL0054','Pack College 5',43.200,30,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',4.320,'Pack college variante 5 : 16, 8, 17'),
(55,'9COL0055','Pack College 6',53.900,30,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',5.390,'Pack college variante 6 : 7, 6, 15, 11, 17'),
(56,'9COL0056','Pack College 7',65.000,25,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',6.500,'Pack college variante 7 : 16, 6, 7'),
(57,'9COL0057','Pack College 8',77.700,25,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',7.770,'Pack college variante 8 : 11, 16, 15, 17'),
(58,'9COL0058','Pack College 9',31.500,30,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',3.150,'Pack college variante 9 : 6, 2, 15'),
(59,'9COL0059','Pack College 10',77.000,30,'pack','Divers','/assets/images/uploadedImg/packImg/64e40814acc4075fe1a5bf58b49bea1f.png',7.700,'Pack college variante 10 : 2, 8, 6, 11, 16'),
(60,'9BAC0060','Pack Bac 1',58.200,30,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',5.820,'Pack bac variante 1 : 8, 11, 17'),
(61,'9BAC0061','Pack Bac 2',60.400,25,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',6.040,'Pack bac variante 2 : 16, 6, 5, 17, 9'),
(62,'9BAC0062','Pack Bac 3',87.000,20,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',8.700,'Pack bac variante 3 : 2, 8, 11'),
(63,'9BAC0063','Pack Bac 4',100.600,25,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',10.060,'Pack bac variante 4 : 11, 5, 6, 2, 17'),
(64,'9BAC0064','Pack Bac 5',80.500,20,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',8.050,'Pack bac variante 5 : 2, 16, 11, 6, 9'),
(65,'9BAC0065','Pack Bac 6',65.000,25,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',6.500,'Pack bac variante 6 : 11, 9, 5, 6'),
(66,'9BAC0066','Pack Bac 7',49.000,25,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',4.900,'Pack bac variante 7 : 5, 16, 8'),
(67,'9BAC0067','Pack Bac 8',93.000,15,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',9.300,'Pack bac variante 8 : 11, 5, 16'),
(68,'9BAC0068','Pack Bac 9',55.000,20,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',5.500,'Pack bac variante 9 : 5, 16, 9'),
(69,'9BAC0069','Pack Bac 10',63.500,15,'pack','Divers','/assets/images/uploadedImg/packImg/908853e94a13574e3b588fafb68b7722.png',6.350,'Pack bac variante 10 : 6, 2, 9, 16');

INSERT INTO pack VALUES
(30,'primaire'),
(31,'primaire'),
(32,'primaire'),
(33,'primaire'),
(34,'primaire'),
(35,'primaire'),
(36,'primaire'),
(37,'primaire'),
(38,'primaire'),
(39,'primaire'),
(40,'secondaire'),
(41,'secondaire'),
(42,'secondaire'),
(43,'secondaire'),
(44,'secondaire'),
(45,'secondaire'),
(46,'secondaire'),
(47,'secondaire'),
(48,'secondaire'),
(49,'secondaire'),
(50,'college'),
(51,'college'),
(52,'college'),
(53,'college'),
(54,'college'),
(55,'college'),
(56,'college'),
(57,'college'),
(58,'college'),
(59,'college'),
(60,'bac'),
(61,'bac'),
(62,'bac'),
(63,'bac'),
(64,'bac'),
(65,'bac'),
(66,'bac'),
(67,'bac'),
(68,'bac'),
(69,'bac');

INSERT INTO packArticle VALUES
(30,1,1),
(30,3,1),
(30,9,3),
(30,4,1),
(30,17,3),
(31,1,1),
(31,3,3),
(31,4,3),
(32,4,2),
(32,17,3),
(32,15,2),
(32,12,1),
(32,1,1),
(33,9,1),
(33,4,1),
(33,17,2),
(33,3,1),
(34,15,3),
(34,9,1),
(34,1,2),
(34,12,1),
(35,15,1),
(35,9,1),
(35,3,1),
(35,4,2),
(35,17,1),
(36,12,2),
(36,9,1),
(36,3,2),
(37,17,3),
(37,9,1),
(37,1,3),
(38,12,3),
(38,3,1),
(38,9,2),
(39,3,2),
(39,1,2),
(39,9,1),
(40,9,2),
(40,7,1),
(40,17,2),
(40,15,1),
(40,11,1),
(41,11,3),
(41,17,2),
(41,6,1),
(41,3,1),
(41,9,1),
(42,6,2),
(42,11,3),
(42,8,2),
(42,2,3),
(42,7,2),
(43,3,1),
(43,8,2),
(43,11,2),
(43,9,1),
(43,6,2),
(44,8,3),
(44,6,3),
(44,17,1),
(44,2,1),
(44,15,2),
(45,17,1),
(45,2,1),
(45,8,2),
(45,6,2),
(45,7,1),
(46,3,2),
(46,17,1),
(46,9,3),
(47,15,3),
(47,6,3),
(47,17,2),
(48,7,2),
(48,8,3),
(48,17,2),
(48,9,1),
(48,6,1),
(49,9,3),
(49,2,1),
(49,8,3),
(50,7,1),
(50,6,1),
(50,2,2),
(51,9,3),
(51,11,1),
(51,15,3),
(51,2,3),
(51,7,2),
(52,16,2),
(52,9,2),
(52,6,2),
(52,2,2),
(53,6,1),
(53,7,1),
(53,2,1),
(53,9,1),
(53,8,3),
(54,16,2),
(54,8,1),
(54,17,1),
(55,7,1),
(55,6,1),
(55,15,1),
(55,11,2),
(55,17,2),
(56,16,2),
(56,6,1),
(56,7,2),
(57,11,3),
(57,16,2),
(57,15,1),
(57,17,1),
(58,6,2),
(58,2,1),
(58,15,1),
(59,2,1),
(59,8,1),
(59,6,3),
(59,11,1),
(59,16,1),
(60,8,1),
(60,11,3),
(60,17,1),
(61,16,2),
(61,6,2),
(61,5,1),
(61,17,2),
(61,9,2),
(62,2,3),
(62,8,1),
(62,11,1),
(63,11,2),
(63,5,2),
(63,6,1),
(63,2,2),
(63,17,3),
(64,2,1),
(64,16,2),
(64,11,1),
(64,6,1),
(64,9,3),
(65,11,1),
(65,9,2),
(65,5,3),
(65,6,2),
(66,5,2),
(66,16,1),
(66,8,1),
(67,11,2),
(67,5,3),
(67,16,2),
(68,5,3),
(68,16,1),
(68,9,2),
(69,6,1),
(69,2,2),
(69,9,1),
(69,16,1);



-- ############################################################################################
-- Vérifications utiles (reprises du script de base)
-- ############################################################################################


select count(*) from produit
where id_produit not in (select distinct(id_pack) from pack);

select * from client;

select id_client , count(*)
from commande
group by id_client;

update client set role="admin" where id_client =51;
select * from produit;
update produit set image_url = "/assets/images/uploadedImg/articles/b20f47d3bee46e04cf76379f2c9c4111.jpeg" where id_produit=11;


use librairieDB_v2;

select * from commande;
select count(*) from commande where date_commande between date_format(curdate() - INTERVAL 11 day,"%Y-%m-%d 00:00:00") and date_format(curdate() - INTERVAL 11 day,"%Y-%m-%d 23:59:59");

select * from ligne_commande , pack where id_pack = id_produit ;

select count(*) from userLogin;