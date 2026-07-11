<?php
    require_once(__DIR__ . "/../backend/services/ProductServices.php");

    $product_services = new ProductServices();


    $categorie = isset($_GET["categorie"]) ? $_GET["categorie"] : "";
    $libelle = isset($_GET["libelle"]) ? $_GET["libelle"] : "";
    $prixMax = isset($_GET["prixMax"]) ? floatval($_GET["prixMax"]) : 0;
    $prixMin = isset($_GET["prixMin"]) ? floatval($_GET["prixMin"]) : 0;
    $trie = isset($_GET["trie"]) ? $_GET["trie"] : "";
    $stock = isset($_GET["stock"]) ? $_GET["stock"] : "";
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
    $limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 15;

    $liste_des_produit= $product_services->rechercherArticle($categorie , $libelle , $prixMax , $prixMin , $stock , $trie , $limit , $page);
    $nombre_de_produit = $product_services->nombreLigneRechercherArticle($categorie , $libelle , $prixMax , $prixMin , $stock , $trie , $limit , $page);
    $nombre_page_totale = intval(ceil($nombre_de_produit / $limit));


    $query_array= [];
    foreach($_GET as $key=>$val){$query_array[] = "$key=$val";} 
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
</head>
<body>
    <?php include "../includes/header.php" ?>
    <section>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                    <div>
                        <div>
                            <input type="range" name="" id="range1" value="0" step="10">

                        </div>
                        <div>
                            <div><span>0</span> <span>dt</span></div>
                            -
                            <div><span>50</span> <span>dt</span></div>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                                        <label class="checkBox">
                                            <input id="ch1" type="checkbox" checked>
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
                            <label class="checkBox">
                                <input id="ch1" type="checkbox" checked>
                                <div class="transition"></div>
                            </label>
                        </div>
                        en stock uniquement
                        <!-- <label for="ch1"> En stock uniquement</label> -->
                    </div>
                </div>
            </form>
        </aside>



        <main>
            <div class="information">
                <p>Affichage de <?= (($page - 1) * $limit ) +1  ?> à <?= min($page * $limit  , $nombre_de_produit) ?> sur <?= $nombre_de_produit ?> Articles</p>
                <div>
                    Trier par 
                    <select name="" id="">
                        <option value="" selected>none</option>
                        <option value="">Popularity</option>
                        <option value="">prix</option>
                        <option value="">nom</option>
                        <option value="">type</option>
                    </select>
                </div>
            </div>

            <!--phase des articles-->
            <div class="articles">
                <?php foreach($liste_des_produit as $product):?>
                    <article>
                        <a href="/products/product?idproduit=<?= $product["id_produit"] ?>">
                            <div class="image">
                                <img src="<?=  $product["image_url"] ?>" alt=""> 
                                <!-- <img src="https://www.alkirtas.com/65769-large_default/stylo-bille-bic-cristal-soft-pochette-de-10.jpg" alt=""> -->
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <p class="title">
                                <?= $product["libelle"] ?>
                            </p>
                            <p class="price">
                                <?= $product["prix"] ?> Dt
                            </p>
                        </a>
                        <button class="addCartButton" data-idproduit ="<?= $product["id_produit"] ?>"><span>🛒</span> Ajouter au panier</button>
                    </article>
                <?php endforeach; ?>
            </div>



                <!-- el partie eli feha el pagination -->
                <div class="bottom">
                    <div class="pagination">
                        <!-- before -->
                        <?php if($page > 1) : ?>
                            <a  href="/products?page=<?= $page - 1 ?>#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php else : ?>
                            <a href="#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php endif; ?>


                        
                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/products?page=<?= $i ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>
                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_page_totale) ; $i++):?>
                            <a href="/products?page=<?= $i ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nombre_page_totale - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <?php if($page < $nombre_page_totale) : ?>
                            <a href="/products?page=<?= $page + 1 ?>#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php else : ?>
                             <a href="#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php endif; ?>

                    </div>
                </div>
        </main>
    </section>

    <?php include("../includes/footer.php"); ?>

    <script src="/assets/js/allProductScript.js"></script>
</body>
</html>