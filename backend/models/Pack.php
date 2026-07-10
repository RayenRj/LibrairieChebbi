<?php

    // Entity Pack : one pack contains many products 
    
    require_once "Product.php";
    class Pack{
        private int $id_pack;
        private float $prix_totale;
        private array $products = [];
        private string $libelle ;
        private string $type;
        private string $image_url;
        private int $quantite;


        public function __construct(int $id_pack, string $libelle , string $type ,array $produits, float $prix , string $image_url,int $quantite){
            $this->prix_totale = $prix;
            $this->products = $produits;
            $this->id_pack = $id_pack;
            $this->libelle = $libelle;
            $this->type = $type;
            $this->image_url = $image_url;
            $this->quantite = $quantite;
        }

        // getters
        public function getPrixTotale() : float{return $this->prix_totale;}
        public function getPackId() : int{return $this->id_pack;}
        public function getProducts() : array {return $this->products;}
        public function getLibelle() : string {return $this->libelle;}
        public function getType() : string {return $this->type;}
        public function getImageUrl() : string {return $this->image_url;}
        public function getStock() : string {return $this->quantite;}
        // setters
        public function setPrixTotale(float $prix){$this->prix_totale = $prix;}
        public function setPackId(int $packId){$this->id_pack = $packId;}
        public function setProducts(array $products_array){ $this->products = $products_array;}
        public function setlibelle(string $libelle){$this->libelle= $libelle;}
        public function setType(string $type){$this->type = $type;}
        public function setImageUrl(string $img){$this->image_url = $img;}
        public function setStock(int $quantite){$this->quantite = $quantite;}
    }
?>