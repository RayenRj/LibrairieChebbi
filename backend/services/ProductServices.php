<?php

include_once(__DIR__ . "/../repository/ProductRepository.php");
include_once(__DIR__ . "/../models/Product.php");
include_once(__DIR__ . "/../exception/IdentifiantInvalideException.php");

class ProductServices{
    private ProductRepository $productRepo;
    public function __construct(){
        $this->productRepo = new ProductRepository();
    }

    public function createProduct($data){}
    public function getAllProduct() : array {}
    public function deleteProduct(int $idProduit){}
    public function checkProductExist(int $idProduit) : bool {}
    public function faireRemise(int $idProduit , float $remiseAmount){}
    public function getProductById(int $id){}
    public function updateProduct(int $idProduit , array $data) : bool {}
    public function increaseStock(int $idProduit , int $quantite) : bool {}
    public function getFinalPrice(int $idProduit){}
}





?> 