create database if not exists librairieDB;
use librairieDB;

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



-- alter 
drop trigger after_ligne_commande_insert;
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
-- ############################################################################################
-- ############################################################################################
-- ############################################################################################
-- ##################################Huge dataset -- ##########################################
-- ############################################################################################
-- ############################################################################################
-- ############################################################################################
-- ############################################################################################
/* =========================
   PRODUIT (50 rows updated)
========================= */

INSERT INTO produit VALUES
(1,'CB001','Cahier 100 pages',2.500,200,'papeterie','MaxiPaper','img1.jpg',0,''),
(2,'CB002','Stylo bleu',1.200,300,'ecriture','Bic','img2.jpg',0,''),
(3,'CB003','Stylo rouge',1.200,250,'ecriture','Bic','img3.jpg',0,''),
(4,'CB004','Crayon HB',0.800,400,'dessin_arts','Faber','img4.jpg',0,''),
(5,'CB005','Gomme blanche',0.500,150,'papeterie','Staedtler','img5.jpg',0,''),
(6,'CB006','Règle 30cm',1.500,120,'geometrie','Maped','img6.jpg',0,''),
(7,'CB007','Sac à dos',25.000,80,'sacs_accessoires','Nike','img7.jpg',0,''),
(8,'CB008','Trousse scolaire',10.000,100,'sacs_accessoires','Decathlon','img8.jpg',0,''),
(9,'CB009','Classeur A4',4.000,90,'classement','Esselte','img9.jpg',0,''),
(10,'CB010','Feuilles A4',3.500,500,'papeterie','PaperOne','img10.jpg',0,''),
(11,'CB011','Calculatrice',18.000,60,'calcul_sciences','Casio','img11.jpg',0,''),
(12,'CB012','Agenda 2026',6.000,70,'fournitures_bureau','Oxford','img12.jpg',0,''),
(13,'CB013','Surligneur jaune',1.100,200,'ecriture','Stabilo','img13.jpg',0,''),
(14,'CB014','Surligneur vert',1.100,200,'ecriture','Stabilo','img14.jpg',0,''),
(15,'CB015','Surligneur rose',1.100,200,'ecriture','Stabilo','img15.jpg',0,''),

(16,'PK001','Pack Primaire Base',0.000,0,'others','system','img16.jpg',0,''),
(17,'PK002','Pack Secondaire Base',0.000,0,'others','system','img17.jpg',0,''),
(18,'PK003','Pack Bac Base',0.000,0,'others','system','img18.jpg',0,''),
(19,'PK004','Pack College Base',0.000,0,'others','system','img19.jpg',0,''),

(20,'CB020','Correcteur',2.200,100,'coupe_collage','Bic','img20.jpg',0,''),
(21,'CB021','Feutre noir',1.300,150,'dessin_arts','Faber','img21.jpg',0,''),
(22,'CB022','Bloc-notes',2.800,130,'papeterie','Oxford','img22.jpg',0,''),
(23,'CB023','Dossier plastique',0.900,220,'classement','Esselte','img23.jpg',0,''),
(24,'CB024','Perforatrice',5.500,50,'fournitures_bureau','Maped','img24.jpg',0,''),
(25,'CB025','Agrafeuse',7.000,60,'fournitures_bureau','Maped','img25.jpg',0,''),
(26,'CB026','Agrafes',1.000,300,'fournitures_bureau','Generic','img26.jpg',0,''),
(27,'CB027','Marqueur permanent',2.000,140,'ecriture','Sharpie','img27.jpg',0,''),
(28,'CB028','Cartable cuir',40.000,40,'sacs_accessoires','Samsonite','img28.jpg',0,''),
(29,'CB029','Taille-crayon',0.700,180,'coupe_collage','Maped','img29.jpg',0,''),
(30,'CB030','Colle stick',1.400,160,'coupe_collage','UHU','img30.jpg',0,''),
(31,'CB031','Papier couleur',3.200,110,'dessin_arts','Clairefontaine','img31.jpg',0,''),
(32,'CB032','Compas',2.600,90,'geometrie','Maped','img32.jpg',0,''),
(33,'CB033','Équerre',1.600,120,'geometrie','Maped','img33.jpg',0,''),
(34,'CB034','Protège-cahier',0.800,250,'papeterie','Generic','img34.jpg',0,''),
(35,'CB035','Ardoise scolaire',4.500,70,'numerique','Generic','img35.jpg',0,''),
(36,'CB036','Chiffon tableau',1.000,100,'papeterie','Generic','img36.jpg',0,''),
(37,'CB037','Clé USB 32GB',12.000,80,'numerique','SanDisk','img37.jpg',0,''),
(38,'CB038','Casque audio',30.000,50,'numerique','Sony','img38.jpg',0,''),
(39,'CB039','Souris USB',15.000,90,'numerique','Logitech','img39.jpg',0,''),
(40,'CB040','Clavier USB',20.000,70,'numerique','Logitech','img40.jpg',0,''),
(41,'CB041','Support laptop',18.000,60,'numerique','Trust','img41.jpg',0,''),
(42,'CB042','Chargeur USB',8.000,120,'numerique','Anker','img42.jpg',0,''),
(43,'CB043','Lampe bureau',14.000,80,'fournitures_bureau','Ikea','img43.jpg',0,''),
(44,'CB044','Horloge murale',9.000,60,'fournitures_bureau','Generic','img44.jpg',0,''),
(45,'CB045','Boîte rangement',6.500,100,'classement','Ikea','img45.jpg',0,''),
(46,'CB046','Agrafe géante',1.200,200,'fournitures_bureau','Generic','img46.jpg',0,''),
(47,'CB047','Ruban adhésif',1.500,180,'coupe_collage','3M','img47.jpg',0,''),
(48,'CB048','Papier kraft',2.000,140,'dessin_arts','Generic','img48.jpg',0,''),
(49,'CB049','Sac plastique',0.300,500,'classement','Generic','img49.jpg',0,''),
(50,'CB050','Carnet poche',2.000,160,'papeterie','MaxiPaper','img50.jpg',0,'');



