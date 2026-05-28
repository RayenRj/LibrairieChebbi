create database if not exists librairieDB;
use librairieDB;
create table produit(
	id_produit int primary key auto_increment,
    code_barre varchar(50) ,
    nom varchar(50),
    prix decimal(6,3) not null check(prix>0),
    quantite_stock int not null check(quantite_stock >= 0),
    categorie varchar(50) not null,
    marque varchar(50),
    image_url varchar(255),
    remise decimal(6,3) default 0,
    description varchar(255) default ''
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
	statut varchar(50) check(statut in('attente','confirmée','annulée')),
    adresse varchar(255) not null,
    ville varchar(100),
    code_postal varchar(20),
    prix_totale decimal(6,3),
    commentaire varchar(255),
    foreign key(id_client) references client(id_client)
);


create table ligne_commande(
    id_commande int references commande(id_commande),
    id_produit int references produit(id_produit) , 
    quantite int not null,
    sous_total decimal(6,3),
    primary key(id_commande,id_produit),
    foreign key(id_commande) references commande(id_commande) on delete cascade on update cascade,
    foreign key(id_produit) references produit(id_produit) on delete cascade on update cascade
    
);




-- insertion de donnée

INSERT INTO produit (code_barre, nom, prix, quantite_stock, categorie, marque, image_url, remise, description)
VALUES
('P001','Stylo Bleu',1.500,100,'Stylo','Bic','',0,'Stylo bleu classique'),
('P002','Stylo Rouge',1.500,80,'Stylo','Bic','',0,'Stylo rouge'),
('P003','Cahier 100p',3.200,60,'Cahier','Clairefontaine','',0.5,'Cahier grand format'),
('P004','Cahier 200p',5.500,40,'Cahier','Oxford','',1,'Cahier épais'),
('P005','Sac scolaire',25.990,20,'Sac','Nike','',2,'Sac école'),
('P006','Règle 30cm',0.800,200,'Accessoire','Maped','',0,'Règle plastique'),
('P007','Calculatrice',18.500,30,'Electronique','Casio','',1,'Scientifique'),
('P008','Gomme',0.500,300,'Accessoire','Maped','',0,'Gomme blanche'),
('P009','Crayon HB',0.700,250,'Stylo','Staedtler','',0,'Crayon bois'),
('P010','Classeur',4.000,70,'Organisation','Esselte','',0,'Classeur A4');


INSERT INTO client (nom, prenom, tel, email, password, role)
VALUES
('Ben Ali','Ahmed','20111111','ahmed1@gmail.com','pass','client'),
('Trabelsi','Sara','20222222','sara@gmail.com','pass','client'),
('Masmoudi','Omar','20333333','omar@gmail.com','pass','client'),
('Jlassi','Aymen','20444444','aymen@gmail.com','pass','client'),
('Haddad','Ines','20555555','ines@gmail.com','pass','client'),
('Gharbi','Khalil','20666666','khalil@gmail.com','pass','client'),
('Saidi','Youssef','20777777','youssef@gmail.com','pass','client'),
('Ferchichi','Rania','20888888','rania@gmail.com','pass','client'),
('Bouazizi','Ali','20999999','ali@gmail.com','pass','client'),
('Admin','System','20000000','admin@gmail.com','pass','admin');



INSERT INTO commande (id_client, date_commande, statut, adresse, ville, code_postal, prix_totale, commentaire)
VALUES
(1,'2026-05-01','attente','Rue 1','Hammamet','8050',10.500,'urgent'),
(2,'2026-05-02','confirmée','Rue 2','Nabeul','8000',15.000,''),
(3,'2026-05-03','annulée','Rue 3','Sousse','4000',8.000,'cancel'),
(4,'2026-05-04','attente','Rue 4','Tunis','1000',20.000,''),
(5,'2026-05-05','confirmée','Rue 5','Sfax','3000',12.500,''),
(6,'2026-05-06','attente','Rue 6','Hammamet','8050',9.000,''),
(7,'2026-05-07','confirmée','Rue 7','Nabeul','8000',25.000,''),
(8,'2026-05-08','attente','Rue 8','Sousse','4000',30.000,''),
(9,'2026-05-09','confirmée','Rue 9','Tunis','1000',18.000,''),
(10,'2026-05-10','attente','Rue 10','Sfax','3000',22.000,'');


INSERT INTO ligne_commande (id_commande, id_produit, quantite, sous_total)
VALUES
(1,1,2,3.000),
(1,3,1,3.200),
(2,2,3,4.500),
(2,7,1,18.500),
(3,6,5,4.000),
(4,5,1,25.990),
(5,4,2,11.000),
(6,8,10,5.000),
(7,9,4,2.800),
(8,10,2,8.000);


-- triggers
DELIMITER $$
create trigger after_ligne_commande_insert
after insert on ligne_commande
for each row 
begin 
	-- tna9eslk el quantité ta3 el produit fl stock
	if(select quantite_stock from produit where id_produit= new.id_produit > new.quantite) then
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



