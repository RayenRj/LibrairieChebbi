<?php
    require_once(__DIR__ . "/../backend/services/ProductServices.php");
    
    $productService = new ProductServices();
    function calculDePourcentage($currentMonthValue , $lastMonthValue){
        $x = $currentMonthValue - $lastMonthValue;
        if($lastMonthValue==0){return 100;} 
        return ($x * 100)/$lastMonthValue;
    }

    $categorie = isset($_GET["categorie"]) ? $_GET["categorie"] : "";
    $libelle = isset($_GET["libelle"]) ? $_GET["libelle"] : "";
    $prixMax = isset($_GET["prixMax"]) ? floatval($_GET["prixMax"]) : 0;
    $prixMin = isset($_GET["prixMin"]) ? floatval($_GET["prixMin"]) : 0;
    $trie = isset($_GET["trie"]) ? $_GET["trie"] : "";
    $stock = isset($_GET["stock"]) ? $_GET["stock"] : "";
    $marque = isset($_GET["marque"]) ? $_GET["marque"] : "";
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
    $limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 10;

    // prix min dima 0
    $list_des_article_filtrée = $productService->rechercherArticle($categorie , $libelle ,$marque, $prixMax , $prixMin , $stock , $trie , $limit , $page);
    $nombre_de_ligne_list_des_article_filtrée = $productService->nombreLigneRechercherArticle($categorie , $libelle ,$marque, $prixMax , $prixMin , $stock , $trie , $limit , $page);

    $nombre_page_totale = intval(ceil($nombre_de_ligne_list_des_article_filtrée / $limit));
    
    
    $query_array= [];
    foreach($_GET as $key=>$val){
        if($key !== "page")
        $query_array[] = "$key=$val";
        
    } 
    $query_string = implode("&", $query_array) ?? "";

    $top_10_vente_list = $productService->Top10Ventes();
    $article_faible_rotation_list = $productService->ArticleAfaibleRotation();


    if(!isset($_SESSION["role"]) || $_SESSION["role"]!="admin"):
        header("Location: /main");
    else:

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Manager</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />

    
    <link rel="stylesheet" href="../assets/css/articleManagerPopUp.css">
    <link rel="stylesheet" href="../assets/css/articleManager.css">
    
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?> 

    <div class="articleManager">
        <section>
            <!-- Partie elli feha el text wl input ta3 el date -->
            <div class="top-part">
                <div class="text">
                    <h2>Article Manager 📚 </h2>
                    <p>Gérez vos articles : ajoutez , modifiez ou supprimez les articles disponibles</p>
                </div>
                <button id="addArticle">
                    <i class="fa-solid fa-plus"></i>Ajouter un article
                </button>
            </div>  

            <!-- 4 cards  -->
            <div class="four-cards">

                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="text">
                        <p>Total Articles Vendus</p>
                        <h3><?= $productService->venteCeMois(); ?></h3>
                        <p>
                            <?php if(calculDePourcentage($productService->venteCeMois() ,$productService->venteDernierMois() ) >= 0): ?>
                            <span class="gain-effect">
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?= number_format(calculDePourcentage($productService->venteCeMois() ,$productService->venteDernierMois()),1)?> %
                            </span>
                            <?php else: ?>
                            <span class="loss-effect">
                                <i class="fa-solid fa-arrow-down"></i>
                                <?= number_format( calculDePourcentage($productService->venteCeMois() ,$productService->venteDernierMois() ),1) ?> %
                            </span>
                            <?php endif; ?>
                            vs le mois dernier
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="icon">
                        <i class="fa-regular fa-circle-xmark"></i>
                    </div>
                    <div class="text">
                        <p>Article en repture</p>
                        <h3><?= $productService->nbreArticleEnRepture(); ?></h3>
                        <a href="/dashboard/articles?stock=repture%20de%20stock#formFiltrage" class="cardLink">Voir la liste</a>
                    </div>
                </div>


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </div>
                    <div class="text">
                        <p>Article jamais vendus</p>
                        <h3><?= $productService->nbreArticleNonVendus() ?></h3>
                        <a href="#articleDeFaibleRotation" class="cardLink">Voir la liste</a>
                    </div>
                </div>
            </div>


            <!--  Evolution de vente : 2 charts (bars + pie) -->
            <div class="top-chart">
                <!-- bars chart  -->
                <div class="left">
                    <h3>Ventes par mois</h3>
                    <canvas id="chart1"></canvas>
                </div>
                <!-- pie chart  -->
                <div class="right">
                    <h3>Répartition des ventes par catégories</h3>
                    <div>
                        <div>
                            <canvas id="chart2"></canvas>
                        </div>
                        <div>
                            <ul class="firstList chartList">
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Écriture</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Papeterie</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Géométrie</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                            </ul>
                            <ul class="lastList chartList">
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                                <li>
                                    <p><i class="fa-solid fa-circle"></i> Chaiers</p>
                                    <p>35%</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            

            <div class="articleManagerBottomPart" id="articleManagerBottomPart">
                <!-- El partie eli feha filtrage -->
                <form action="" id="formFiltrage" enctype="multipart/form-data">
                    <div class="top">
                        <h2>Liste De Tous Les Articles</h2>
                        <div>
                            <div>
                                <p>Catégories</p>
                                <div>
                                    <select id="categorie" name="categorie">
                                        <option value="">-- Sélectionnez une catégorie --</option>
                                        <option value="ecriture">Écriture</option>
                                        <option value="papeterie">Papeterie</option>
                                        <option value="classement">Classement</option>
                                        <option value="geometrie">Géométrie</option>
                                        <option value="coupe_collage">Coupe et collage</option>
                                        <option value="dessin_arts">Dessin et arts</option>
                                        <option value="sacs_accessoires">Sacs et accessoires</option>
                                        <option value="calcul_sciences">Calcul et sciences</option>
                                        <option value="numerique">Numérique</option>
                                        <option value="livres_pedagogiques">Livres pédagogiques</option>
                                        <option value="fournitures_bureau">Fournitures de bureau</option>
                                        <option value="others">Others</option>
                                    </select>
                                    <i class="fa-solid fa-caret-down"></i>
                                </div>
                            </div>
                            <div>
                                <p>Nom de l'article</p>
                                <div class="inputDiv">
                                    <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                                    <input type="text" name="libelle" id="packSearch" placeholder="Rechercher un article...">
                                </div>
                            </div>
                            <div>
                                <p>Prix Max (DT)</p>
                                <div class="inputDiv">
                                    <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                                    <input type="number" name="prixMax"  placeholder="Ex: 100.000">
                                </div>
                            </div>

                            <div>
                                <p>Stock </p>
                                <div>
                                    <select name="stock" id="">
                                        <option value="" selected>-- Tous --</option>
                                        <option value="stock eleve" >Stock élevé</option>
                                        <option value="stock moyen" >Stock Moyen</option>
                                        <option value="stock faible" >Stock Faible</option>
                                        <option value="repture de stock" >Repture de stock</option>
                                    </select>
                                    <i class="fa-solid fa-caret-down"></i>
                                </div>
                            </div>
                            <div>
                                <p>Trié par</p>
                                <div>
                                    <select name="trie" id="">
                                        <option value="" selected>-- Trie --</option>
                                        <option value="id article">ID Article</option>
                                        <option value="libellé" >Libellé</option>
                                        <option value="prix unitaire" >Prix Unitaire</option>
                                        <option value="stock" >Stock</option>
                                        <option value="nombre de vente" >Nombre de vente</option>
                                    </select>
                                    <i class="fa-solid fa-caret-down"></i>
                                </div>
                            </div>


                            <div class="lastDiv">
                                <div>
                                    <p>reglage</p>
                                    <button type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        Rechercher
                                    </button>
                                </div>

                                <div>
                                    <p>reglage</p>
                                    <button type="reset">
                                        <i class="fa-solid fa-rotate"></i>
                                        Réinitialiser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- El partie eli feha el table Part -->
                <div class="table-part">
                    <table>
                        <thead>
                            <th>ID Article </th>
                            <th>Libellé</th>
                            <th>Prix Unitaire (DT)</th>
                            <th>Remise (DT)</th>
                            <th>Stock</th>
                            <th>Nbre Vente</th>
                            <th>Actions</th>
                        </thead>
                        <!--el <p> hne just reglage ll font size -->
                        <?php foreach($list_des_article_filtrée as $row): ?>
                        <tr>
                            <td><p><?= $row["id_produit"] ?></p></td>
                            <td><p><?= $row["libelle"] ?></p></td>
                            <td><p><?= $row["prix"]?> <small>DT</small></p></td>
                            <td><p><?= $row["remise"]?> <small>DT</small></p></td>
                            <td><p><?= $row["quantite_stock"] ?></p></td>
                            <td><p><?= $row["remise"] ?></p></td>
                            <td>
                                <ul>
                                    <a href="/products/product?idproduit=<?= $row["id_produit"] ?>"><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a class="deleteArticleButton" data-idproduit="<?= $row["id_produit"] ?>"><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </table>

                </div>

                <!-- el partie eli feha el pagination -->
                <div class="bottom">
                    <p>Affichage de <?= (($page - 1) * $limit ) +1  ?> à <?= min($page * $limit  , $nombre_de_ligne_list_des_article_filtrée) ?> sur <?= $nombre_de_ligne_list_des_article_filtrée ?> commandes</p>
                    <div class="pagination">
                        <!-- before -->
                        <?php if($page > 1) : ?>
                            <a  href="/dashboard/articles?page=<?= $page - 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php else : ?>
                            <a href="#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php endif; ?>


                        
                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/dashboard/articles?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>
                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_page_totale) ; $i++):?>
                            <a href="/dashboard/articles?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nombre_page_totale - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <?php if($page < $nombre_page_totale) : ?>
                            <a href="/dashboard/commandes?page=<?= $page + 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php else : ?>
                             <a href="#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php endif; ?>

                    </div>
                </div>












            </div>



            <!--  partie eli feha stock -->
            <div class="statStock">
                <h2>Statistiques du stock</h2>
                <div class="cardContainer">
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Stock élevé</h5>
                            <h2><?= $productService->stockElevee() ?> produits</h2>
                            <p>(plus de 20 en stock)</p>
                        </div>
                    </div>
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Stock Moyen</h5>
                            <h2><?= $productService->stockMoyen() ?> produits</h2>
                            <p>(entre 6 et 20 en stock)</p>
                        </div>
                    </div>
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Stock Faible</h5>
                            <h2><?= $productService->stockFaible() ?> produits</h2>
                            <p>(entre 1 et 5 en stock)</p>
                        </div>
                    </div>
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Repture de Stock</h5>
                            <h2><?= $productService->nbreArticleEnRepture() ?> produits</h2>
                            <p>(0 en stock)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- partie eli feha 2 tableaux -->

            <div class="twoList">

                <div class="ListOne">
                    <h3>Top 10 des articles les plus vendus</h3>
                    <table>
                        <thead>
                            <th>Rang</th>
                            <th>Article</th>
                            <th>Catégorie</th>
                            <th>Ventes</th>
                        </thead>
                        <tbody>
                            <?php foreach($top_10_vente_list as $index=>$article): ?>
                            <tr>
                                <?php if($index==0): ?>
                                <td>🥇</td>
                                <?php elseif($index==1): ?>
                                <td>🥈</td>
                                <?php elseif($index==2): ?>
                                <td>🥉</td>
                                <?php else:?>
                                <td><?= $index + 1 ?></td>
                                <?php endif; ?>
                                <td><?= $article["libelle"] ?></td>
                                <td><?= $article["categorie"] ?></td>
                                <td><?= $article["quantite_total"] ?></td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>


                <div class="ListTwo" id="articleDeFaibleRotation">
                    <h3>Articles à faible rotation</h3>
                    <table>
                        <thead>
                            <th>Article</th>
                            <th>Catégorie</th>
                            <th>Stock</th>
                            <th>Ventes</th>
                        </thead>
                        <tbody>
                            <?php foreach($article_faible_rotation_list as $product): ?>
                            <tr>
                                <td><?= $product["libelle"] ?></td>
                                <td><?= $product["categorie"] ?></td>
                                <td><?= $product["quantite_stock"] ?></td>
                                <td><?= $product["venteTotale"] ?></td>
                            </tr>
                            <?php endforeach; ?>
                    </table>
                </div>



                
            </div>



        </section>
        
    </div>


    <form action="" class="popUpPart" method="POST" enctype="multipart/form-data" id="addArticleForm" hidden>
        <div class="popUpContainer">
            <div class="overlay"></div>
                <div class="popUpCard">
                    <div class="popUpHead">
                        <h2>Ajouter un article</h2>
                        <a id="popUpClose">
                            <i class="fa-solid fa-x"></i>
                        </a>
                    </div>

                    <div class="double">
                        <div>
                            <label>Code à barre</label>
                            <div>
                                <input type="text" name="codeBarre" id="" placeholder="Entrer le code a barre" >
                                <i class="fa-solid fa-barcode"></i>
                            </div>
                        </div>
                        <div>
                            <label>Libellé</label>
                            <div>
                                <input type="text" name="libelle" id="" placeholder="Entrer le libellé de l'article" required>
                                <i class="fa-solid fa-tag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="double">
                        <div>
                            <label>Prix Unitaire</label>
                            <div>
                                <input type="text" name="prix" id="" placeholder="Entrer le prix" required>
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div>
                            <label>Quantité</label>
                            <div>
                                <input type="text" name="quantity" id="" placeholder="Entrer la quantité" required> 
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                        </div>
                    </div>
                    <div class="double">
                        <div>
                            <label>Categorie</label>
                            <div>
                                <select id="categorie" class="selectCategoriePopUp" name="categorie" required>
                                    <option value="">-- Sélectionnez une catégorie --</option>
                                    <option value="ecriture">Écriture</option>
                                    <option value="papeterie">Papeterie</option>
                                    <option value="classement">Classement</option>
                                    <option value="geometrie">Géométrie</option>
                                    <option value="coupe_collage">Coupe et collage</option>
                                    <option value="dessin_arts">Dessin et arts</option>
                                    <option value="sac">Sacs et accessoires</option>
                                    <option value="calcul_sciences">Calcul et sciences</option>
                                    <option value="numerique">Numérique</option>
                                    <option value="livres_pedagogiques">Livres pédagogiques</option>
                                    <option value="parascolaire">Parascolaire</option>
                                    <option value="jouet">jouet</option>
                                    <option value="panier">Panier</option>
                                    <option value="trousse">Trousse</option>
                                    <option value="fournitures_bureau">Fournitures de bureau</option>
                                    <option value="others">Others</option>
                                </select>
                                <i class="fa-regular fa-folder-open"></i>
                            </div>
                        </div>

                        <div>
                            <label>Marque</label>
                            <div>
                                <select name="marque" id="marque" required>
                                    <option value="">-- Choisir une marque --</option>
                                    <option value="BIC">BIC</option>
                                    <option value="Maped">Maped</option>
                                    <option value="Stabilo">Stabilo</option>
                                    <option value="Faber-Castell">Faber-Castell</option>
                                    <option value="Staedtler">Staedtler</option>
                                    <option value="Pilot">Pilot</option>
                                    <option value="Pelikan">Pelikan</option>
                                    <option value="Carioca">Carioca</option>
                                    <option value="Schneider">Schneider</option>
                                    <option value="Milan">Milan</option>
                                    <option value="Jovi">Jovi</option>
                                    <option value="Canson">Canson</option>
                                    <option value="Oxford">Oxford</option>
                                    <option value="Clairefontaine">Clairefontaine</option>
                                    <option value="Exacompta">Exacompta</option>
                                    <option value="Rhodia">Rhodia</option>
                                    <option value="Paper Mate">Paper Mate</option>
                                    <option value="Sharpie">Sharpie</option>
                                    <option value="Uni-ball">Uni-ball</option>
                                    <option value="Edding">Edding</option>
                                    <option value="Linc">Linc</option>
                                    <option value="Royal Talens">Royal Talens</option>
                                    <option value="Folio">Folio</option>
                                    <option value="Canon">Canon</option>
                                    <option value="Dymo">Dymo</option>
                                    <option value="Costo">Costo</option>
                                    <option value="KO">KO</option>
                                    <option value="Ruspina">Ruspina</option>
                                    <option value="Sildar">Sildar</option>
                                    <option value="other">other</option>
                                </select>
                                <i class="fa-brands fa-mizuni"></i>
                            </div>
                        </div>
                    </div>
                        <div class="singleGenre">
                            <label for="">Dediée pour</label>
                            <select name="genre" id="genre">
                                <option value="" selected>-- Choisir le genre --</option>
                                <option value="mixte">Mixte</option>
                                <option value="garcon">Garçon</option>
                                <option value="fille">Fille</option>
                            </select>
                        </div>
                    
                    <div class="singleAnneeParascolaireLivre">
                        <label for="">Choisir L'année Scolaire</label>
                        <select name="anneeScolaire" id="anneeScolaire"></select>
                    </div>
                    <div class="singleCollectionParascolaire">
                        <label for="">Choisir la Collection</label>
                        <select name="collection" id="collection_parascolaire"></select>
                    </div>
                    <div class="single">
                        <label for="">Remise (%)</label>
                        <div>
                            <input type="number" name="remise" id="" placeholder="Entrer la remise en pourcentage">
                            <i class="fa-solid fa-percent"></i>
                            <span>DT</span>
                        </div>
                    </div>
                    <div class="single description">
                        <label for="">Description</label>
                        <div>
                            <textarea name="description" id="" placeholder="Entrez la description de l'article"></textarea>
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                    </div>
                    <!-- Partie image -->
                    <div class="single">
                            <label for="">Image de l'article</label>
                            <label class="custum-file-upload" for="file">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                            </div>
                            <div class="text">
                                <span>Click to upload image</span>
                            </div>
                            <input type="file" name="image" id="file">
                        </label>

                    </div>

                    <!-- Buttonss -->
                    <div class="last">
                        <input type="reset" id="resetButton" value="Reset">
                        <input type="submit" value="Ajouter l'article">
                    </div>
                </div>
        </div>
    </form>





    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/articleManager.js"></script>
</body>
</html>


<?php endif;?>