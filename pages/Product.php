<?php
    require_once(__DIR__ . "/../backend/services/ProductServices.php");
    require_once(__DIR__ . "/../backend/models/Product.php");
    $product_service = new ProductServices();
    $idProduit = $_GET["idProduit"];
    $product_coordonee = $product_service->getProductById(intval($idProduit));
    $product = new Product(
        $product_coordonee["id_produit"],
        $product_coordonee["code_barre"],
        $product_coordonee["libelle"]
    );

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
            <a href="">Home</a>
            <i class="fa-solid fa-angle-right"></i>
            <a href="">School Supplies</a>
            <i class="fa-solid fa-angle-right"></i>
            <a href="">Notebook</a>
            <i class="fa-solid fa-angle-right"></i>
            <a href="">Premium Spiral Netebook A5</a>

        </div>
        <section class="top">
            <div class="image-part">
                <img  src="https://i5.walmartimages.com/seo/Pen-Gear-Wide-Ruled-3-Subject-Spiral-Notebook-Blue-10-5-x-8-120-Pages_c855428f-291b-4944-90e7-109feb227414.2bada78a9234b50787a896a37820e894.jpeg" alt="">
            </div>
            <div class="text-part">
                <!-- en cas de stock -->
                
                <p class="stock-info " id="in-stock" hidden>
                    <i class="fa-regular fa-circle-check"></i>
                    In Stock
                </p>
                <p class="stock-info" id="out-stock">
                    <i class="fa-solid fa-ban"></i>
                    Repture de stock
                </p>
                <h2 class="product-title">Premium Spiral Notebook A5</h2>
                <div class="review">
                    5 Start
                    <p class="n-review">(24 Reviews)</p>
                </div>
                <div class="prix">
                    <h3>12.900 </h3>
                    <p>DT</p>
                </div>
                <p class="description">
                    High-quality spiral notebook with smooth pages, perfect for school , office and personal use
                </p>
                <!-- needs to be filled with php -->
                <ul class="list-info">
                    <li>
                        <i class="fa-solid fa-clipboard-list"></i>
                        Categorie: Notebook
                    </li>
                    <li>
                        <i class="fa-solid fa-tag"></i>
                        Brand: Bic
                    </li>
                    <li>
                        <i class="fa-solid fa-expand"></i>
                        Size: A5
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
                        <a href="" class="add-to-cart"><i class="fa-solid fa-cart-plus"></i>Add to cart</a>
                    </form>
                </div>
                <a href="" class="wishlist"><i class="fa-regular fa-heart"></i>Add to Wishlist</a>
            </div>
        </section>
    </main>

    
        <section class="bottom">
            <h3>You may also like</h3>
            <div class="slider">
                <div class="container-slider swiper">
                    <div class="card-wrapper ">
                        
                        <ul class="card-list swiper-wrapper">
                            <li class="card-item swiper-slide">
                                <a href="" class="card-link ">
                                    <img class="card-image" src="https://opusartsupplies.com/cdn/shop/products/SML10830.jpg?v=1660668993" alt="">
                                    <p class="badge">Smooth Ball Pen Blue</p>
                                    <h2 class="card-title">2,900 <span>dt</span></h2>
                                    <div class="rating-container">
                                         <img src="../assets/images/rating/4.5.png" alt="" class="img-rating">
                                        <div class="number">(18)</div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="" class="card-link ">
                                    <img class="card-image" src="https://opusartsupplies.com/cdn/shop/products/SML10830.jpg?v=1660668993" alt="">
                                    <p class="badge">Smooth Ball Pen Blue</p>
                                    <h2 class="card-title">2,900 <span>dt</span></h2>
                                    <div class="rating-container">
                                         <img src="../assets/images/rating/4.5.png" alt="" class="img-rating">
                                        <div class="number">(18)</div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="" class="card-link ">
                                    <img class="card-image" src="https://opusartsupplies.com/cdn/shop/products/SML10830.jpg?v=1660668993" alt="">
                                    <p class="badge">Smooth Ball Pen Blue</p>
                                    <h2 class="card-title">2,900 <span>dt</span></h2>
                                    <div class="rating-container">
                                         <img src="../assets/images/rating/4.5.png" alt="" class="img-rating">
                                        <div class="number">(18)</div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="" class="card-link ">
                                    <img class="card-image" src="https://opusartsupplies.com/cdn/shop/products/SML10830.jpg?v=1660668993" alt="">
                                    <p class="badge">Smooth Ball Pen Blue</p>
                                    <h2 class="card-title">2,900 <span>dt</span></h2>
                                    <div class="rating-container">
                                         <img src="../assets/images/rating/4.5.png" alt="" class="img-rating">
                                        <div class="number">(18)</div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="" class="card-link ">
                                    <img class="card-image" src="https://opusartsupplies.com/cdn/shop/products/SML10830.jpg?v=1660668993" alt="">
                                    <p class="badge">Smooth Ball Pen Blue</p>
                                    <h2 class="card-title">2,900 <span>dt</span></h2>
                                    <div class="rating-container">
                                         <img src="../assets/images/rating/4.5.png" alt="" class="img-rating">
                                        <div class="number">(18)</div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="" class="card-link ">
                                    <img class="card-image" src="https://opusartsupplies.com/cdn/shop/products/SML10830.jpg?v=1660668993" alt="">
                                    <p class="badge">Smooth Ball Pen Blue</p>
                                    <h2 class="card-title">2,900 <span>dt</span></h2>
                                    <div class="rating-container">
                                         <img src="../assets/images/rating/4.5.png" alt="" class="img-rating">
                                        <div class="number">(18)</div>
                                    </div>
                                </a>
                            </li>
                            <li class="card-item swiper-slide">
                                <a href="" class="card-link ">
                                    <img class="card-image" src="https://opusartsupplies.com/cdn/shop/products/SML10830.jpg?v=1660668993" alt="">
                                    <p class="badge">Smooth Ball Pen Blue</p>
                                    <h2 class="card-title">2,900 <span>dt</span></h2>
                                    <div class="rating-container">
                                         <img src="../assets/images/rating/4.5.png" alt="" class="img-rating">
                                        <div class="number">(18)</div>
                                    </div>
                                </a>
                            </li>
 
                            
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
    <?php include("../includes/footer.php"); ?>
</body>
</html>