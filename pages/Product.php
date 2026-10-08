<?php
    require_once(__DIR__ . "/../backend/services/ProductServices.php");
    require_once(__DIR__ . "/../backend/models/Product.php");
    $product_service = new ProductServices();
    $idProduit = $_GET["idproduit"];
    $product_coordonee = $product_service->getProductById(intval($idProduit));
    $product = new Product(
        $product_coordonee["id_produit"],
        $product_coordonee["libelle"],
        intval($product_coordonee["quantite_stock"]),
        floatval($product_coordonee["prix"]),
        $product_coordonee["categorie"],
        $product_coordonee["code_barre"],
        $product_coordonee["image_url"],
        floatval($product_coordonee["remise"]),
        $product_coordonee["marque"],
        $product_coordonee["description"],
        $product_coordonee["nombre_rater"],
        $product_coordonee["rating"],
        $product_coordonee["information_supplementaire"]
    );

    $featureIcons = [
        "marque"              => "fa-solid fa-tag",
        "couleur"             => "fa-solid fa-palette",
        "matiere"             => "fa-solid fa-layer-group",
        "format"              => "fa-solid fa-file-lines",
        "taille"              => "fa-solid fa-ruler",
        "genre"               => "fa-solid fa-venus-mars",
        "age"                 => "fa-solid fa-child",
        "poids"               => "fa-solid fa-weight-hanging",
        "dimensions"          => "fa-solid fa-up-right-and-down-left-from-center",
        "nombre_pieces"       => "fa-solid fa-puzzle-piece",
        "capacite"            => "fa-solid fa-box-open",
        "pages"               => "fa-solid fa-book-open",
        "langue"              => "fa-solid fa-language",
        "auteur"              => "fa-solid fa-user-pen",
        "editeur"             => "fa-solid fa-building",
        "niveau_scolaire"     => "fa-solid fa-graduation-cap",
        "type_pointe"         => "fa-solid fa-pen",
        "epaisseur"           => "fa-solid fa-ruler-vertical",
        "matiere_couverture"  => "fa-solid fa-book",
        "compartiments"       => "fa-solid fa-table-cells-large",
        "roulettes"           => "fa-solid fa-wheelchair"
    ];
    
    $list_all_product = $product_service->getAllProduct(8,1);


    $list_articles_similaire = $product_service->produitSimilaire($product_coordonee["id_produit"],$product_coordonee["categorie"], $product_coordonee["marque"], 15);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">
    <title><?= $product->getLibelle() ?> | Librairie Chebbi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- linking google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=arrow_forward" />
    <!-- swiper cdn api  -->
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"
    />
    <!-- les lien lezmin css : wa7ed ll slider des articles w wa7ed ll page product b sifa 3amma -->
    <link rel="stylesheet" href="../assets/css/rating.css">
    <link rel="stylesheet" href="../assets/css/slider.css">
    <link rel="stylesheet" href="../assets/css/product.css">
