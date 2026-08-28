<?php 
    require_once(__DIR__ . "/../backend/services/ProductServices.php");
    $product_service = new ProductServices();
    $libelle = isset($_GET["libelle"]) ? $_GET["libelle"] : "";
    $genre = isset($_GET["genre"]) ? $_GET["genre"] : "";
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $limit = isset($_GET["limit"]) ? $_GET["limit"] : 50;
    $gamesList = $product_service->getAllGames($libelle , $genre , $page , $limit);
    $today = new DateTime("today");
    $nombre_row_totale = $product_service->numberOfRowsAllGames($libelle , $genre);
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
    <title>Jouets | Librairie Chebbi</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/games.css">
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">

</head>
<body>
    <?php include("../includes/header.php"); ?>


    <div class="games">
        <div class="links">
            <a href="main.php">Acceuil</a>
            <i class="fa-solid fa-angle-right"></i>
            <a href="#">Jouer</a>

        </div>

        <div class="main-part">
            <div class="text">
                <p>Univers Jouets</p>
                <h1>Tous nos jouets <img src="../assets/images/jouet/effet1.png" alt=""></h1>
                <p>Découvrez notre collection complète de jouets éducatifs et ludiques</p>
            </div>
            <div class="img-part">
                <img src="../assets/images/jouet/first-backgroun.png" alt="">
                <img src="../assets/images/jouet/effet2.png" alt="" class="effect">
                <img src="../assets/images/jouet/effet2.png" alt="" class="effect">
                <img src="../assets/images/jouet/effet2.png" alt="" class="effect">
                <img src="../assets/images/jouet/effet3.png" alt="" class="effect">
                <img src="../assets/images/jouet/effet3.png" alt="" class="effect">
            </div>
            <div class="overlay"></div>
        </div>


        <div class="cards-container">
            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="text">
                    <h4>Educatif & Ludique</h4>
                    <p>Des Jouets pensées pour stimuler l'apprentissage en s'amusant</p>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <div class="text">
                    <h4>Cadeau Ideal</h4>
                    <p>Des Idées cadeaux parfaites pour toutes les occasions</p>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="text">
                    <h4>Qualité Garantie</h4>
                    <p>Des produits sélectionnées avec soin pour leur sécurité et leur qualité.</p>
                </div>
            </div>
        </div>


        <div class="partie-articles">
            <div class="header">
                <div>
                    <h1>Tous les Jouets</h1>
                    <p><?= $nombre_row_totale ?> produits</p>
                </div>
                <div>
                    <select name="genre" id="genre">
                        <option value="" selected>Tous les Jouets</option>
                        <option value="garcon">Garçon</option>
                        <option value="fille">Fille</option>
                        <option value="mixte">Mixte</option>
                    </select>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
            </div>

            <section class="article-container">
                <?php foreach($gamesList as $game): ?>
                    <?php $dataAjout = new DateTime($game["date_ajout"]); ?>
                    <article>
                        <a href="/products/product?idproduit=<?= $game["id_produit"] ?>">
                            <?php if($game["remise"] > 0): ?>
                                <span class="remise">Remise</span>
                            <?php elseif($game["quantite_stock"] == 0 ): ?>
                                <span class="repture" >repture de stock</span>
                            <?php elseif($today->diff($dataAjout)->days <= 2): ?>
                                <span class="new">Nouveau</span>
                            <?php endif; ?>
                            <img src="<?= $game["image_url"] ?>" alt="">
                            <h4><?= $game["libelle"] ?></h4>
                            <div class="rating">
                                <i class="fa-solid fa-star"></i>
                                <p class="rating-number">4.8</p>
                                <p class="number-of-poeple">(120)</p>
                            </div>
                            <h3 class="price"><?= number_format($game["prix"],3,","," ") ?> DT</h3>
                        </a>
                        <a href="" class="button addToCartBtn" data-idproduit ="<?= $game["id_produit"] ?>" data-name="<?= $game["libelle"] ?>" data-price="<?= $game["prix"] - $game["remise"] ?>" ?>
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
                            <a  href="/games?page=<?= $page - 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php else : ?>
                            <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php endif; ?>




                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/games?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#packs"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>



                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_totale_page) ; $i++):?>
                            <a href="/games?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#packs"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nombre_totale_page - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <?php if($page < $nombre_totale_page) : ?>
                            <a href="/games?page=<?= $page + 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php else : ?>
                             <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php endif; ?>
                    </div>

        </div>

    </div>
    <div id="toast-region"></div>




    <?php include("../includes/footer.php"); ?>
    <script src="/assets/js/games.js"></script>
    <script src="/assets/js/popUpAddToCart.js"></script>
</body>
</html>