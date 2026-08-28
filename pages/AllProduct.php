<?php

use function PHPSTORM_META\type;

    require_once(__DIR__ . "/../backend/services/ProductServices.php");

    $product_services = new ProductServices();


    $categorie = isset($_GET["categorie"]) ? $_GET["categorie"] : "";
    $libelle = isset($_GET["libelle"]) ? $_GET["libelle"] : "";
    $prixMax = isset($_GET["prixMax"]) ? floatval($_GET["prixMax"]) : 0;
    $prixMin = isset($_GET["prixMin"]) ? floatval($_GET["prixMin"]) : 0;
    $trie = isset($_GET["trie"]) ? $_GET["trie"] : "";
    $marque = isset($_GET["marque"]) ? $_GET["marque"] : "";
    $stock = isset($_GET["stock"]) ? $_GET["stock"] : "";
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
    $limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 15;
    $liste_des_produit= $product_services->rechercherArticle($categorie , $libelle ,$marque, $prixMax , $prixMin , $stock , $trie , $limit , $page);
    $nombre_de_produit = $product_services->nombreLigneRechercherArticle($categorie , $libelle ,$marque, $prixMax , $prixMin , $stock , $trie , $limit , $page);
    $nombre_page_totale = intval(ceil($nombre_de_produit / $limit));

    $today = new DateTime("today");
    $query_array= [];
    foreach($_GET as $key=>$val){
        if($key!=="page"){
            $query_array[] = "$key=$val";
        }
    } 
    $query_string = implode("&", $query_array) ?? "";

    $list_of_categories= $product_services->getAllCategorie();
    $list_of_ = $product_services->getAllMarque();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fournitures Scholaire | Librairie Chebbi</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <!-- <link rel="stylesheet" href="/librairie/LibrairieChebbi/assets/css/output.css">
    <link rel="stylesheet" href="/librairie/LibrairieChebbi/assets/css/allProduct.css"> -->
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="../assets/css/allProduct.css">
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">
</head>
<body>
    <?php include "../includes/header.php" ?>
    <section>
        <span class="responsiveAside"></span>
        <aside>
            <form action="">
                <div class="filter">
                    <div class="heading">
                        <div>
                            <i class="fa-solid fa-sliders"></i>
                            <h3>Filtres</h3>
                        </div>
                        <div>
                            <input type="reset" name="" id="" value="Reinistialiser">
                        </div>
                    </div>
                </div>

                <div class="category">
                    <div class="heading">
                        <div>
                            <i class="fa-solid fa-layer-group"></i>
                            <h3>Catégories</h3>
                        </div>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                    <div class="list-categorie list">
                        <ul>
                            <li>
                                <div> 
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="ecriture">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Écriture
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="papeterie">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Papeterie
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="classement">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Classement
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="geometrie">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Géométrie
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="coupe et collage">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Coupe et collage
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="dessin et arts">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Dessin et arts
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="Sac">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Sacs et accessoires
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="calcul et sciences"> 
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Calcul et sciences
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="numerique">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Numérique
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="livres pedagogiques"> 
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Livres pédagogiques
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="fournitures de bureau">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Fournitures de bureau
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="autres">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Others
                                </div>
                                <span class="number-product">35</span>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="prix">
                    <div class="heading">
                        <div>
                            <i class="fa-solid fa-dollar-sign"></i>
                            <h3>Prix</h3>
                        </div>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                    <div class="prixContentContainer">
                        <div>
                            <span class="prixHeading">Prix Max</span>
                            <div>
                                <input type="range" max="200" name="" id="range1" value="0" step="0.5">
                                <div class="prixInput">
                                    <span contenteditable="true" max="200" id="prixMax">0</span> <span>Dt</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="prixHeading">Prix Min</span>
                            <div>
                                <input type="range" name="" id="range2" value="0" step="0.5">
                                <div class="prixInput">
                                    <span contenteditable="true" id="prixMin">0</span> <span> Dt</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="marque">
                    <div class="heading">
                        <div>
                            <i class="fa-solid fa-tag"></i>
                            <h3>Marque</h3>
                        </div>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                    <div class="list-marque list">
                        <ul>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="bic">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    BIC
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="maped">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Maped
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="stabilo">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Stabilo
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="faber-castell">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Faber-Castell
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="staedtler">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Staedtler
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="pilot">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Pilot
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="pelikan">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Pelikan
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="carioca">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Carioca
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="schneider">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Schneider
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="milan">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Milan
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="jovi">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Jovi
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="canson">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    Canson
                                </div>
                                <span class="number-product">35</span>
                            </li>
                            <li>
                                <div>
                                    <div class="content">
                                        <label class="checkBoxLabel">
                                            <input id="ch1" type="checkbox" checked value="autres">
                                            <div class="transition"></div>
                                        </label>
                                    </div>
                                    other
                                </div>
                                <span class="number-product">35</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="disponibility">
                    <div class="heading">
                        <div>
                            <i class="fa-brands fa-font-awesome"></i>
                            <h3>Disponibilité</h3>
                        </div>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                    <div>
                        <div class="content">
                            <label class="checkBoxLabel">
                                <input id="stockCheck" type="checkbox" checked>
                                <div class="transition"></div>
                            </label>
                            en stock uniquement
                        </div>
                        <!-- <label for="ch1"> En stock uniquement</label> -->
                    </div>
                    <button type="button" id="buttonFiltrer">
                       Filtrer 
                    </button>

                    
                </div>
            </form>
        </aside>



        <main>
            <div class="information">
                <p>Affichage de <?= (($page - 1) * $limit ) +1  ?> à <?= min($page * $limit  , $nombre_de_produit) ?> sur <?= $nombre_de_produit ?> Articles</p>
                <div class="trieDiv">
                    Trier par 
                    <select name="" id="trie">
                        <option value="" selected>none</option>
                        <option value="libellé">libellé</option>
                        <option value="marque">marque</option>
                        <option value="prix unitaire">prix unitaire</option>
                        <!-- <option value="stock">stock</option> -->
                    </select>
                </div>
                <button class="filterButton"><i class="fa-solid fa-sliders"></i> Filtrer</button>
            </div>

            <?php if(empty($liste_des_produit)): ?>
                <div class="emptyContainer">
                    <img src="/assets/images/noproduct.png" alt="">
                    <h2>Aucun produit trouvé</h2>
                    <p>Désolé, aucun produit ne correspond à votre recherche ou à votre sélection pour le moment</p>
                    <button><i class="fa-solid fa-magnifying-glass"></i>Voir tous les produit</button>
                </div>

            <?php else:?>
            <!--phase des articles-->
            <div class="articles">
                <?php foreach($liste_des_produit as $product):?>
                    <?php $dataAjout = new DateTime($product["date_ajout"]); ?>
                    <article>

                        <a href="/products/product?idproduit=<?= $product["id_produit"] ?>">
                            <?php if($product["remise"] > 0): ?>
                                <span class="remise">Remise</span>
                            <?php elseif($product["quantite_stock"] == 0 ): ?>
                                <span class="repture" >repture de stock</span>
                            <?php elseif($today->diff($dataAjout)->days <= 2): ?>
                                <span class="new">Nouveau</span>
                            <?php endif; ?>

                            <div class="image">
                                <img src="<?=  $product["image_url"] ?>" alt=""> 
                                <!-- <img src="https://www.alkirtas.com/65769-large_default/stylo-bille-bic-cristal-soft-pochette-de-10.jpg" alt=""> -->
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <p class="title">
                                <?= $product["libelle"] ?>
                            </p>
                            <?php if($product["remise"] > 0): ?>
                            <div class="priceDiscount">
                                <p class="prixPartieDiscount">
                                    <?= $product["prix"] - $product["remise"] ?> Dt
                                </p>
                                <p class="prixOriginal"><?= $product["prix"] ?> Dt</p>
                            </div>
                            <?php else: ?>
                            <p class="price">
                                <?= $product["prix"] ?> Dt
                            </p>
                            <?php endif; ?>
                        </a>
                        <button class="addCartButton addToCartBtn" data-idproduit ="<?= $product["id_produit"] ?>" data-name="<?= $product["libelle"] ?>" data-price="<?= $product["prix"] - $product["remise"] ?>"><span>🛒</span> Ajouter au panier</button>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php endif;?>

                <!-- el partie eli feha el pagination -->
                <div class="bottom">
                    <div class="pagination">
                        <!-- before -->
                        <?php if($page > 1) : ?>
                            <a  href="/products?page=<?= $page - 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php else : ?>
                            <a href="#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php endif; ?>


                        
                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/products?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>
                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_page_totale) ; $i++):?>
                            <a href="/products?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nombre_page_totale - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <?php if($page < $nombre_page_totale) : ?>
                            <a href="/products?page=<?= $page + 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php else : ?>
                             <a href="#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php endif; ?>

                    </div>
                </div>
        </main>
    </section>
    <div id="toast-region"></div>
    <?php include("../includes/footer.php"); ?>
    <script src="/assets/js/allProductScript.js"></script>
    <script src="/assets/js/popUpAddToCart.js"></script>
</body>
</html>