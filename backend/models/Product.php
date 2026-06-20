<?php

    // product entity completed : contains all information about one product
    class Product{
        private int $idProduit;
        private string $code_a_barre;
        private string $libelle;
        private int $stock;
        private float $prixUntaire;
        private string $categorie;
        private string $marque;
        private string $imageUrl;
        private float $remise;

        public function __construct(string $idProd , string $lib, int $stock , float $prx , string $cat , string $code, string $img  , float $remise , string $marque){
            $this->idProduit = $idProd;
            $this->libelle = $lib;
            $this->stock = $stock;
            $this->prixUntaire = $prx;
            $this->categorie = $cat;
            $this->marque = $marque;
            $this->remise = $remise;
            $this->code_a_barre = $code;
            $this->imageUrl = $img;
        }

        // getter
        public function getId(): String{return $this->idProduit;}
        public  function getLibelle(): string{return $this->libelle;}
        public  function getStock():int{return $this->stock;}
        public  function getPrix():float{return $this->prixUntaire;}
        public  function getCategorie():string{return $this->categorie;}
        public  function getCodeABarre():string{return $this->code_a_barre;}
        public  function getMarque():string{return $this->marque;}
        public  function getImageUrl():string{return $this->imageUrl;}
        public  function getRemise():float{return $this->remise;}
        //setter
        public  function setId(string $id):void{$this->idProduit = $id;}
        public  function setLibelle(string $lib):void{$this->libelle = $lib;}
        public  function setPrix(float $prx):void{$this->prixUntaire = $prx;}
        public  function setCategorie(string $cat):void{$this->categorie = $cat;}
        public  function setStock(int $stock):void{$this->stock = $stock;}
        public  function setRemise(float $remise):void{$this->remise= $remise;}
        public  function setImageUrl(string $img):void{$this->imageUrl = $img;}
        public  function setMarque(string $marque):void{$this->marque = $marque;}
        public  function setCodeABarre(string $code):void{$this->code_a_barre = $code;}
    }

?>