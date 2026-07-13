<?php 
    // StatisticsRepository : have all methods to use in the first dashboard page

    require_once __DIR__ . "/Repository.php";
    class StatisticsRepository extends Repository{
        public function __construct(){parent::__construct();}

        //##########################
        // remplissage des 4 caards 
        //##########################

        // Total commande selon mois
        public function TotaleCommande(int $mois, int $year){
            $query = "select count(*) from commande where year(date_commande)= ? and month(date_commande) = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$year,$mois]);
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }
        // Chiffre affaire selon mois
        public function ChiffreAffaire(int $mois, int $year){
            $query = "select sum(prix_totale) from commande where year(date_commande)= ? and month(date_commande) = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$year,$mois]);
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }
        // Pack Vendu selon mois
        public function PackVendu(int $mois, int $year){
            $query = "select sum(lc.quantite) as 'nbrePackVendu'
                      from commande c , ligne_commande lc , pack  p
                      where year(date_commande)= ? and month(date_commande) = ? and c.id_commande=lc.id_commande and p.id_pack=lc.id_produit ";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$year,$mois]);
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }
        // nbre of user selon mois
        public function NbreOfUser(){
            $query = "select count(*) from userLogin where loginAt >= date_format(curdate() , '%Y-%m-01') ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_BOTH)[0] ?? 0;
        }
        public function NbreOfUserLastMonth(){
            $query = "select count(*) from userLogin where loginAt >= date_format(curdate() - INTERVAL 1 month , '%Y-%m-01') and loginAt < date_format(curdate(), '%Y-%m-01')";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_BOTH)[0];
        }
        // commandeRecente : intervale 2 day
        public function CommandeRecente($limit){
            $query = "select c.* , nom , prenom from commande c , client cli where c.id_client = cli.id_client order by date_commande DESC limit $limit ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // top artcle vendu 
        public function topArticlesVendues($limit){
            $query = "select p.* , sum(quantite) as quantite_total 
                      from produit p , ligne_commande lc 
                      where p.id_produit = lc.id_produit and categorie <> 'pack' 
                      group by p.id_produit 
                      order by quantite_total DESC
                      limit $limit;"; // limit x offset y : x howa 9adeh ykharejlk max mn ligne , y howa 9addeh y ignori ml lowel
        
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // articles en repture de stock
        public function ArticleEnReptureStock($limit){
            $query = "select * from produit where quantite_stock =0 limit $limit ";
            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function nbreArticleEnReptureStock(){
            $query = "select count(*) from produit where quantite_stock = 0 ";
            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }
        // totale vente des packs
        public function totaleVenteDePack(){
            $query = "select sum(quantite) as 'totaleVenteDePack'
                      from ligne_commande lc , pack p
                      where lc.id_produit=p.id_pack" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        // vente de chaque packs
        public function totaleVenteDeChaquePack(){
            $totale = $this->totaleVenteDePack();
            $query = "select id_pack , type , (sum(quantite) * 100) / ? as 'pourcentageVente'
                      from ligne_commande lc , pack p
                      where lc.id_produit = p.id_pack 
                      group by p.id_pack";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$totale]);
            return $stmt->fetchAll(PDO::FETCH_BOTH);
        }


        public function nbreDeventeParJour(int $jour){
            $query = 'select count(*) from commande where date_commande between date_format(curdate() - INTERVAL $jour day,"%Y-%m-%d 00:00:00") and date_format(curdate() - INTERVAL 11 $jour,"%Y-%m-%d 23:59:59") ;';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$jour, $jour]);
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
    }





?>