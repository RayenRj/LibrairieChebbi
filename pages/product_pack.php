<?php
    require_once(__DIR__ . "/../backend/services/ProductServices.php");
    require_once(__DIR__ . "/../backend/services/packServices.php");
    require_once(__DIR__ . "/../backend/models/Pack.php");

    $product_service = new ProductServices();
    $pack_services = new PackServices();
    $idpack = $_GET["idPack"];
    $product_coordonee = $pack_services->getPackById(intval($idpack));
    $pack_article = $pack_services->getPackArticles($idpack);
    $pack = new Pack(
        $product_coordonee["id_produit"],
        $product_coordonee["libelle"],
        $product_coordonee["type"],
        $pack_article,
        $product_coordonee["prix"],
        $product_coordonee["image_url"],
        $product_coordonee["quantite_stock"]
    );

    $list_all_product = $product_service->getAllProduct(8,1); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit name</title>
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
            <a href="/main">Home</a>
            <i class="fa-solid fa-angle-right"></i>
            <a href="/products">School Supplies</a>
            <i class="fa-solid fa-angle-right"></i>
            <a href="/products?categorie=<?= $pack->getType() ?>"><?= $pack->getType() ?></a>
            <i class="fa-solid fa-angle-right"></i>
            <a href="#"><?= $pack->getLibelle() ?></a>

        </div>
        <section class="top">
            <div class="image-part">
                <img  src="<?= $pack->getImageUrl() ?>" alt="">
            </div>
            <div class="text-part">
                <!-- en cas de stock -->
                <?php if($pack->getStock()>0): ?>
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
                <h2 class="product-title"><?= $pack->getLibelle() ?></h2>
                <div class="review">
                    <img src="/assets/images/rating/5.png" alt="" id="rating">
                    <p class="n-review">(24 Reviews)</p>
                </div>
                <div class="prix">
                    <h3><?= number_format($pack->getPrixTotale() , 3 ,"," , thousands_separator:" ") ?> </h3>
                    <p>DT</p>
                </div>
                <p class="description">
                    High-quality spiral notebook with smooth pages, perfect for school , office and personal use
                </p>
                <!-- needs to be filled with php -->
                <ul class="list-info">
                    <li>
                        <i class="fa-solid fa-clipboard-list"></i>
                        Categorie: <?= $pack->getType() ?>
                    </li>
                    <li>
                        <i class="fa-solid fa-tag"></i>
                        Brand: <?= $pack->getType() ?>
                    </li>
                    <li>
                        <i class="fa-solid fa-expand"></i>
                        Nombre Totale D'articles: <?= $pack_services->getNumberPackArticles($pack->getPackId()); ?>
                    </li>
                    <li>
                        <i class="fa-solid fa-file"></i>
                        Page: 120 Lined pages
                    </li>
                    <li>
                        <i class="fa-solid fa-book"></i>
                        Cover: Durable Plastic cover
                    </li>
                </ul>
                <div class="article-buttons">
                    <form action="">

                        <div class="numbers">
                            <button id="minusButton" type="button">-</button>
                            <input type="number" id="quantity" value="1">
                            <button id="plusButton" type="button">+</button>
                        </div>
                        <a href="" class="add-to-cart addToCartBtn"  data-idpack="<?= $pack->getPackId()?>" data-idproduit ="<?= $pack->getPackId() ?>" data-name="<?= $pack->getLibelle() ?>" data-price="<?= $pack->getPrixTotale() ?>"><i class="fa-solid fa-cart-plus"></i>Add to cart</a>
                    </form>
                </div>
                <a href="" class="wishlist"><i class="fa-regular fa-heart"></i>Add to Wishlist</a>
            </div>
        </section>
    </main>

    
        <section class="bottom packTable">
            <h3>Articles inclus dans le pack</h3>
            <div class="tableContainer">
            <table>
                <thead>
                    <th>Article</th>
                    <th>Catégorie</th>
                    <th>Marque</th>
                    <th>Prix Unitaire</th>
                    <th>Quantité</th>
                </thead>
                <tbody>
                    <?php foreach($pack->getProducts() as $article): ?>
                    <tr>
                        <td>
                            <img src="<?= $article["image_url"] ?>" alt="pack articles image">
                            <div class="libelle"><?= $article["libelle"] ?></div>
                        </td>
                        <td><?= $article["categorie"] ?></td>
                        <td><?= $article["marque"] ?></td>
                        <td class="prix"><?= number_format($article["prix"] , 3, "," , " ") ?> <span>Dt</span></td>
                        <td><?= $article["quantite"] ?></td>                       
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                
            </table>
            </div>



        </section>

        <?php include("../includes/footer.php"); ?>
    <div id="toast-region"></div>
    <script src="../assets/js/oneProduct.js"></script>
    <script src="/assets/js/popUpAddToCart.js"></script>

</body>
</html>