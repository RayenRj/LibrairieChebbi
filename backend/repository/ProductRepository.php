<?php 
    // Product Repository : feha tous les methodes utilisée fl dashboard admin

    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "/../models/Product.php");
    class ProductRepository extends Repository{
        private string $tName = "produit";
        public function __construct(){parent::__construct();}


        // venteParMois = ta3tiha el mois wl year w ta3tik el nombre de commandes eli sarou
        public function venteParMois(int $mois , int $year){
            $query = "select count(*)
                      from ligne_commande lc , commande c,
                      where month(date_commande) = ? and year(date_commande) = ? and lc.id_commande = c.id_commande;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$mois,$year]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // el utilisation ba3d fl chart anni kol marra bch nesta3ml feha chhar different

        public function nbreArticleEnRepture(){
            $query = "select count(*) from {$this->tName} where quantite_stock = 0";
            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function nbreArticleNonVendus(){
            $query = "select count(*) from produit p where not exist(select * from ligne_commande lc where p.id_produit = lc.id_produit );";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // partie stock 
        public function stockElevee(){
            $query = "select count(*) from {$this->tName} where quantite_stock > 20 ;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function stockMoyen(){
            $query = "select count(*) from {$this->tName} where quantite_stock <= 20 and quantite_stock > 5 ;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function stockFaible(){
            $query = "select count(*) from {$this->tName} where quantite_stock > 1 and quantite_stock <= 5;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $query = "select count(*) from ligne_commande lc, commande c , produit p
                      where lc.id_commande = c.id_commande and p.id_produit = lc.id_produit and month(date_commande)= month(curdate()) and year(date_commande) = year(curdate()) 
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
                      where p.id_produit = lc.id_produit and c.id_commande = lc.id_commande and month(date_commande) = month(curdate()) and year(date_commande) = year(curdate())
                      group by id_produit ? P.libelle , p.categorie
                      order by quantite_total DESC
                      limit 10";

            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function ArticleAfaibleRotation(){
            $query = "select p.libelle , p.categorie , sum(lc.quantite) as 'quantite_total'
                      from produit p , commande c , ligne_commande lc
                      where p.id_produit = lc.id_produit and c.id_commande = lc.id_commande and month(date_commande) = month(curdate()) and year(date_commande) = year(curdate())
                      group by p.id_produit , P.libelle , p.categorie
                      order by quantite_total ASC
                      having quantite_total < 6;";
            $stmt= $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // #######################
        // partie recherche : contient paginaation
        // #######################
        public function rechercherArticle(string $categorie , string $libelle , float $prixMax , float $prixMin , string $stock , string $trie , int $limit = 10 , int $page = 0){
            $query = "SELECT p.id_produit , p.code_barre , p.libelle , (p.prix - p.remise) as prix_unitaire, p.quantite_stock , p.categorie , p.marque , p.image_url , p.remise , p.description , COALESCE(sum(lc.quantite),0) as nombreVente from {$this->tName} p LEFT JOIN ligne_commande lc on lc.id_produit = p.id_produit where 1=1 ";
            $categorie = mb_strtolower(trim($categorie));
            $stock = mb_strtolower(trim($stock));
            $trie = mb_strtolower(trim($trie));
            $param = [];
            $trie_list=["id article" => "p.id_produit", 
                        "libellé" => "p.libelle" ,
                        "prix unitaire" => "prix_unitaire" , 
                        "stock" => "p.quantite_stock" , 
                        "nombre de vente" => "nombreVente"];
            if ($categorie !== "tous"){
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

            $page = max($page , 1);
            $limit = max($page , 1);
            $param[] = $limit;
            $param[] = ($page -1 ) * $limit;
            
            $query .= " GROUP BY p.id_produit ";
            $query .= " ORDER BY {$trie} ";
            $query .= " LIMIT ? OFFSET ? ;";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($param);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        
    }
?>