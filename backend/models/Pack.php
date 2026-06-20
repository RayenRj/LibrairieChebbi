<?php

    // Entity Pack : one pack contains many products 
    
    require_once "Product.php";
    class Pack{
        private int $id_pack;
        private float $prix_totale;
        private array $products = [];
        public function __construct(int $id_pack,array $produits, float $prix){
            $this->prix_totale = $prix;
            $this->products = $produits;
            $this->id_pack = $id_pack;
        }

        public function addProduct(Product $produit) : void {
            $this->products[] = $produit;
            $this->prix_totale += $produit->getPrix();
        }
        
        public function deleteProduct(string $id) : void{
            foreach($this->products as $key => $product){
                if($product.getId() == $id){
                    unset($this->products ,$key);
                    // unset tekhoulk 2 param : el array wl key mta3 el item eli t7eb tna7ih khater f kol array el key unique
                }
            }
        }

        public function getPrixTotale() : float{return $this->prix_totale;}
        public function getPackId() : int{return $this->id_pack;}
        public function getProducts() : array {return $this->products;}
    }
?>