<?php
    require_once(__DIR__ . "/../backend/services/ProductServices.php");
    $product_service = new ProductServices();
    $type = isset($_GET["type"]) ? $_GET["type"] : "";
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $limit = isset($_GET["limit"]) ? $_GET["limit"] : 8;
    $genre = isset($_GET["genre"]) ? $_GET["genre"] : "";
    // -------------------------------------------------------------------------------
    $collectionListe = $product_service->getAllCollection($type,$genre , $page , $limit);
    $nombre_row_totale = $product_service->numberOfRowGetAllCollection($type,$genre);
    // -------------------------------------------------------------------------------

    $today = new DateTime("today");


    $nombre_totale_page = ceil($nombre_row_totale / $limit);
    
    $query_array= [];
    foreach($_GET as $key=>$val){
        if($key !== "page")
        $query_array[] = "$key=$val";
        
    } 
    $query_string = implode("&", $query_array) ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection | Librairie Chebbi</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />

    <link rel="stylesheet" href="../assets/css/collection.css">
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">
</head>
<body>

    <?php include("../includes/header.php"); ?>
    <div class="collection">
        <main>
            <div class="text">
                <h5>NOUVEAU</h5>
                <h1>
                    Collection <br> Rentrée <span>2026</span>
                </h1>
                <p>Sac à dos , Trousses et paniers pour une rentré bien organisée .</p>

                <button>Découvrir la Collection <i class="fa-solid fa-arrow-right"></i></button>

            </div>


            <img src="../assets/images/collection/back1.png" alt="">
            <img src="../assets/images/collection/effet1.png" alt="">
            <img src="../assets/images/collection/effet1.png" alt="">
            <img src="../assets/images/collection/effet2.png" alt="">
            
        </main>




        <div class="partie-articles">

            <div class="top">
                <div>
                    <ul class="typeSac">       
                        <li data-value="" ><a href="" class="selected" >Tous</a></li>
                        <li data-value="sac a dos"><a href="">Sac à dos</a></li>
                        <li data-value="trousse"><a href="">Trousses</a></li>
                        <li data-value="panier"><a href="">Paniers</a></li>
                    </ul>
                </div>
                <div>
                    <span>Trier par : </span>
                    <select name="" id="">
                        <option value="">Popularité</option>
                        <option value="">Prix Croissant</option>
                        <option value="">Prix Décroissant</option>
                    </select>
                </div>
            </div>
            <div class="gender-buttons">
                <button class="gender-btn gender-garcon" data-value="garçon">👦🏻 Garçon</button>
                <button class="gender-btn gender-fille" data-value="fille">👧🏻 Fille</button>
                <button class="gender-btn gender-mixte" data-value="mixte">👦🏻👧🏻 Mixte</button>
            </div>


            <section class="article-container"> 
                <?php foreach($collectionListe as $collection): ?>
                    <?php $dataAjout = new DateTime($collection["date_ajout"]); ?>
                    <article data-idproduit="<?= $collection["id_produit"] ?>">
                            <?php if($collection["remise"] > 0): ?>
                                <span class="remise">Remise</span>
                            <?php elseif($collection["quantite_stock"] == 0 ): ?>
                                <span class="repture" >repture de stock</span>
                            <?php elseif($today->diff($dataAjout)->days <= 2): ?>
                                <span class="new">Nouveau</span>
                            <?php endif; ?>
                        <img src="<?= $collection["image_url"] ?>" alt="">
                        <h4><?= $collection["libelle"] ?>=</h4>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <p class="rating-number">4.8</p>
                            <p class="number-of-poeple">(120)</p>
                        </div>
                        
                        <h3 class="price"><?= number_format($collection["prix"],3,","," ") ?> DT</h3>
                        <a href="" class="button addToCartBtn" data-idproduit="<?= $collection["id_produit"] ?>" data-name="<?= $collection["libelle"] ?>" data-price="<?= $collection["prix"] -  $collection["remise"] ?>">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Ajouter au panier
                        </a>
                        <a href="" class="wishlist">
                            <i class="fa-regular fa-heart"></i>
                        </a>
                    </article>
                <?php endforeach; ?>
            </section>

                    <div class="pagination">
                        <!-- before -->
                        <?php if($page > 1) : ?>
                            <a  href="/collections?page=<?= $page - 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php else : ?>
                            <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php endif; ?>




                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/collections?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>



                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_totale_page) ; $i++):?>
                            <a href="/collections?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nombre_totale_page - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <?php if($page < $nombre_totale_page) : ?>
                            <a href="/collections?page=<?= $page + 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php else : ?>
                             <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php endif; ?>
                    </div>

        </div>
        </div>


    </div>

    <div id="toast-region"></div>
    <?php include("../includes/footer.php"); ?>
    <script src="/assets/js/popUpAddToCart.js"></script>
    <script src="/assets/js/collection.js"></script>
</body>
</html>