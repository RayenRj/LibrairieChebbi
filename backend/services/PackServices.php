<?php
    include_once(__DIR__ . "/../models/Pack.php");
    include_once(__DIR__ . "/../models/Article.php");
    include_once(__DIR__ . "/../repository/PackRepository.php");
    include_once(__DIR__ . "/../repository/ProductRepository.php");
    include_once(__DIR__ . "/../exception/*.php");
    class PackServices{
        private PackRepository $packRepo;
        private ProductRepository $productRepo;
        public function __construct(){
            $this->packRepo = new PackRepository();
            $this->productRepo = new ProductRepository();
        }

        //done
        public function getPackArticles(int $idPack){
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            $pack = $this->packRepo->findPackById($idPack);
            if($pack== null){throw new Exception("Cette pack n'existe pas!");}
            return $this->packRepo->getPackArticles($idPack);
        }

        //done
        public function getAllPack(){
            return $this->packRepo->findAllPacks();
        }

        public function getPackById(int $idPack){
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            return $this->packRepo->findPackById($idPack);
        }

        public function createPack($data, float $prix){}

        //done
        public function deletePack(int $idPack) : bool{
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            return $this->packRepo->deletePackById($idPack);    
        }

        //done
        /**
         * @param data => array de type : [product => quantite]
         */
        public function updatePack(int $idPack,array $data){
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            if(empty($data)){throw new EmptyDataArray("L'array du data du update est vide");}
            if(isset($data["libelle"])){$libelle = $data["libelle"];}else{$libelle = "";}
            if(isset($data["niveau"])){$niveau = $data["niveau"];}else{$niveau = "";}
            if(isset($data["prx"])){$prx = $data["prx"];}else{$prx = 0;}
            if(isset($data["quantite"])){$quantite = $data["quantite"];}else{$quantite = -1;}
            if(isset($data["products"])){$products = $data["products"];}else{$products = [];}
            foreach($data as $product => $quantite){
                if($quantite < 0){throw new QuantityException("Quantité doit etres >= 0");}
                if($product["quantite_stock"] < $quantite){throw new QuantityException("Cette quantité est supérieur a la quantite du produit dans le stock!");}
            }
            return $this->packRepo->modifyPackById($idPack , $libelle , $niveau , $prx , $quantite , $products);
        }
        //done
        public function deleteUnArticleDuPack(int $idPack , int $idArticle){
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            if($idArticle < 1){throw new IdentifiantInvalideException("L'identifiant du l'article est invalide !");}
            if($this->packRepo->findPackById($idPack) == null){throw new PackInexistantException("Il n y'a pas de pack dont lid = $idPack ");}    
            if($this->productRepo->findProduitById($idArticle) == null){throw new ArticleInexistantException("L'article dont l'id = {$idArticle} n'existe pas");}
            return $this->packRepo->deleteArticleDuPack($idPack , $idArticle);
        }
        
        public function modifierUnArtcileDuPack(int $idPack , int $idArticle , array $data){

        }
        public function ajouterUnArtileToPack(int $idPack , Article $article){}

        public function calculerPrixRelleDuPack(int $idPack): float {}
        public function remisePack(int $idPack , float $amountRemise){}
        public function checkPackStock(int $idPack){}
    }

?> 