<?php 


require_once(__DIR__ . "/../models/Product.php");

interface IProductRepository
{
    // ---------- Statistiques ventes ----------
    public function venteParMois(int $mois, int $year);
    public function nbreDeVentePourChaqueCategorieCeMois();
    public function nbreDeVenteToutalCeMois();
    public function nbreDeventeParJour(int $jour);
    public function nombreDeVentePourChaquePack();
    public function Top10Ventes();
    public function ArticleAfaibleRotation();

    // ---------- Statistiques stock ----------
    public function nbreArticleEnRepture();
    public function nbreArticleNonVendus();
    public function stockElevee();
    public function stockMoyen();
    public function stockFaible();

    // ---------- CRUD produit ----------
    public function deleteProduct(int $id_prod): bool;
    public function findAllProducts(int $limit, int $offset);
    public function findProduitById(int $id);
    public function ajouterProduit(Product $produit);
    public function getProductById(string $id);
    public function createNewProduct(
        $libelle,
        $prixUnitaire,
        $quantite,
        $categorie,
        $marque,
        $remise,
        $description,
        $image_url,
        $codeBarre,
        $anneescolaire,
        $genre,
        $collection ,
        $typeCollection
    );

    public function modifierProduit(
        int $idProduit,
        string $codeBarre,
        string $libelle = "",
        float $prix = 0,
        string $categorie = "",
        string $marque = "",
        float $remise = 0,
        string $description = "",
        string $image_url = ""
    ): bool;

    public function decreaseQuantity(int $product, int $quantityToDelete): bool;

    public function increaseQuantity(int $product, int $quantityToDelete): bool;

    public function ajouterUnRemiseSurProduit(int $idProduit, float $amountRemise): bool;

    // ---------- Listes de référence ----------
    public function getAllCategorie();

    public function getAllMarque();

    // ---------- Recherche & pagination ----------
    public function rechercherArticle(
        string $categorie,
        string $libelle,
        string $marque,
        float $prixMax,
        float $prixMin,
        string $stock,
        string $trie,
        int $limit,
        int $page
    );

    public function nombreLigneRechercherArticle(
        string $categorie,
        string $libelle,
        string $marque,
        float $prixMax,
        float $prixMin,
        string $stock,
        string $trie,
        int $limit,
        int $page
    );

    public function rechercherArticle2(string $data, string $critere, int $limit, int $offset);

    public function searchBar(string $data);

    // ---------- Packs / livres / parascolaire ----------
    public function findPackLivre(string $annee, int $limit, int $offset);

    public function findLivreScolaire(string $libelle, string $niveauScolaire, int $limit, int $offset);

    public function numberOfLinesfindLivreScolaire(string $libelle, string $niveauScolaire);

    public function findParascolaire(
        string $libelle,
        string $niveauScolaire,
        string $collection,
        int $limit,
        int $offset
    );

    public function numberOfLineFindParascolaire(string $libelle, string $niveauScolaire, string $collection);
    // ---------- partie games -------------
    public function getAllGames(string $libelle, string $genre , int $page , int $offset);
    // cette function permet de retourner tous le nombre de ligne de recherche du jouets
    public function numberOfRowsAllGames(string $libelle, string $genre );

    // related to collections part
    public function getAllCollection($type ,$genre, $page , $limit);
    public function numberOfRowGetAllCollection($type,$genre);
    }




?>