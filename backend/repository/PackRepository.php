<?php
    include_once(__DIR__ . "/Repository.php");
    include_once(__DIR__ . "/../models/Pack.php");
    
    class PackRepository extends Repository{
        public function __construct(){parent::__construct();}


        // nbre totale de pack
        public function NombreTotalePack() : int{
            $stmt = $this->db->prepare("select count(*) from pack ;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM)[0];
        }
        // pack actif
        public function NombreTotalePackActif() : int{
            $stmt = $this->db->prepare("select count(*) from pack p , produit pr
                                        where p.id_pack = pr.id_produit and pr.quantite_stock > 0;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM)[0];
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
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }

        // recherche + pagination
        public function recherchePack(string $nom, string $niveau , string $statut , int $limit , int $pagination){
            $query =    "select pr.id_produit , pr.libelle , p.type , pr.prix , (select count(*) from packArticle pa where pa.id_pack = p.id_pack) as nbreArticleTotal , pr.quantite_stock 
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
            if(in_array($statut, ["actif", "en rupture"])){
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
        // CRUD Functions 
        public function findPackById(int $id){
            $query =  " select p.id_produit , p.code_barre , p.libelle, p.prix , p.quantite_stock , p.categorie , p.marque , image_url , p.remise , p.description 
                        from produit p , pack pa
                        where pa.id_pack = ? and pa.id_pack = p.id_produit";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function deletePackById(int $id) : bool{
            $stmt = $this->db->prepare("delete from produit where p.id_produit = ? ;");
            return $stmt->execute([$id]);
        }
        // ALERT !!!!!!!!! =====> el partie hedhi lezm nrodha transaction : akahw ekher khedma fl pack Repository
        public function modifyPackById(int $id , string $nom , string $niveau, float $prx , int $quantite , array $products) : bool {
            $query1 = " update produit set ";
            $params1=[];
            $success = true;
            if(!empty($nom)){
                $query1 .= "libelle = ? ,";
                $params1[] = $nom;
            }
            if($prx > 0){
                $query1 .= " prix = ? ,";
                $params1[] = $prx;
            }
            if($quantite >= 0){
                $query1 .= " quantite_stock = ? , ";
                $params1[] = $quantite;
            } 



            // update le type en niveau
            if(!empty($niveau) && in_array(mb_strtolower($niveau) , ["primaire","college" , "secondaire","bac"])){
                $query2 = "update pack set type = ? where id_pack = ? ;";
                $stmt = $this->db->prepare($query2);
                $test = $stmt->execute([$niveau,$id]);
                $success = $success && $test;
            }
            // partie table pack article
            // --> part 1 : dellete all articles
            if(!empty($products)){

                $query = "delete from packArticle where id_pack = ? ;";
                $test = $this->db->prepare($query)->execute([$id]);
                $success = $success && $test;
                // --> part 2 : insert all arcticles
                $query = "insert into packArticle(id_pack, id_produit, quantite) values";
                $params = [];
                foreach($products as $product_id => $qte){
                    $query .= " (?, ?, ?) ,";
                    $params[] = $id;
                    $params[] = $product_id;
                    $params[] = $qte;
                }
                $query = rtrim($query , ",") . " ;";
    
                $stmt = $this->db->prepare($query);
                $test = $stmt->execute($params);
                $success = $success && $test;
            }
            if(empty($params1)){return $success;}
            $query1 = substr($query1 , 0 , -2);
            $query1 .= " where id_produit = ? ;";
            $params1[]= $id;
            $stmt = $this->db->prepare($query1);
            return $stmt->execute($params1) && $success;
        }
    }
    

?>