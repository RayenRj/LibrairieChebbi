<?php
    include_once(__DIR__ . "/../models/Pack.php");
    include_once(__DIR__ . "/../models/Article.php");
    include_once(__DIR__ . "/../repository/PackRepository.php");

    class PackServices{
        private PackRepository $packRepo;
        public function __construct(){
            $this->packRepo = new PackRepository();
        }

        public function getPackArticles(int $idPack){}
        public function getAllPack(){}
        public function getPackById(int $idPack){}
        public function createPack($data, float $prix){}
        public function deletePack(int $idPack){}
        public function updatePack(int $idPack,array $data){}
        public function modifierUnArtileDuPack(int $idPack , int $idArticle , array $data){}
        public function deleteUnArtileDuPack(int $idPack , int $idArticle){}
        public function ajouterUnArtileToPack(int $idPack , Article $article){}
        public function calculerPrixRelleDuPack(int $idPack): float {}
        public function remiseArticle(int $idPack , float $amountRemise){}
        public function checkPackStock(int $idPack){}
    }

?> 