</head>
<body>
    <?php include("../includes/header.php") ?>
    <main class="product">
        <div class="path">
            <a href="/products">Acueil</a>
            <!-- 
            <a href="">School Supplies</a> -->
            <i class="fa-solid fa-angle-right"></i>
            <a href="/product?categorie=<?= $product->getCategorie(); ?>"><?= $product->getCategorie(); ?></a>
            <i class="fa-solid fa-angle-right"></i>
            <a href=""><?= $product->getLibelle(); ?></a>

        </div>
        <section class="top">
            <div class="image-part">
                <img  src="<?= $product->getImageUrl() ?>" alt="">
            </div>
            <div class="text-part">
                <!-- en cas de stock -->
                <?php if($product->getStock()>0): ?>
                <p class="stock-info " id="in-stock" >
                    <i class="fa-regular fa-circle-check"></i>
                    In Stock
                </p>
                <?php else: ?>
                <p class="stock-info" id="out-stock">
                    <i class="fa-solid fa-ban"></i>
                    Repture de stock
                </p>
                <?php endif; ?>
                <h2 class="product-title"><?= $product->getLibelle() ?></h2>
                <div class="review">
                    <img src="/assets/images/rating/<?= $product->getNumberOfStars() ?>.png" alt="" id="rating">
                    <p class="n-review">(<?= $product->getReview() ?> Reviews)</p>
                </div>
                <div class="prix">
                    <?php if($product->getRemise() > 0): ?>
                    <h3><?= number_format($product->getPrix() - $product->getRemise() , 3 , "." , " ")  ?> </h3>
                    <p>DT</p>
                    <span class="prixOriginal">
                        <h6><?= number_format($product->getPrix(), 3 , "." , " ") ?> Dt</h6>
                    </span>
                    <?php else:  ?>
                        <h3><?= number_format($product->getPrix(), 3 , "." , " ")  ?> </h3>
                        <p>DT</p>
                    <?php endif; ?>
                </div>
                <p class="description">
                    <?= $product->getDescription(); ?>
                </p>
                <!-- needs to be filled with php -->
                <ul class="list-info">
                    <li>
                        <i class="fa-solid fa-clipboard-list"></i>
                        Categorie: <?= $product->getCategorie() ?>
                    </li>
                    <?php if(!empty($product->getInformationSupplementaireArray())): ?>
                    <?php foreach ($product->getInformationSupplementaireArray() as $feature):
                        $icon = $featureIcons[$feature[0]] ?? "fa-solid fa-circle-info";
                    ?>
                        <li>
                            <i class="<?= $icon ?>"></i>
                            <?= htmlspecialchars($feature[0]) . " : " . htmlspecialchars($feature[1]) ?>
                        </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="article-buttons">
                    <form action="">

                        <div class="numbers">
                            <button id="minusButton" type="button">-</button>
                            <input type="number" id="quantity" value="1">
                            <button id="plusButton" type="button">+</button>
                        </div>
                        <a href="" class="add-to-cart addToCartBtn" data-idpack="<?= $product->getId() ?>" data-idproduit ="<?=$product->getId() ?>" data-name="<?= $product->getLibelle() ?>" data-price="<?= $product->getPrix() - $product->getRemise() ?>"><i class="fa-solid fa-cart-plus"></i>Add to cart</a>
                    </form>
                </div>
                <a href="" class="wishlist"><i class="fa-regular fa-heart"></i>Add to Wishlist</a>
            </div>
        </section>
    </main>

    
        <section class="bottom">
            <h3>Articles qui semblent similaires </h3>
            <div class="slider">
                <div class="container-slider swiper">
                    <div class="card-wrapper ">
                        
                        <ul class="card-list swiper-wrapper">
                            <?php foreach($list_articles_similaire as $product): ?>

                                <li class="card-item swiper-slide">
                                    <a href="/products/product?idproduit=<?= $product["id_produit"] ?>" class="card-link ">
                                        <img class="card-image" src="<?= $product["image_url"] ?>" alt="">
                                        <p class="badge">S<?= $product["libelle"] ?></p>
                                        <h2 class="card-title"><?= $product["prix"] ?> <span>dt</span> </h2>
                                        <div class="rating-container">
                                            <?php 
                                                $rating = floatval($product["rating"]);
                                                $int_before = intval(round($rating));
                                                $int_after = intval(ceil($rating));
                                                if($rating< $int_after && $rating > $int_before){$rating = $int_before + 0.5;}
                                                else{$rating = intval($rating);}
                                            ?>
                                            <img src="../assets/images/rating/<?= $rating ?>.png" alt="" class="img-rating">
                                            <div class="number">(<?= $product["nombre_rater"] ?>)</div>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            
                        </ul>

                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- If we need navigation buttons -->
                        <div class="swiper-slide-button swiper-button-prev"></div>
                        <div class="swiper-slide-button swiper-button-next"></div>

                    </div>
                </div>


                <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
                <script src="../assets/js/slider.js"></script>


            </div>
        </section>

        <script src="../assets/js/oneProduct.js"></script>
        <div id="toast-region"></div>
    <?php include("../includes/footer.php"); ?>
    <script src="/assets/js/popUpAddToCart.js"></script>
</body>
</html>