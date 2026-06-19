<?php
    class Product{
        private string $idProduit;
        private string $libelle;
        private int $stock;
        private float $prixUntaire;
        private string $categorie;

        public function __construct(string $idProd , string $lib, int $stock , float $prx , string $cat){
            $this->idProduit = $idProd;
            $this->libelle = $lib;
            $this->stock = $stock;
            $this->prixUntaire = $prx;
            $this->categorie = $cat;
        }

        public function getId(): String{return $this->idProduit;}
        public  function getLibelle(): string{return $this->libelle;}
        public  function getStock():int{return $this->stock;}
        public  function getPrix():float{return $this->prixUntaire;}
        public  function getCategorie():string{return $this->categorie;}
        public  function setId(string $id):void{$this->idProduit = $id;}
        public  function setLibelle(string $lib):void{$this->libelle = $lib;}
        public  function setPrix(float $prx):void{$this->prixUntaire = $prx;}
        public  function setCategorie(string $cat):void{$this->categorie = $cat;}
        public  function set(int $stock):void{$this->stock = $stock;}
    }

?>