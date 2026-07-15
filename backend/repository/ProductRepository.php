<?php 
    // Product Repository : feha tous les methodes utilisée fl dashboard admin

    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "/../models/Product.php");
    class ProductRepository extends Repository{
        private string $tName = "produit";
        public function __construct(){parent::__construct();}


        // venteParMois = ta3tiha el mois wl year w ta3tik el nombre de commandes eli sarou
        public function venteParMois(int $mois , int $year){
            $query = "SELECT count(*)
                      from ligne_commande lc , commande c
                      where lc.id_commande = c.id_commande and month(date_commande) = ? and year(date_commande) = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$mois,$year]);
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }
        // el utilisation ba3d fl chart anni kol marra bch nesta3ml feha chhar different

        public function nbreArticleEnRepture(){
            $query = "select count(*) from {$this->tName} where quantite_stock = 0";
            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        public function nbreArticleNonVendus(){
            $query = "SELECT count(*) from produit p where NOT EXISTS(select * from ligne_commande lc where p.id_produit = lc.id_produit );";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        
        // partie stock 
        public function stockElevee(){
            $query = "select count(*) from {$this->tName} where quantite_stock > 20 ;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        public function stockMoyen(){
            $query = "select count(*) from {$this->tName} where quantite_stock <= 20 and quantite_stock > 5 ;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        public function stockFaible(){
            $query = "select count(*) from {$this->tName} where quantite_stock > 1 and quantite_stock <= 5;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }

        // CRUD functions
        public function deleteProduct(int $id_prod) : bool{
            $query = "delete from {$this->tName} where id_produit = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id_prod]);
        }

        public function findAllProducts(int $limit,int $offset){
            $stmt = $this->db->prepare("select * from {$this->tName} limit $limit offset $offset ;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function findProduitById(int $id){
            $query = "select * from {$this->tName} where id_produit = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        }

        public function ajouterProduit(Product $produit){
            $query = 
            "insert into {$this->tName}(id_produit, code_barre,nom,prix,quantite_stock,categorie,marque,image_url,remise,description) 
            values(?,?,?,?,?,?,?,?,?,?);";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$produit->getCodeABarre(), $produit->getLibelle(), $produit->getPrix(),$produit->getStock(),$produit->getCategorie(),$produit->getMarque() , $produit->getImageUrl(), $produit->getRemise() , $produit->getDescription()]);    
        }
        public function getProductById(string $id){
            $query = "select * from produit where id_produit = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function createNewProduct($libelle, $prixUnitaire, $quantite , $categorie, $marque, $remise , $description, $image_url , $codeBarre){
            $query = "INSERT INTO produit (libelle , prix,quantite_stock,categorie, marque , remise, description, image_url , code_barre ) values (?,?,?,?,?,?,?,?,?) ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$libelle , $prixUnitaire, $quantite , $categorie, $marque, $remise , $description, $image_url , $codeBarre]);
        }
        // end of CRUD function

        public function nbreDeVentePourChaqueCategorieCeMois(){
            $query = "select categorie , count(*) as `nombreVente` from ligne_commande lc, commande c , produit p
                        where lc.id_commande = c.id_commande and p.id_produit = lc.id_produit
                        group by categorie;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function nbreDeVenteToutalCeMois(){
            $query = "select count(*) from ligne_commande lc, commande c , produit p
                      where lc.id_commande = c.id_commande and p.id_produit = lc.id_produit and month(date_commande)= month(curdate()) and year(date_commande) = year(curdate()) ;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_BOTH)[0];
        }

        // partie eli feha 2 tables
        public function Top10Ventes(){
            $query = "select p.libelle , p.categorie , sum(lc.quantite) as 'quantite_total'
                      from produit p , commande c , ligne_commande lc
                      where p.id_produit = lc.id_produit and c.id_commande = lc.id_commande
                      group by p.id_produit , P.libelle , p.categorie
                      order by quantite_total DESC
                      limit 10";

            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function ArticleAfaibleRotation(){
            $query = "select p.libelle , p.categorie , sum(lc.quantite) as 'venteTotale' , p.quantite_stock
                      from produit p , commande c , ligne_commande lc
                      where p.id_produit = lc.id_produit and c.id_commande = lc.id_commande 
                      group by p.id_produit , p.libelle , p.categorie
                      having venteTotale < 6
                      order by venteTotale ASC ;";
            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // #######################
        // partie recherche : contient paginaation
        // #######################
        public function rechercherArticle(string $categorie , string $libelle , float $prixMax , float $prixMin , string $stock , string $trie , int $limit , int $page ){
            $query = "SELECT p.id_produit , p.code_barre , p.libelle , (p.prix - p.remise) as prix_unitaire, p.quantite_stock , p.categorie , p.marque , p.image_url , p.remise , p.prix , p.description from {$this->tName} p  where 1=1 and id_produit not in (select distinct(id_pack) from pack) ";
            $param = [];
            $categorie = mb_strtolower(trim($categorie));
            $stock = mb_strtolower(trim($stock));
            $trie = mb_strtolower(trim($trie));
            $trie_list=["id article" => "p.id_produit", "libellé" => "p.libelle" ,"prix unitaire" => "prix_unitaire" , "stock" => "p.quantite_stock" , "nombre de vente" => "nombreVente"];
            if ($categorie !== ""){
                $query .= "AND categorie = ? ";
                $param[] = $categorie;
            }
            if(!empty($libelle)){
                $query .= "AND libelle LIKE ? ";
                $param[] = "%$libelle%";
            }


            if ($prixMax > 0 && $prixMin >0){
                $min =  min($prixMax , $prixMin);
                $max = max($prixMax , $prixMin);
                $query .= "AND (p.prix - p.remise) between ? and ? ";
                $param[] = $min;
                $param[] = $max;
            }else{
                if($prixMin > 0){
                    $query .= "AND (p.prix - p.remise) >= ? ";
                    $param[] = $prixMin;
                }
                if($prixMax > 0){
                    $query .= "AND (p.prix - p.remise) <= ? ";
                    $param[] = $prixMax;
                }
            }
            // stock 
            if($stock == "stock eleve"){$query .= "AND p.quantite_stock >= 20 " ;}
            else if($stock == "stock moyen"){$query .= "AND p.quantite_stock between 6 and 19 ";}
            else if($stock == "stock faible"){$query .= "AND p.quantite_stock between 1 and 5 ";}
            else if($stock == "repture de stock"){$query .= "AND p.quantite_stock = 0 ";}
            
            $trie= $trie_list[$trie] ?? "prix_unitaire";

            $offset = ($page - 1) * $limit;

            $query .= " GROUP BY p.id_produit ";
            $query .= " ORDER BY {$trie} DESC";
            $query .= " LIMIT $limit OFFSET $offset ;";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($param);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // retourne le nombre totale de ligne de la recherche d'article
        public function nombreLigneRechercherArticle(string $categorie , string $libelle , float $prixMax , float $prixMin , string $stock , string $trie , int $limit , int $page ){
            $query = "SELECT count(*) from produit p  where ";
            $param = [];
            $queryList = [" p.id_produit not in (select distinct(id_pack) from pack) "];
            $categorie = mb_strtolower(trim($categorie));
            $stock = mb_strtolower(trim($stock));
            $trie = mb_strtolower(trim($trie));
            if ($categorie !== ""){
                $queryList[] = "categorie = ?";
                $param[] = $categorie;
            }
            if(!empty($libelle)){
                $queryList[] = "libelle LIKE ?";
                $param[] = "%$libelle%";
            }


            if ($prixMax > 0 && $prixMin >0){
                $min =  min($prixMax , $prixMin);
                $max = max($prixMax , $prixMin);
                $queryList[] = "(p.prix - p.remise) between ? and ?";
                $param[] = $min;
                $param[] = $max;
            }else{
                if($prixMin > 0){
                    $queryList[] = "(p.prix - p.remise) >= ?";
                    $param[] = $prixMin;
                }
                if($prixMax > 0){
                    $queryList[] ="(p.prix - p.remise) <= ?";
                    $param[] = $prixMax;
                }
            }
            // stock 
            if($stock == "stock eleve"){$queryList[] ="p.quantite_stock >= 20" ;}
            else if($stock == "stock moyen"){$queryList[] ="p.quantite_stock between 6 and 19";}
            else if($stock == "stock faible"){$queryList[] ="p.quantite_stock between 1 and 5";}
            else if($stock == "repture de stock"){$queryList[] = "p.quantite_stock = 0";}
            
           
            if(sizeof($queryList)<= 1){
                $query = "select count(*) from produit where id_produit not in (select distinct(id_pack) from pack);";
                $param=[];
            }else{
                $query .= implode(" AND " , $queryList);
            }
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($param);
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?? 0;
        }

        /**
         * @param data => c'est le donnée qu'on va tester avec.
         * @param critere => ["libelle","categorie", "marque" , "prix"]
         */
        public function rechercherArticle2(string $data , string $critere , int $limit , int $offset){
            if(empty(trim(mb_strtolower($data))) || empty(trim(mb_strtolower($critere)))){
                $query = "select * from produit limit $limit offset $offset ;";
                $stmt = $this->db->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                if(empty(trim(mb_strtolower($critere))) == "prix"){
                    $query = "select * from produit where prix < ? limit $limit offset $offset ;";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([floatval($data)]);
                }else{
                    $query = "select * from produit where ? like ? limit $limit offset $offset ;";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$critere , "%$data%"]);
                }
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        // modifer la quantite d'un articles
        public function decreaseQuantity(int $product , int $quantityToDelete) : bool {
            $query = "update produit set quantite_stock = quantite_stock - ? where id_produit = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$quantityToDelete , $product]);
        } 
        // modifer la quantite d'un articles
        public function increaseQuantity(int $product , int $quantityToDelete) : bool {
            $query = "update produit set quantite_stock = quantite_stock + ? where id_produit = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$quantityToDelete , $product]);
        } 

        public function getAllCategorie(){
            $query = "SELECT DISTINCT(categorie) from produit";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM);
        }
        public function getAllMarque(){
            $query = "SELECT DISTINCT(marque) from produit";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM);
        }

        //ajouter un remise 
        public function ajouterUnRemiseSurProduit(int $idProduit , float $amountRemise) :bool{
            $stmt = $this->db->prepare("update produit set remise = ? where id_produit = ? ;");
            return $stmt->execute([$amountRemise,$idProduit]);
        }


        // modifier produit
        public function modifierProduit(int $idProduit,string $codeBarre, string $libelle = "" , float $prix = 0 , string $categorie ="", string $marque="" , float $remise = 0 , string $description ="" , string $image_url=""):bool{
            $codeBarre = trim(strtolower($codeBarre));
            $libelle = trim(strtolower($libelle));
            $categorie = trim(strtolower($categorie));
            $description = trim(strtolower($description));
            $marque = trim(strtolower($marque));
            $image_url = trim(strtolower($image_url));
            $query = "update produit SET ";
            $queryList =[];
            $params = [];
            if(!empty($libelle)){
                $queryList[] = " libelle = ? ";
                $params[] = $libelle;
            }
            if(!empty($codeBarre)){
                $queryList[] = " code_barre = ? ";
                $params[] = $codeBarre;
            }
            if(!empty($categorie)){
                $queryList[] = " categorie = ? ";
                $params[] = $categorie;
            }
            if(!empty($marque)){
                $queryList[] = " marque = ? ";
                $params[] = $marque;
            }
            
            if(!empty($description)){
                $queryList[] = " description = ? ";
                $params[] = $description;
            }
            if(!empty($image_url)){
                $queryList[] = " image_url = ? ";
                $params[] = $image_url;
            }
            if($prix > 0){
                $queryList[] = " prix = ? ";
                $params[] = $prix;
            }
            if($remise > 0){
                $queryList[] = " remise = ? ";
                $params[] = $remise;
            }
            if(empty($queryList)){return true;}
            $query .= implode(", ",$queryList);
            $query .= " WHERE id_produit = ? ";
            $params[] = $idProduit;
            $stmt = $this->db->prepare($query);
            return  $stmt->execute($params);
        }
        



        public function nbreDeventeParJour(int $jour){
            $query = "select count(*) from commande where date_commande between date_format(curdate() - INTERVAL $jour day,'%Y-%m-%d 00:00:00') and date_format(curdate() - INTERVAL $jour day ,'%Y-%m-%d 23:59:59') ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }


       public function nombreDeVentePourChaquePack(){
            $stmt = $this->db->prepare("select `type` , sum(quantite) as `nombreVente`
                                        from pack p , ligne_commande lc
                                        where id_pack = id_produit
                                        group by p.`type`;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? null;
       }



       public function searchBar(string $data){
        $query = "";
       }
    }
?>