/* باقي الجداول (UNCHANGED) */

INSERT INTO pack VALUES
(16,'primaire'),(17,'secondaire'),(18,'bac'),(19,'college'),
(1,'primaire'),(2,'primaire'),(3,'primaire'),(4,'primaire'),(5,'primaire'),
(6,'primaire'),(7,'primaire'),(8,'primaire'),(9,'primaire'),(10,'primaire'),
(11,'secondaire'),(12,'secondaire'),(13,'secondaire'),(14,'secondaire'),(15,'secondaire'),
(20,'bac'),(21,'bac'),(22,'bac'),(23,'bac'),(24,'bac'),
(25,'college'),(26,'college'),(27,'college'),(28,'college'),(29,'college'),(30,'college');

INSERT INTO packArticle VALUES
(16,1,10),(16,2,5),(16,4,10),(16,5,5),
(17,1,15),(17,2,10),(17,3,10),(17,10,20),
(18,11,1),(18,12,2),(18,37,1),
(19,7,1),(19,8,1),(19,6,2),
(20,20,3),(20,21,2),(20,22,2),
(21,23,5),(21,24,2),(21,25,2),
(22,30,3),(22,32,2),(22,33,2),
(23,37,1),(23,39,1),(23,40,1),
(24,42,2),(24,43,1),(24,44,1),
(25,45,2),(25,46,5),(25,47,3),
(26,48,3),(26,49,10),(26,50,2);

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

INSERT INTO commande(id_client,date_commande,statut,adresse,ville,code_postal,prix_totale,commentaire) VALUES
(1,'2026-06-01','livrée','Rue A','Tunis','1000',0,''),
(2,'2026-06-02','confirmée','Rue B','Ariana','2000',0,''),
(3,'2026-06-03','attente','Rue C','Sousse','4000',0,''),
(4,'2026-06-04','livrée','Rue D','Sfax','3000',0,''),
(5,'2026-06-05','annulée','Rue E','Tunis','1000',0,''),
(6,'2026-06-06','livrée','Rue F','Nabeul','8000',0,''),
(7,'2026-06-07','confirmée','Rue G','Bizerte','7000',0,''),
(8,'2026-06-08','attente','Rue H','Monastir','5000',0,''),
(9,'2026-06-09','livrée','Rue I','Mahdia','6000',0,''),
(10,'2026-06-10','confirmée','Rue J','Tunis','1000',0,''),
(11,'2026-06-11','attente','Rue K','Sfax','3000',0,''),
(12,'2026-06-12','livrée','Rue L','Sousse','4000',0,''),
(13,'2026-06-13','confirmée','Rue M','Ariana','2000',0,''),
(14,'2026-06-14','annulée','Rue N','Tunis','1000',0,''),
(15,'2026-06-15','livrée','Rue O','Nabeul','8000',0,''),
(16,'2026-06-16','attente','Rue P','Bizerte','7000',0,''),
(17,'2026-06-17','confirmée','Rue Q','Mahdia','6000',0,''),
(18,'2026-06-18','livrée','Rue R','Monastir','5000',0,''),
(19,'2026-06-19','attente','Rue S','Tunis','1000',0,''),
(20,'2026-06-20','confirmée','Rue T','Sfax','3000',0,''),
(21,'2026-06-21','livrée','Rue U','Sousse','4000',0,''),
(22,'2026-06-22','attente','Rue V','Ariana','2000',0,''),
(23,'2026-06-23','confirmée','Rue W','Tunis','1000',0,''),
(24,'2026-06-24','livrée','Rue X','Nabeul','8000',0,''),
(25,'2026-06-25','annulée','Rue Y','Bizerte','7000',0,''),
(26,'2026-06-26','attente','Rue Z','Mahdia','6000',0,''),
(27,'2026-06-27','confirmée','Rue AA','Monastir','5000',0,''),
(28,'2026-06-28','livrée','Rue BB','Tunis','1000',0,''),
(29,'2026-06-29','attente','Rue CC','Sfax','3000',0,''),
(30,'2026-06-30','confirmée','Rue DD','Sousse','4000',0,'');

