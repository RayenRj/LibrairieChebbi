<?php
    include_once(__DIR__ . "/../models/Pack.php");
    include_once(__DIR__ . "/../repository/PackRepository.php");
    include_once(__DIR__ . "/../repository/ProductRepository.php");
    include_once(__DIR__ . "/../exception/IdentifiantInvalideException.php");
    include_once(__DIR__ . "/../exception/EmptyDataArray.php");
    include_once(__DIR__ . "/../exception/QuantityException.php");
    class PackServices{
        private PackRepository $packRepo;
        private ProductRepository $productRepo;
        public function __construct(){
            $this->packRepo = new PackRepository();
            $this->productRepo = new ProductRepository();
        }

        // 4 card part : statistics
        public function revenuePackCeMois(){return $this->packRepo->revenuePackCeMois();}
        public function revenuePackDernierMois(){return $this->packRepo->revenuePackDernierMois();}
        public function totalPacks(){return $this->packRepo->NombreTotalePack();}
        public function totalPacksActifs(){return $this->packRepo->NombreTotalePackActif();}
        public function totalPacksRepture(){return $this->packRepo->packEnRepture();}


        // recher Article avec filtrage 

        public function recherchePack(string $nom, string $niveau , string $statut , int $limit , int $pagination){
            if(!in_array($niveau , ["primaire", "college","secondaire","bac" ,""])){throw new Exception("Le niveau scolaire de cette pack est invalide!");}
            if(!in_array($statut,["actif", "rupture",""])){throw new Exception("La statut de cette pack est invalide");}
            if($pagination < 1){throw new Exception("La page doit etre >= 1");}
            if($limit < 1){throw new Exception("la limit doit etre > 1");}
            return $this->packRepo->recherchePack($nom, $niveau , $statut , $limit, $pagination);
        }
        public function nbreRowRecherchePack(string $nom, string $niveau , string $statut , int $limit , int $pagination){
            if(!in_array($niveau , ["primaire", "college","secondaire","bac" ,""])){throw new Exception("Le niveau scolaire de cette pack est invalide!");}
            if(!in_array($statut,["actif", "rupture",""])){throw new Exception("La statut de cette pack est invalide");}
            if($pagination < 1){throw new Exception("La page doit etre >= 1");}
            if($limit < 1){throw new Exception("la limit doit etre > 1");}
            return $this->packRepo->nbreRowRecherchePack($nom, $niveau , $statut , $limit, $pagination);
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
        //done
        public function getPackById(int $idPack){
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            return $this->packRepo->findPackById($idPack);
        }
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
       //done
        public function calculerPrixRelleDuPack(int $idPack): float {
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            $articlesList = $this->packRepo->getPackArticles($idPack);
            $prix_totale = 0;
            foreach($articlesList as $row){
                $article = $this->productRepo->findProduitById($row["id_produit"]);
                $quantite = $row["quantite"];
                $prix_totale += $quantite * $article->getPrix();
            }
            return $prix_totale;
        }
        //done
        public function checkPackStock(int $idPack) : bool{
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            $product = $this->productRepo->findProduitById($idPack);
            if(!$product){return false;}
            return $product->getPrix() > 0;
        }
        //done
        public function ajouterUnArtcileToPack(int $idPack , int $idArticle , int $quantite){
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            if($idArticle < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            if($quantite < 0){throw new Exception("la quantité doit etre > 0");}  
            return $this->packRepo->ajouterArticleAuPack($idPack , $idArticle , $quantite);     
        }

        //done
        public function remisePack(int $idPack , float $amountRemise) : bool {
            if($idPack < 1){throw new IdentifiantInvalideException("L'identifiant du pack est invalide !");}
            $product = $this->productRepo->findProduitById($idPack);
            if(!$product){return false;}
            if($amountRemise > $product->getPrix()){return false;}
            return $this->productRepo->ajouterUnRemiseSurProduit($idPack , $amountRemise);
        }

        //done
        /**
         * @param data => [product => quantite]
         * @param niveau => in ["primaire", "college","secondaire","bac"]
         * @param prix => > 0
         */
        public function createPack($data, float $prix , $niveau ,string $libelle,int $quantite , $file ,float $remise ,string $description){
            if(empty($data)){throw new EmptyDataArray("L'array du donnée est vide!");}
            if($prix < 0){throw new Exception("prix doit etre positif !");}
            $niveau = mb_strtolower($niveau);
            if(!in_array( $niveau, ["primaire", "college","secondaire","bac"])){throw new Exception("le niveau est invalide!!!");}
            //file handling 
            if(!isset($file["packImage"])){throw new Exception("La pack doit contenir une image");}
            $image = $file["packImage"];
            if ($image["error"] !== UPLOAD_ERR_OK) {throw new Exception("Erreur upload : " . $_FILES["image"]["error"]);}
            if(!in_array($image["type"], ["image/jpeg","image/png","image/webp"])){throw new Exception("Ce Type d'image ". $image["type"] ." n'est pas autorisee !");}
            if($image["size"] > 5 * 1024 * 1024){throw new Exception("Image size too large > 5mb");}
            $ext = pathinfo($image["name"] , PATHINFO_EXTENSION);
            $newName = bin2hex(random_bytes(16)) . "." . $ext;
            $uploadDir = __DIR__ . "/../../public/assets/images/uploadedImg/packImg/";
            
            if(!is_dir($uploadDir)){mkdir($uploadDir , 0777,true);}
            $destination = $uploadDir . $newName;
            if(!move_uploaded_file($image["tmp_name"],$destination)){throw new Exception("Failed to save the image!!");}
            $image_url = "/assets/uploadedImg/packImg/" . $newName;
            return $this->packRepo->createNewPack($data , $prix , $niveau , $libelle, $quantite, $image_url , $remise , $description);
        }
    }

?> 