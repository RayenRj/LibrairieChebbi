<?php
    include_once(__DIR__ . "/Repository.php");
    include_once(__DIR__ . "/../models/Pack.php");
    
    class PackRepository extends Repository{
        public function __construct(){parent::__construct();}


        // nbre totale de pack
        public function NombreTotalePack() : int{
            $stmt = $this->db->prepare("select count(*) from pack ;");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        // pack actif
        public function NombreTotalePackActif() : int{
            $stmt = $this->db->prepare("select count(*) from pack p , produit pr
                                        where p.id_pack = pr.id_produit and pr.quantite_stock > 0;");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        // pack en repture 
        public function packEnRepture(): int {return ($this->NombreTotalePack() - $this->NombreTotalePackActif());}
        // revvenue de pack ce mois
        public function revenuePackCeMois(){
            $query = "select sum(lc.quantite * p.prix) 
                      from ligne_commande lc , produit p , pack pa , commande c
                      where lc.id_produit = pa.id_pack and pa.id_pack = p.id_produit and c.id_commande = lc.id_commande and c.date_commande >= date_format(curdate() , '%Y-%m-01'); ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }
        public function revenuePackDernierMois(){
            $query = "select sum(lc.quantite * p.prix) 
                      from ligne_commande lc , produit p , pack pa , commande c
                      where lc.id_produit = pa.id_pack and pa.id_pack = p.id_produit and c.id_commande = lc.id_commande and c.date_commande >= date_format(curdate() - INTERVAL 1 month, '%Y-%m-01'); ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }

        // recherche + pagination
        public function recherchePack(string $nom, string $niveau , string $statut , int $limit , int $pagination){
            $query =    "select pr.id_produit , pr.libelle , p.type , pr.prix , (select count(*) from packArticle pa where pa.id_pack = p.id_pack) as nbreArticleTotal , pr.quantite_stock , pr.image_url , pr.description
                        from produit pr , pack p 
                        where pr.id_produit = p.id_pack ";
            $statut = mb_strtolower($statut);
            $niveau = mb_strtolower($niveau);
            $allNiveau = ["primaire", "college","secondaire","bac"];
            $param=[];
            if (in_array($niveau, $allNiveau)){
                $query .= " AND p.type = ? ";
                $param[] = $niveau;
            }
            if(!empty($nom)){
                $query .= " AND pr.libelle like ? ";
                $param[] = "%$nom%";
            }
            if(in_array($statut, ["actif", "rupture"])){
                if ($statut == "actif"){
                    $query .= " AND pr.quantite_stock > 0 ";
                }else{
                    $query .= " AND pr.quantite_stock = 0 " ;
                }
            }
            $pagination = max($pagination , 1);
            $limit = max($limit , 1);
            $offset = ($pagination - 1) * $limit;
            $query .= " LIMIT {$limit} OFFSET {$offset} ;";

            $stmt = $this->db->prepare($query);
            $stmt->execute($param);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function nbreRowRecherchePack(string $nom, string $niveau , string $statut , int $limit , int $pagination){
            $query =    "select count(*) from produit pr , pack p  where pr.id_produit = p.id_pack ";
            $statut = mb_strtolower($statut);
            $niveau = mb_strtolower($niveau);
            $allNiveau = ["primaire", "college","secondaire","bac"];
            $param=[];
            if (in_array($niveau, $allNiveau)){
                $query .= " AND p.type = ? ";
                $param[] = $niveau;
            }
            if(!empty($nom)){
                $query .= " AND pr.libelle like ? ";
                $param[] = "%$nom%";
            }
            if(in_array($statut, ["actif", "rupture"])){
                if ($statut == "actif"){
                    $query .= " AND pr.quantite_stock > 0 ";
                }else{
                    $query .= " AND pr.quantite_stock = 0 " ;
                }
            }
            $pagination = max($pagination , 1);
            $limit = max($limit , 1);
            $offset = ($pagination - 1) * $limit;
            $query .= " LIMIT {$limit} OFFSET {$offset} ;";

            $stmt = $this->db->prepare($query);
            $stmt->execute($param);
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }
        // CRUD Functions
        public function findAllPacks(){
            $stmt = $this->db->prepare("select pa.id_pack , pa.type , code_barre , libelle , prix , quantite_stock , categorie , image_url , remise ,  description  from produit p inner join pack pa on pa.id_pack = p.id_produit ;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }
        public function findPackById(int $id){
            $query =  " select p.id_produit , p.code_barre , p.libelle, p.prix , p.quantite_stock , pa.type , image_url , p.remise , p.description 
                        from produit p , pack pa
                        where pa.id_pack = ? and pa.id_pack = p.id_produit";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        }

        public function deletePackById(int $id) : bool{
            $this->db->beginTransaction();
            try{
                // the pack is also a product 
                // delete from packArticle table
                $stmt= $this->db->prepare("delete from packArticle where id_pack = ?");
                $result = $stmt->execute([$id]);
                if(!$result){throw new Exception("Sql Error while deleting the pack");}
                
                // delete from pack table
                $stmt2 = $this->db->prepare("delete from pack where id_pack = ?");
                $result = $stmt2->execute([$id]);
                if(!$result){throw new Exception("Sql Error while deleting the pack");}

                // delete from product table
                $stmt3 = $this->db->prepare("delete from produit where id_produit = ?");
                $result = $stmt3->execute([$id]);
                if(!$result){throw new Exception("Sql Error while deleting the pack");}
                $this->db->commit();
                return true;
            }catch(Exception $e){
                $this->db->rollBack();
                return false;
            }

        }
        
        // ALERT !!!!!!!!! =====> el partie hedhi lezm nrodha transaction : akahw ekher khedma fl pack Repository
        public function modifyPackById(int $id , string $nom , string $niveau, float $prx , int $quantite , array $products) : bool {
            $this->db->beginTransaction();
            try{
                $query1 = " update produit set ";
                $params1=[];
                if(!empty($nom)){
                    $query1 .= "libelle = ? ,";
                    $params1[] = $nom;
                }
                if($prx > 0){
                    $query1 .= " prix = ? ,";
                    $params1[] = $prx;
                }
                if($quantite >= 0){
                    $query1 .= " quantite_stock = ? ,";
                    $params1[] = $quantite;
                } 

                // update le type en niveau
                if(!empty($niveau) && in_array(mb_strtolower($niveau) , ["primaire","college" , "secondaire","bac"])){
                    $query2 = "update pack set type = ? where id_pack = ? ;";
                    $stmt2 = $this->db->prepare($query2);
                    $test = $stmt2->execute([$niveau,$id]);
                    if(!$test){throw new Exception("Sql Error !");}
                }
                // partie table pack article
                // --> part 1 : dellete all articles
                if(!empty($products)){

                    $query3 = "delete from packArticle where id_pack = ? ;";
                    $test = $this->db->prepare($query3)->execute([$id]);
                    if(!$test){throw new Exception("Sql Error !");}
                    // --> part 2 : insert all articles
                    $query4 = "insert into packArticle(id_pack, id_produit, quantite) values";
                    $params4 = [];
                    foreach($products as $product_id => $qte){
                        $query4 .= " (?, ?, ?) ,";
                        $params4[] = $id;
                        $params4[] = $product_id;
                        $params4[] = $qte;
                    }
                    $query4 = rtrim($query4 , ",") . " ;";
        
                    $stmt4 = $this->db->prepare($query4);
                    $test = $stmt4->execute($params4);
                    if(!$test){throw new Exception("Sql Error !");}
                }


                if(empty($params1)){$this->db->commit();return true;}
                $query1 = substr($query1 , 0 , -1);
                $query1 .= " where id_produit = ? ;";
                $params1[]= $id;
                $stmt1 = $this->db->prepare($query1);
                $test =$stmt1->execute($params1);
                if(!$test){throw new Exception("Sql Error !");}
                $this->db->commit();
                return true;
            }catch(Exception $e){
                $this->db->rollBack();
                return false;
            }
            
        }
        /**
         * @param $data => should be sous la forme [idProduct => quantity]
         */
        public function createNewPack($data, float $prix , $niveau ,string $libelle,int $quantite ,string $image_url ,float $remise ,string $description) : bool{
            $this->db->beginTransaction();
            try{
                // first query=> table product
                $query = "insert into produit (libelle, prix, quantite_stock , categorie , image_url,remise,description ) values(?,?,?,?,?,?,?)";
                $stmt = $this->db->prepare($query);
                $result = $stmt->execute([$libelle , $prix,$quantite , "pack" , $image_url ,$remise , $description]);
                if(!$result){throw new Exception("SQL Insertion Error");}
                $packId = $this->db->lastInsertId();


                $query3 = "insert into pack values(?,?)";
                $stmt3 = $this->db->prepare($query3);
                $result=$stmt3->execute([$packId , $niveau]);
                if(!$result){throw new Exception("SQL Insertion Error");}



                $query2 = "insert into packArticle (id_pack ,id_produit , quantite) values ";
                $param=[];
                $str_array=[];
                foreach($data as $index => $product){
                        $str_array[] = "(?,?,?)";
                        $param[] = $packId;
                    foreach($product as $key => $value){
                        $param[] = $value;
                    }
                }
                $query2 .= implode(",",$str_array) ;
                $stmt2 = $this->db->prepare($query2);
                $result = $stmt2->execute($param); // line 236
                if(!$result){throw new Exception("SQL Insertion Error");}
                $this->db->commit();
                return true;
            }catch(Exception $e){
                $this->db->rollBack();
                return $e->getMessage();
            }
        }
        // Get Pack Articles
        public function getPackArticles(int $idPack){
            $query = "select libelle , marque , prix , categorie , quantite , image_url from packArticle pa , produit pr WHERE pa.id_produit = pr.id_produit AND id_pack = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idPack]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        public function getNumberPackArticles(int $idPack){
            $query = "SELECT COUNT(*) from packArticle pa , produit pr WHERE pa.id_produit = pr.id_produit AND id_pack = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idPack]);
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        // supprimé un article du pack
        public function deleteArticleDuPack(int $idPack , int $idArticle) : bool{
            $query = "delete from packArticle where id_pack = ? and id_produit = ? ;";
            $stmt = $this->db->prepare($query);
            return  $stmt->execute([$idPack, $idArticle]);
        
        }
        // ajouter un article du pack
        public function ajouterArticleAuPack(int $idPack , int $idArticle , int $quantite){
            $query = "insert into packArticle values(?,?,?) ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$idPack, $idArticle , $quantite]) ?: null;
        }
        //chercher pack par id
        public function getPackByType(string $type){
            $query = "SELECT id_produit , type , image_url , prix , libelle from produit p , pack pa where id_produit = id_pack and type = ? ;";
            $stmt= $this->db->prepare($query);
            $stmt->execute([$type]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    

?>