create database if not exists librairieDBBeta;
use librairieDBBeta;
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
	if(select quantite_stock from produit where id_produit= new.id_produit) >= new.quantite then
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