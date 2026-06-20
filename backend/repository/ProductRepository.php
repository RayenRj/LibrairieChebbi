<?php 


    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "../models/Product.php");
    class ProductRepository extends Repository{
        private string $tName = "produit";
        public function __construct(){parent::__construct();}


        // venteParMois = ta3tiha el mois wl year w ta3tik el nombre de commandes eli sarou
        public function venteParMois(int $mois , int $year){
            $query = "select count(*) from {$this->tName} where month(date_commande) = ? and year(date_commande) = ? ;";
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
            $query = "select count(*) from product where quantite_stock > 20 ;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function stockMoyen(){
            $query = "select count(*) from product where quantite_stock <= 20 and quantite_stock > 5 ;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function stockFaible(){
            $query = "select count(*) from product where quantite_stock > 1 and quantite_stock <= 5;" ;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // delete
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

        
    
    }
?>