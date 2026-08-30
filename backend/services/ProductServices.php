<?php

include_once(__DIR__ . "/../repository/ProductRepository.php");
include_once(__DIR__ . "/../exception/ArticleInexistantException.php");
include_once(__DIR__ . "/../exception/EmptyDataArray.php");
include_once(__DIR__ . "/../exception/IdentifiantInvalideException.php");
include_once(__DIR__ . "/../exception/PackInexistantException.php");
include_once(__DIR__ . "/../exception/QuantityException.php");
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
    public function rechercherArticle(string $categorie , string $libelle ,string $marque, float $prixMax , float $prixMin , string $stock , string $trie ,string $codeBarre, int $limit = 10 , int $page = 1){  
        if(!in_array(strtolower($stock) ,["","stock eleve","stock moyen","stock faible","repture de stock","disponible"])){
            throw new Exception("La valeur du stock est invalide");
        }
        if(!in_array($trie , ["id article","libellé","prix unitaire","stock","nombre de vente","","marque","code_barre"])){throw new Exception("Le critére de trie est invalide!");}
        return $this->productRepo->rechercherArticle($categorie , $libelle,$marque, $prixMax,$prixMin , $stock , $trie ,$codeBarre, $limit,$page);
    }
    //done
    public function nombreLigneRechercherArticle(string $categorie , string $libelle ,string $marque, float $prixMax , float $prixMin , string $stock , string $trie , string $codeBarre , int $limit = 10 , int $page = 0){
        if(!in_array(strtolower($stock) ,["","stock eleve","stock moyen","stock faible","repture de stock","disponible"])){
            throw new Exception("La valeur du stock est invalide");
        }
        if(!in_array($trie , ["id article","libellé","prix unitaire","stock","nombre de vente","","marque","code_barre"])){throw new Exception("Le critére de trie est invalide!");}
        return $this->productRepo->nombreLigneRechercherArticle($categorie , $libelle,$marque, $prixMax,$prixMin , $stock , $trie ,$codeBarre, $limit,$page);
    }
    //done
    public function createProduct(string $libelle,float $prixUnitaire,int $quantite ,string $categorie,string $marque,float $remise ,string $description, $file ,?string $codeBarre, ?string $anneescolaire , ?string $genre , ?string $collection , ?string $typeCollection , ?string $matiere): bool{
        if(empty($libelle)){throw new Exception("Libelle de produit ne doit pas etre vide!");}
        if($prixUnitaire<0){throw new Exception("prixUnitaire de produit ne doit pas etre negatif!");}
        if($quantite<0){throw new Exception("quantite de produit ne doit pas etre negatif!");}
        if(empty($categorie)){throw new Exception("categorie de produit ne doit pas etre vide!");}
        // if(empty($marque)){throw new Exception("marque de produit ne doit pas etre vide!");}
        if($remise < 0 || $remise > $prixUnitaire){throw new Exception("remise de produit invalide!");}
        $name = $file["name"];
        $tmp = $file["tmp_name"];
        $type = $file["type"];
        $allowedType = ["image/jpeg", "image/png", "image/webp"];
        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur upload : " . $_FILES["image"]["error"]);
        }
        if(!in_array($type , $allowedType)){throw new Exception("This file Type in not supported!");}
        if($file["size"] > 4 * 1024 * 1024 ){throw new Exception("the File uploaded is too large(>4mb)");}
        $extension = pathinfo($name , PATHINFO_EXTENSION);
        // generate unique name
        $newName = bin2hex(random_bytes(16)) . "." . $extension;
        $upload_dir = __DIR__ . "/../../public/assets/images/uploadedImg/articles/";
        if(!is_dir($upload_dir)){mkdir($upload_dir , 0077 , true);}
        $dest = $upload_dir . $newName;
        $destDB = "/assets/images/uploadedImg/articles/" . $newName; 
        if(!move_uploaded_file($tmp , $dest)){throw new Exception("Image Upload Failed!");}
        return $this->productRepo->createNewProduct($libelle, $prixUnitaire, $quantite , $categorie, $marque, $remise , $description, $destDB, $codeBarre,$anneescolaire , $genre, $collection , $typeCollection , $matiere);
    }
    //done
    public function getAllProduct(int $limit , int $page) : array {
        $offset = ($page - 1) * $limit;
        return $this->productRepo->findAllProducts($limit , $offset);
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
    //done
    public function rechercherArticle2(string $data , string $critere , int $limit , int $page){
        $data = trim(mb_strtolower($data));
        $critere = trim(mb_strtolower($critere));
        if($limit<1){throw new Exception("La limite doit etre > 1");}
        if($page<1){throw new Exception("La page doit etre > 1");}
        if(!in_array($critere,["" , "libelle","categorie", "marque" , "prix"])){throw new Exception("La critere est invalide!");}
        return $this->productRepo->rechercherArticle2($data,$critere,$limit, ($page - 1) * $limit);
    }
    //done
    public function venteCeMois(){
        $month = intval(date("m"));
        $year = intval(date("Y"));
        return $this->productRepo->venteParMois($month , $year);
    }
    //done
    public function venteDernierMois(){
        $month = intval(date("m" , strtotime("-1 month")));
        $year = intval(date("Y", strtotime("-1 month")));
        return $this->productRepo->venteParMois($month , $year);
    }
    //done
    public function nbreArticleEnRepture(){
        return $this->productRepo->nbreArticleEnRepture();
    }
    //done
    public function nbreArticleNonVendus(){
        return $this->productRepo->nbreArticleNonVendus();
    }
    //done
    public function stockElevee(){
        return $this->productRepo->stockElevee();
    }
    //done
    public function stockMoyen(){
        return $this->productRepo->stockMoyen();
    }
    //done
    public function stockFaible(){
        return $this->productRepo->stockFaible();
    }
    //done
    public function nombreDeVenteParMois(int $month , int $year){
        if($month > 12 || $month < 0 ){throw new Exception("La valeur du mois : $month est invalide!");}
        if($year > intVal(date("Y")) || $year < 1990){throw new Exception("La valeur de l'année est invalide!");}
        return $this->productRepo->venteParMois($month ,$year);
    }
    //done
    public function nbreDeVentePourChaqueCategorieCeMois(){
        return $this->productRepo->nbreDeVentePourChaqueCategorieCeMois();
    }
    //done
    public function Top10Ventes(){return $this->productRepo->Top10Ventes();}
    //done
    public function ArticleAfaibleRotation(){return $this->productRepo->ArticleAfaibleRotation();}



    public function getAllMarque(){return $this->productRepo->getAllMarque();}
    public function getAllCategorie(){return $this->productRepo->getAllMarque();}


    public function nombreDeVenteParJour(int $jour){
        if(!($jour <= 6 && $jour >= 0)){throw new Exception("La valeur de jour doit etre compris entre 1 et 6");}
        return $this->productRepo->nbreDeventeParJour($jour);
    }

    public function nombreDeVentePourChaquePack(){
        return $this->productRepo->nombreDeVentePourChaquePack();
    }


    public function searchBar(string $data){
        return $this->productRepo->searchBar($data);
    }


    public function findParascolaire(string $libelle, string $niveauScolaire , string $collection , int $limit , int $page){
        $offset =($page - 1) * $limit;
        return $this->productRepo->findParascolaire($libelle , $niveauScolaire , $collection , $limit,$offset);
    }

    public function numberOfLineFindParascolaire(string $libelle, string $niveauScolaire , string $collection){
        return $this->productRepo->numberOfLineFindParascolaire( $libelle,  $niveauScolaire , $collection);
    }

    public function findLivreScolaire(string $libelle , string $niveauScolaire , int $limit , int $page){
        $offset = ($page - 1) * $limit;
        return $this->productRepo->findLivreScolaire($libelle, $niveauScolaire , $limit ,$offset);
    }
    public function numberOfLinesfindLivreScolaire(string $libelle , string $niveauScolaire){
        return $this->productRepo->numberOfLinesfindLivreScolaire($libelle, $niveauScolaire);
    }


    // partie teb3a el games uri
    public function getAllGames($libelle , $genre , $page , $limit){
        $offset = ($page -1) * $limit;
        return $this->productRepo->getAllGames($libelle , $genre , $limit , $offset);
    }
    public function numberOfRowsAllGames($libelle , $genre){
        return $this->productRepo->numberOfRowsAllGames($libelle , $genre);
    }

    // get list of all collection
    public function getAllCollection($type ,$genre, $page , $limit){
        $offset = ($page - 1 ) * $limit;
        $type = mb_strtolower($type);
        $genre = mb_strtolower($genre);
        if(!in_array($genre,["fille","garçon","mixte",""])){throw new Exception("Le Genre dans la partie sac est invalide!!");}
        if(!in_array($type, ["","sac a dos","panier","trousse","sac a chariot","chariot"])){throw new Exception("Le type est invalide !");}
        return $this->productRepo->getAllCollection($type,$genre,$limit,$offset);
    }
    // get the number of raw total of all collection
    public function numberOfRowGetAllCollection($type,$genre){
        $type = mb_strtolower($type);
        $genre = mb_strtolower($genre);
        if(!in_array($genre,["fille","garçon","mixte",""])){throw new Exception("Le Genre dans la partie sac est invalide!!");}
        if(!in_array($type, ["","sac a dos","panier","trousse","sac a chariot","chariot"])){throw new Exception("Le type est invalide !");}
        return $this->productRepo->numberOfRowGetAllCollection($type,$genre);
    }
}








?> 