INSERT INTO ligne_commande VALUES
(1,1,2,5.000),(1,2,3,3.600),
(2,3,2,2.400),(2,4,5,4.000),
(3,5,2,1.000),(3,6,2,3.000),
(4,7,1,25.000),(4,8,1,10.000),
(5,9,2,8.000),(5,10,5,17.500),
(6,11,1,18.000),(6,12,2,12.000),
(7,13,10,11.000),(7,14,5,5.500),
(8,15,3,3.300),(8,20,2,4.400),
(9,21,4,5.200),(9,22,2,5.600),
(10,23,3,2.700),(10,24,1,5.500),
(11,25,2,14.000),(11,26,10,10.000),
(12,27,3,6.000),(12,28,1,40.000),
(13,29,5,3.500),(13,30,2,2.800),
(14,31,3,9.600),(14,32,2,5.200),
(15,33,3,4.800),(15,34,5,4.000),
(16,35,2,9.000),(16,36,3,3.000),
(17,37,1,12.000),(17,38,1,30.000),
(18,39,2,30.000),(18,40,1,20.000),
(19,41,1,18.000),(19,42,2,16.000),
(20,43,2,28.000),(20,44,1,9.000),
(21,45,2,13.000),(21,46,5,6.000),
(22,47,3,4.500),(22,48,2,4.000),
(23,49,10,3.000),(23,50,2,4.000),
(24,1,3,7.500),(24,2,4,4.800),
(25,3,5,6.000),(25,4,6,4.800),
(26,5,3,1.500),(26,6,2,3.000),
(27,7,1,25.000),(27,8,1,10.000),
(28,9,2,8.000),(28,10,5,17.500),
(29,11,1,18.000),(29,12,2,12.000),
(30,13,4,4.400),(30,14,3,3.300);

INSERT INTO userLogin(id_client,loginAt) VALUES
(1,'2026-07-01 08:00:00'),(2,'2026-07-01 08:10:00'),
(3,'2026-07-01 08:20:00'),(4,'2026-07-01 08:30:00'),
(5,'2026-07-01 08:40:00'),(6,'2026-07-01 08:50:00'),
(7,'2026-07-01 09:00:00'),(8,'2026-07-01 09:10:00'),
(9,'2026-07-01 09:20:00'),(10,'2026-07-01 09:30:00'),
(11,'2026-07-01 09:40:00'),(12,'2026-07-01 09:50:00'),
(13,'2026-07-01 10:00:00'),(14,'2026-07-01 10:10:00'),
(15,'2026-07-01 10:20:00'),(16,'2026-07-01 10:30:00'),
(17,'2026-07-01 10:40:00'),(18,'2026-07-01 10:50:00'),
(19,'2026-07-01 11:00:00'),(20,'2026-07-01 11:10:00'),
(21,'2026-07-01 11:20:00'),(22,'2026-07-01 11:30:00'),
(23,'2026-07-01 11:40:00'),(24,'2026-07-01 11:50:00'),
(25,'2026-07-01 12:00:00'),(26,'2026-07-01 12:10:00'),
(27,'2026-07-01 12:20:00'),(28,'2026-07-01 12:30:00'),
(29,'2026-07-01 12:40:00'),(30,'2026-07-01 12:50:00');



use librairieDB;
select count(*) from produit
where id_produit not in (select distinct(id_pack) from pack);

select * from pack;

select id_client , count(*)
from commande
group by id_client;

select * from commande;