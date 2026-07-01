create database if not exists librairieDB;
use librairieDB;

create table produit(
	id_produit int primary key auto_increment,
    code_barre varchar(50) ,
    libelle varchar(50),
    prix decimal(8,3) not null check(prix>0),
    quantite_stock int not null check(quantite_stock >= 0),
    categorie varchar(50) not null,
    marque varchar(50),
    image_url varchar(255),
    remise decimal(6,3) default 0,
    description varchar(255) default ''
);

create table pack(
	id_pack int ,
    type varchar(255),
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
	password varchar(255) not null ,
    role varchar(50) check(role in("client","admin")) default 'client'
);

create table commande(
	id_commande int auto_increment primary key,
    id_client int,
    date_commande date not null,
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



-- triggers
DELIMITER $$
create trigger after_ligne_commande_insert
after insert on ligne_commande
for each row 
begin 
	-- tna9eslk el quantité ta3 el produit fl stock
	if(select quantite_stock from produit where id_produit= new.id_produit) > new.quantite then
		update produit 
		set quantite_stock = quantite_stock - new.quantite 
		where id_produit = new.id_produit;
	else 
		signal sqlstate '45000'
        set message_text = "Stock insuffisant";
	end if;
    
	-- te7seblk el total automatique
    update commande 
    set prix_totale = prix_totale + new.sous_total
    where id_commande = new.id_commande;
end$$
DELIMITER ;

select * from produit ;
/* =========================
   PRODUIT (20 rows)
========================= */
INSERT INTO produit VALUES
(1,'CB001','laptop dell',100.500,10,'informatique','dell','img1.jpg',0,'pc portable'),
(2,'CB002','souris logitech',25.990,100,'informatique','logitech','img2.jpg',0,'souris sans fil'),
(3,'CB003','clavier mecanique',80.000,50,'informatique','redragon','img3.jpg',5,'rgb keyboard'),
(4,'CB004','ecran samsung',300.000,20,'informatique','samsung','img4.jpg',10,'monitor 24'),
(5,'CB005','imprimante hp',150.000,15,'informatique','hp','img5.jpg',0,'printer'),
(6,'CB006','telephone iphone',999.990,25,'mobile','apple','img6.jpg',0,'iphone smartphone'),
(7,'CB007','telephone samsung',700.000,30,'mobile','samsung','img7.jpg',5,'android phone'),
(8,'CB008','chargeur usb-c',15.500,200,'accessoire','anker','img8.jpg',0,'fast charge'),
(9,'CB009','casque audio',60.000,80,'audio','sony','img9.jpg',0,'headphones'),
(10,'CB010','cle usb 64gb',12.000,150,'stockage','kingston','img10.jpg',0,'usb storage'),
(11,'CB011','ssd 1tb',110.000,40,'stockage','samsung','img11.jpg',0,'ssd disk'),
(12,'CB012','hdd 2tb',90.000,35,'stockage','wd','img12.jpg',0,'hard disk'),
(13,'CB013','routeur wifi',55.000,60,'reseau','tp-link','img13.jpg',0,'wifi router'),
(14,'CB014','switch reseau',40.000,45,'reseau','dlink','img14.jpg',0,'network switch'),
(15,'CB015','tablette ipad',850.000,18,'mobile','apple','img15.jpg',0,'ipad tablet'),
(16,'CB016','webcam hd',35.000,70,'accessoire','logitech','img16.jpg',0,'camera hd'),
(17,'CB017','microphone usb',45.000,55,'audio','blue','img17.jpg',0,'usb mic'),
(18,'CB018','disque externe',120.000,25,'stockage','seagate','img18.jpg',0,'external hdd'),
(19,'CB019','smartwatch',199.990,40,'mobile','xiaomi','img19.jpg',0,'watch'),
(20,'CB020','pc gamer',150.000,8,'informatique','asus','img20.jpg',0,'gaming pc');

/* =========================
   PACK (20 rows) - id_pack = produit id
========================= */
INSERT INTO pack VALUES
(1,'pack pc office'),
(2,'pack accessoires'),
(3,'pack gaming basic'),
(4,'pack multimedia'),
(5,'pack printing'),
(6,'pack mobile apple'),
(7,'pack mobile android'),
(8,'pack charging'),
(9,'pack audio'),
(10,'pack storage'),
(11,'pack storage pro'),
(12,'pack reseau basic'),
(13,'pack reseau pro'),
(14,'pack tablet'),
(15,'pack creator'),
(16,'pack webcam'),
(17,'pack streaming'),
(18,'pack backup'),
(19,'pack wearable'),
(20,'pack gaming ultimate');

/* =========================
   PACK ARTICLE (20 rows)
========================= */
INSERT INTO packArticle VALUES
(1,1,1),(1,2,1),
(2,2,2),(2,8,2),
(3,20,1),(3,9,1),
(4,4,1),(4,9,1),
(5,5,1),(5,10,2),
(6,6,1),(6,8,1),
(7,7,1),(7,8,1),
(8,8,3),
(9,9,2),
(10,10,2),
(11,11,1),(11,18,1),
(12,13,1),(12,14,1),
(13,13,2),(13,14,2),
(14,15,1),(14,16,1),
(15,17,1),(15,9,1),
(16,16,2),
(17,17,2),
(18,18,2),
(19,19,1),
(20,20,1),(20,9,1);

/* =========================
   CLIENT (20 rows)
========================= */
select * from client;
delete from client;
INSERT INTO client VALUES
(1,'Ali','Ben Ali','12345678','ali@gmail.com','pass1','client'),
(2,'Sara','Trabelsi','22345678','sara@gmail.com','pass2','client'),
(3,'Omar','Haddad','32345678','omar@gmail.com','pass3','client'),
(4,'Aymen','Mabrouk','42345678','aymen@gmail.com','pass4','admin'),
(5,'Fatma','Jaziri','52345678','fatma@gmail.com','pass5','client'),
(6,'Khalil','Bouzid','62345678','khalil@gmail.com','pass6','client'),
(7,'Nour','Cherif','72345678','nour@gmail.com','pass7','client'),
(8,'Mehdi','Gharbi','82345678','mehdi@gmail.com','pass8','client'),
(9,'Ines','Saidi','92345678','ines@gmail.com','pass9','client'),
(10,'Youssef','Masmoudi','11111111','youssef@gmail.com','pass10','client'),
(11,'Rania','Kefi','22222222','rania@gmail.com','pass11','client'),
(12,'Hichem','Triki','33333333','hichem@gmail.com','pass12','client'),
(13,'Marwa','Feki','44444444','marwa@gmail.com','pass13','client'),
(14,'Sami','Rezgui','55555555','sami@gmail.com','pass14','client'),
(15,'Asma','Louati','66666666','asma@gmail.com','pass15','client'),
(16,'Bilel','Ayari','77777777','bilel@gmail.com','pass16','client'),
(17,'Wassim','Jebali','88888888','wassim@gmail.com','pass17','client'),
(18,'Hana','Ben Salem','99999999','hana@gmail.com','pass18','client'),
(19,'Zied','Guesmi','10101010','zied@gmail.com','pass19','client'),
(20,'Lina','Miled','12121212','lina@gmail.com','pass20','client');


/* =========================
   COMMANDE (20 rows)
========================= */
INSERT INTO commande VALUES
(1,1,'2026-06-01','attente','Rue A', 'Tunis','1000',1200.500,''),
(2,2,'2026-06-02','confirmée','Rue B', 'Ariana','2000',200.000,''),
(3,3,'2026-06-03','livrée','Rue C', 'Sfax','3000',1500.000,''),
(4,4,'2026-06-04','annulée','Rue D', 'Sousse','4000',0,''),
(5,5,'2026-06-05','attente','Rue E', 'Bizerte','5000',500.000,''),
(6,6,'2026-06-06','confirmée','Rue F', 'Tunis','6000',999.990,''),
(7,7,'2026-06-07','livrée','Rue G', 'Sfax','7000',700.000,''),
(8,8,'2026-06-08','attente','Rue H', 'Ariana','8000',100.000,''),
(9,9,'2026-06-09','confirmée','Rue I', 'Sousse','9000',300.000,''),
(10,10,'2026-06-10','livrée','Rue J', 'Tunis','10000',80.000,''),
(11,11,'2026-06-11','attente','Rue K', 'Sfax','11000',110.000,''),
(12,12,'2026-06-12','confirmée','Rue L', 'Bizerte','12000',90.000,''),
(13,13,'2026-06-13','livrée','Rue M', 'Ariana','13000',55.000,''),
(14,14,'2026-06-14','attente','Rue N', 'Tunis','14000',40.000,''),
(15,15,'2026-06-15','confirmée','Rue O', 'Sousse','15000',850.000,''),
(16,16,'2026-06-16','livrée','Rue P', 'Sfax','16000',35.000,''),
(17,17,'2026-06-17','attente','Rue Q', 'Tunis','17000',45.000,''),
(18,18,'2026-06-18','confirmée','Rue R', 'Ariana','18000',120.000,''),
(19,19,'2026-06-19','livrée','Rue S', 'Sousse','19000',199.990,''),
(20,20,'2026-06-20','attente','Rue T', 'Tunis','20000',1500.000,'');

/* =========================
   LIGNE COMMANDE (20 rows)
========================= */
INSERT INTO ligne_commande VALUES
(1,1,1,1200.500),
(2,2,2,51.980),
(3,4,1,300.000),
(4,5,1,150.000),
(5,6,1,999.990),
(6,7,1,700.000),
(7,8,2,31.000),
(8,9,1,60.000),
(9,10,2,24.000),
(10,11,1,110.000),
(11,12,1,90.000),
(12,13,1,55.000),
(13,14,1,40.000),
(14,15,1,850.000),
(15,16,2,70.000),
(16,17,1,45.000),
(17,18,1,120.000),
(18,19,1,199.990),
(19,20,1,1500.000),
(20,3,1,80.000);

/* =========================
   USER LOGIN (20 rows)
========================= */
INSERT INTO userLogin VALUES
(1,1,'2026-06-01'),
(2,2,'2026-06-02'),
(3,3,'2026-06-03'),
(4,4,'2026-06-04'),
(5,5,'2026-06-05'),
(6,6,'2026-06-06'),
(7,7,'2026-06-07'),
(8,8,'2026-06-08'),
(9,9,'2026-06-09'),
(10,10,'2026-06-10'),
(11,11,'2026-06-11'),
(12,12,'2026-06-12'),
(13,13,'2026-06-13'),
(14,14,'2026-06-14'),
(15,15,'2026-06-15'),
(16,16,'2026-06-16'),
(17,17,'2026-06-17'),
(18,18,'2026-06-18'),
(19,19,'2026-06-19'),
(20,20,'2026-06-20');

select * from produit;
select sum(lc.quantite) as 'nbrePackVendu'
from commande c , ligne_commande lc , pack  p
where year(date_commande)= 2026 and month(date_commande) =6 and c.id_commande=lc.id_commande and p.id_pack=lc.id_produit ;
select * from ligne_commande;


select * from produit;

select * from produit limit 10 offset 3 ;


-- dernier mois commande 

INSERT INTO commande
(id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire)
VALUES
(1, '2026-05-02', 'annulée', '12 Rue Habib Bourguiba', 'Tunis', '1001', 45.500, 'Client a changé d''avis'),
(2, '2026-05-03', 'annulée', '25 Avenue de Paris', 'Sfax', '3000', 78.900, 'Paiement refusé'),
(3, '2026-05-05', 'annulée', '8 Rue de Marseille', 'Sousse', '4000', 120.750, 'Commande annulée par le client'),
(4, '2026-05-06', 'annulée', '15 Rue Ibn Khaldoun', 'Nabeul', '8000', 65.300, 'Produit indisponible'),
(5, '2026-05-07', 'annulée', '33 Rue des Orangers', 'Monastir', '5000', 89.990, 'Erreur de commande'),
(6, '2026-05-09', 'annulée', '7 Avenue Farhat Hached', 'Bizerte', '7000', 34.200, 'Client injoignable'),
(7, '2026-05-10', 'annulée', '18 Rue des Jasmins', 'Gabès', '6000', 210.000, 'Adresse invalide'),
(8, '2026-05-12', 'annulée', '40 Avenue Habib Thameur', 'Ariana', '2080', 56.700, 'Annulation avant expédition'),
(9, '2026-05-14', 'annulée', '22 Rue El Fath', 'Kairouan', '3100', 98.450, 'Paiement annulé'),
(10, '2026-05-15', 'annulée', '9 Rue de la Liberté', 'Mahdia', '5100', 142.000, 'Client a commandé en double'),
(11, '2026-05-17', 'annulée', '55 Rue de Carthage', 'Tunis', '1000', 175.250, 'Produit non disponible'),
(12, '2026-05-19', 'annulée', '4 Rue El Hana', 'Sfax', '3027', 83.600, 'Demande du client'),
(13, '2026-05-20', 'annulée', '29 Avenue de l''Environnement', 'Sousse', '4054', 59.990, 'Problème de paiement'),
(14, '2026-05-22', 'annulée', '13 Rue des Roses', 'Nabeul', '8050', 250.000, 'Erreur de stock'),
(15, '2026-05-24', 'annulée', '61 Avenue de la République', 'Monastir', '5001', 39.500, 'Client ne répond plus'),
(16, '2026-05-26', 'annulée', '17 Rue des Palmiers', 'Gabès', '6031', 112.300, 'Livraison impossible'),
(17, '2026-05-28', 'annulée', '11 Rue El Amal', 'Bizerte', '7011', 67.800, 'Commande annulée après confirmation'),
(18, '2026-05-30', 'annulée', '26 Rue des Oliviers', 'Ariana', '2037', 154.990, 'Client a demandé un remboursement');