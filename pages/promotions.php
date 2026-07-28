<?php
    require_once(__DIR__ . "/../backend/services/ProductServices.php");

    $productService = new ProductServices();
    $categorie = isset($_GET["categorie"]) ? $_GET["categorie"] : "";
    $libelle = isset($_GET["libelle"]) ? $_GET["libelle"] : "";
    $prixMax = isset($_GET["prixMax"]) ? floatval($_GET["prixMax"]) : 0;
    $prixMin = isset($_GET["prixMin"]) ? floatval($_GET["prixMin"]) : 0;
    $id = isset($_GET["id"]) ? $_GET["id"] : "";
    $marque = isset($_GET["marque"]) ? $_GET["marque"] : "";

    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
    $limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 10;


    $list_des_article_filtrée = $productService->rechercherArticle($categorie , $libelle ,$marque, $prixMax , $prixMin , "" , "" , $limit , $page);
    $nombre_de_ligne_list_des_article_filtrée = $productService->nombreLigneRechercherArticle($categorie , $libelle ,$marque, $prixMax , $prixMin , "" , "" , $limit , $page);

    $nombre_page_totale = intval(ceil($nombre_de_ligne_list_des_article_filtrée / $limit));
    
    
    $query_array= [];
    foreach($_GET as $key=>$val){
        if($key !== "page")
        $query_array[] = "$key=$val";
        
    } 
    $query_string = implode("&", $query_array) ?? "";




    if(!isset($_SESSION["role"]) || $_SESSION["role"]!="admin"):
        header("Location: /main");
    else:
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/commandeManager.css">
    <link rel="stylesheet" href="../assets/css/promotions.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?>

    <div class="promotion-manager">
        <section>
            <!-- Partie elli feha el text wl input ta3 el date -->
            <div class="top-part">
                <h2>Promotions 🏷️</h2>
                <p>Gérez les promotions de vos produits</p>
            </div>  

            <div class="PromotionManagerBottomPart">
                <form action="" id="promotionForm">
                    <div class="top">
                        <div>
                            <p>Recherche par Libellé</p>
                            <div>
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" name="libelle" id="packSearch" placeholder="Nom du produit...">
                            </div>
                        </div>

                        
                        <div>
                            <p>Categorie </p>
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

                        <div class="nbr">
                            <p>Prix max</p>
                            <div>
                                <input type="number" name="prixMax" id="">
                                <span>DT</span>
                            </div>
                        </div>

                        <div class="nbr">
                            <p>Prix min</p>
                            <div>
                                <input type="number" name="prixMin" id="">
                                <span>DT</span>
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
                </form>



                <div class="table-part">
                    <table>
                        <thead>
                            <th>ID Produit</th>
                            <th>Libellé</th>
                            <th>Prix (DT)</th>
                            <th>Ancient Promotion (DT)</th>
                            <th>Cout de promotion (DT)</th>
                            <th>Actions</th>
                        </thead>
                        <!--el <p> hne just reglage ll font size -->
                        <form action="">
                            <tbody>
                                <?php foreach($list_des_article_filtrée as $article): ?>
                            
                                <tr>
                                    <td><p>#PRD_<?= $article["id_produit"] ?></p></td>
                                    <td><p><?= $article["libelle"] ?></p></td>
                                    <td><p><?= number_format($article["prix"],3,"," , " ") ?></p></td>
                                    <td><p><?= $article["remise"] ?></p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a class="confirmerButton" href="#" data-idproduit=<?= $article["id_produit"] ?>><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>
                                <?php endforeach; ?>


                            </tbody>
                        
                        
                        </form>
                    </table>
                </div>


                <!-- el partie eli feha el pagination -->
                <div class="bottom">
                    <p>Affichage de <?= (($page - 1) * $limit ) +1  ?> à <?= min($page * $limit  , $nombre_de_ligne_list_des_article_filtrée) ?> sur <?= $nombre_de_ligne_list_des_article_filtrée ?> commandes</p>
                    <div class="pagination">
                        <!-- before -->
                        <?php if($page > 1) : ?>
                            <a  href="/dashboard/promotions?page=<?= $page - 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php else : ?>
                            <a href="#formFiltrage" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php endif; ?>


                        
                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/dashboard/promotions?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>
                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_page_totale) ; $i++):?>
                            <a href="/dashboard/promotions?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#formFiltrage"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nombre_page_totale - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <?php if($page < $nombre_page_totale) : ?>
                            <a href="/dashboard/promotions?page=<?= $page + 1 ?>#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php else : ?>
                             <a href="#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php endif; ?>

                    </div>
                </div>














            </div>
        </section>
    </div>

    <script src="/assets/js/promotions.js"></script>
</body>
</html>


<?php endif;?>