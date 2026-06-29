<?php

include_once(__DIR__ . "/../repository/ProductRepository.php");
include_once(__DIR__ . "/../exception/*.php");
include_once(__DIR__ . "/../models/Product.php");
include_once(__DIR__ . "/../exception/IdentifiantInvalideException.php");

class ProductServices{
    private ProductRepository $productRepo;
    public function __construct(){
        $this->productRepo = new ProductRepository();
    }
    
    // done
    public function modifierArticle(int $idProduit,string $codeBarre, string $libelle = "" , float $prix = 0 , string $categorie ="", string $marque="" , float $remise =0 , string $description="" , string $image_url="" ){
        if($idProduit<1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        if($prix < 0){throw new InvalidArgumentException("Le prix doit etre >=0 dt");}
        if($remise < 0){throw new InvalidArgumentException("Le remise doit etre >=0 dt");}
        $this->productRepo->modifierProduit($idProduit,$codeBarre,$libelle, $prix , $categorie , $marque , $remise , $description , $image_url);
    }
    
    //done
    public function rechercherArticle(string $categorie , string $libelle , float $prixMax , float $prixMin=0 , string $stock , string $trie , int $limit = 10 , int $page = 0){
        return $this->productRepo->rechercherArticle($categorie , $libelle, $prixMax,$prixMin , $stock , $trie , $limit,$page);
    }
    //done
    public function createProduct(string $libelle,float $prixUnitaire,int $quantite ,string $categorie,string $marque,float $remise ,string $description,string $image_url ,?string $codeBarre =""): bool{
        if(empty($libelle)){throw new Exception("Libelle de produit ne doit pas etre vide!");}
        if($prixUnitaire<0){throw new Exception("prixUnitaire de produit ne doit pas etre negatif!");}
        if($quantite<0){throw new Exception("quantite de produit ne doit pas etre negatif!");}
        if(empty($categorie)){throw new Exception("categorie de produit ne doit pas etre vide!");}
        if(empty($marque)){throw new Exception("marque de produit ne doit pas etre vide!");}
        if(empty($image_url)){throw new Exception("image_url de produit ne doit pas etre vide!");}
        if($remise < 0 || $remise > $prixUnitaire){throw new Exception("remise de produit invalide!");}
        return $this->productRepo->createNewProduct($libelle, $prixUnitaire, $quantite , $categorie, $marque, $remise , $description, $image_url , $codeBarre);
    }
    //done
    public function getAllProduct() : ?array {
        return $this->productRepo->findAllProducts();
    }
    //done
    public function deleteProduct(int $idProduit):bool{
        if($idProduit<1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        return $this->productRepo->deleteProduct($idProduit);
    }
    //done
    public function checkProductExist(int $idProduit) : bool {
        if($idProduit<1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        return $this->productRepo->findProduitById($idProduit) !== null;
    }
    //done
    public function faireRemise(int $idProduit , float $remiseAmount) : bool{
        if($idProduit<1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        if($remiseAmount<0){throw new Exception("La remise doit etre positif!");}
        $product = $this->productRepo->findProduitById($idProduit);
        if($product["prix"] < $remiseAmount){return false;}
        return $this->productRepo->ajouterUnRemiseSurProduit($idProduit, $remiseAmount);
    }
    //done
    public function getProductById(int $id) : array{
        if($id <1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        return $this->productRepo->findProduitById($id);
    }
    //done
    public function increaseStock(int $idProduit , int $quantite) : bool {
        if($idProduit<1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        if($quantite<0){throw new QuantityException("Quantity doit etre > 0");}
        return $this->productRepo->increaseQuantity($idProduit,$quantite);
    }
    //done
    public function decreaseStock(int $idProduit , int $quantite) : bool {
        if($idProduit<1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        if($quantite<0){throw new QuantityException("Quantity doit etre > 0");}
        $product = $this->productRepo->findProduitById($idProduit);
        if($product["quantite_stock"] < $quantite){throw new Exception("La quantite est superieur a la quantite en stock");}
        return $this->productRepo->decreaseQuantity($idProduit,$quantite);
    }
    //done
    public function getFinalPrice(int $idProduit) : float {
        if($idProduit<1){throw new IdentifiantInvalideException("l'id doit etre positif");}
        $product = $this->productRepo->findProduitById($idProduit);
        if($product == null){throw new Exception("Article not found!");}
        return ($product["prix"] - $product["remise"]) ;
    }
}






?> 