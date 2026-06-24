<?php 
    // Product Repository : feha tous les methodes utilisée fl dashboard admin

    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "../models/Product.php");
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
        public function deleteProduct(int $id_prod){
            $query = "delete from {$this->tName} where id_produit = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_prod]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ListeDesProduits(){
            $stmt = $this->db->prepare("select * from {$this->tName} ;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function findProduitById(int $id){
            $query = "select * from {$this->tName} where id_produit = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        public function rechercherArticle(string $categorie , string $libelle , float $prixMax , float $prixMin=0 , string $stock , string $trie , int $limit = 10 , int $page = 0){
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
        public function decreaseQuantity(Product $product , int $quantityToDelete) : bool {
            $query = "update produit set quantite_stock = quantite_stock - ? where id_produit = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$quantityToDelete , $product]);
        } 

    }
?>