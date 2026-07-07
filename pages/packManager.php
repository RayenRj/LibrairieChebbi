<?php
    require_once(__DIR__ . "/../backend/services/PackServices.php");
    require_once(__DIR__ . "/../backend/services/ProductServices.php");
    $packService = new PackServices();
    $prodService = new ProductServices();

    $page = $_GET["page"] ?? 1;
    $limit = $_GET["limit"] ?? 10;
    $niveau = $_GET["niveau"] ?? "";
    $statut = $_GET["statut"] ?? "";
    $nom_pack = $_GET["nom"] ?? "" ;
    $list_of_packs_filtred= $packService->recherchePack($nom_pack , $niveau , $statut , $limit , $page);

    $nombre_row_totale= $packService->nbreRowRecherchePack($nom_pack , $niveau , $statut , $limit , $page);

    $nombre_totale_page = ceil($nombre_row_totale / $limit);
    function calculDePourcentage($currentMonthValue , $lastMonthValue){
        $x = $currentMonthValue - $lastMonthValue;
        if($lastMonthValue==0){return 100;} 
        return ($x * 100)/$lastMonthValue;
    }

    // partie el add pack

    if(!isset($_SESSION["role"]) || $_SESSION["role"]!="admin"):
        header("Location: /main");
    else:

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/addPackPopUp.css">
    <link rel="stylesheet" href="../assets/css/packManager.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?>

    <div class="pack-manager">
        <section>
            <!-- Partie elli feha el text wl input ta3 el date -->
            <div class="top-part">
                <div class="text">
                    <h2>Pack Manager 📦</h2>
                    <p>Gérez vos packs : ajoutez , modifiez ou supprimez les packs disponibles</p>
                </div>
                <button class="btn-add" type="button" id="addPack"><span>+</span>Ajouter un pack</button>
            </div>  

            <!-- 4 cards  -->
            <div class="four-cards">

                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <div class="text">
                        <p>Total Packs</p>
                        <h3><?= $packService->totalPacks() ?></h3>
                        <p>
                            Le nombre totale de pack dans le stock
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div class="text">
                        <p>Packs Actifs</p>
                        <h3><?= $packService->totalPacksActifs() ?></h3>
                        <p>
                            Le nombre totale de packs actifs dans le stock
                        </p>
                    </div>
                </div>


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        
                    </div>
                    <div class="text">
                        <p>Packs En Repture</p>
                        <h3><?= $packService->totalPacksRepture() ?></h3>
                        <p>

                            Le nombre totale de packs en repture de stock
                        </p>
                    </div>
                </div>


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="text">
                        <p>Revenues Packs</p>
                        <h3><?= $packService->revenuePackCeMois() ?> DT</h3>
                        <p>
                            <?php if(calculDePourcentage($packService->revenuePackCeMois() , $packService->revenuePackDernierMois())>=0):?>
                            <span class="gain-effect">
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?= number_format(calculDePourcentage($packService->revenuePackCeMois() , $packService->revenuePackDernierMois()),2) ?>%
                            </span>
                            <?php else:?>
                                <span class="loss-effect">
                                    <i class="fa-solid fa-arrow-down"></i>
                                    <?= number_format(calculDePourcentage($packService->revenuePackCeMois() , $packService->revenuePackDernierMois()),2) ?>%
                                </span>
                            <?php endif;?>
                            vs le mois dernier
                        </p>
                    </div>
                </div>
            </div>


            <div class="packManagerBottomPart" id="packs">
                <form id="packManagerForm">
                    <div class="top">
                        <div>
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="nom" id="packSearch" placeholder="Rechercher un pack...">
                        </div>
                        <div>
                            <p>Niveau scolaire</p>
                            <div>
                                <select name="niveau" id="">
                                    <option value="" selected>Tous les Niveau</option>
                                    <option value="primaire" >Primaire</option>
                                    <option value="college" >Collège</option>
                                    <option value="secondaire" >Secondaire</option>
                                    <option value="bac" >Bac</option>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                        <div>
                            <p>Statut</p>
                            <div>
                                <select name="statut" id="">
                                    <option value="" selected>Tous</option>
                                    <option value="actif" >Actif</option>
                                    <option value="rupture" >En rupture</option>
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
                </form>



                <div class="table-part">
                    <table>
                        <thead>
                            <th>Image</th>
                            <th>Nom du pack</th>
                            <th>Niveau</th>
                            <th>Prix</th>
                            <th>Produits</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <?php foreach($list_of_packs_filtred as $index => $row): ?>
                        <tr>
                            <td>
                                <img src="https://www.agrafe.tn/4242-large_default/pochette-de-12-stylo-feutre-kids-bic.jpg" alt="">
                            </td>
                            <td>
                                <div class="text">
                                    <h5><?= $row["libelle"]; ?></h5>
                                    <p class="description"><?= $row["description"]; ?></p>
                                </div>
                            </td>

                            <td>
                                <?php switch($row["type"]){
                                    case "primaire" : echo "<span class='primaire' >primaire</span>";break;
                                    case "secondaire" : echo "<span class='secondaire' >Secondaire</span>";break;
                                    case "bac" : echo "<span class='bac' >Bac</span>";break;
                                    case "college" : echo " <span class='collège' >Collège</span>";break;
                                    default : break;
                                }?>
                            </td>
                            <td>
                                <p class="prix"><?= number_format($row["prix"] , 1)?> DT</p>
                            </td>
                            <td><?= $row["nbreArticleTotal"] ?> produits</td>
                            <td>
                                <?php if(intval($row["quantite_stock"]) > 0): ?>
                                    <span class="actif">
                                        <i class="fa-solid fa-circle"></i>Actif
                                    </span>
                                <?php else:?>
                                    <span class="repture">
                                        <i class="fa-solid fa-circle"></i>En repture
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <ul>
                                    <li><a href="" data-idPack="<?= $row["id_produit"]?>"><i class="fa-regular fa-eye"></i></a></li>
                                    <li><a href="" data-idPack="<?= $row["id_produit"]?>"><i class="fa-regular fa-pen-to-square"></i></a></li>
                                    <li><a href="" data-idPack="<?= $row["id_produit"]?>"><i class="fa-regular fa-trash-can"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <?php endforeach; ?>


                    </table>

                </div>


                <div class="bottom">
                    <p>Affichage de <?= (($page - 1) * $limit ) +1  ?> à <?= min((($page + 1) * $limit )  , $nombre_row_totale) ?> sur <?= $nombre_row_totale ?> packs</p>
                    <div class="pagination">
                        <!-- before -->
                        <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/dashboard/packs?page=<?= $i ?>#packs"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>
                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_totale_page) ; $i++):?>
                            <a href="/dashboard/packs?page=<?= $i ?>#packs"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nombre_totale_page - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>

            </div>
        </section>


    <form action="" class="addPackContainer" id="addPackForm" hidden enctype="multipart/form-data">
        <div class="popUpContainer">
            <div class="overlay"></div>
            <div class="popUpCard">
                <div class="popUpHead">
                    <h2>📦 Ajouer un Pack</h2>
                    <div id="closeButton">
                        <i class="fa-solid fa-x"></i>
                    </div>
                </div>
                <fieldset>
                <div class="triple">
                    <div>
                        <label>Libellé <span class="red">*</span></label>
                        <div>
                            <input type="text" name="libelle" id="" placeholder="Entrer le libellé de l'article" required>
                            <i class="fa-solid fa-tag"></i>
                        </div>
                    </div>
                    <div>
                        <label>Prix Unitaire <span class="red">*</span></label>
                        <div class="prixContainer">
                            <input type="text" name="prix" id="" placeholder="Entrer le prix" required>
                            <i class="fa-solid fa-dollar-sign"></i>
                            <span>DT</span>
                        </div>
                    </div>
                    <div>
                        <label>Quantité en stock <span class="red">*</span></label>
                        <div>
                            <input type="text" name="quantite_stock" id="" placeholder="Entrer la quantité" required> 
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>

                </div>


                <div class="triple">
                    <div>
                        <label>Remise (%)</label>
                        <div class="prixContainer">
                            <input type="number" name="remise" id="" placeholder="Entrer la remise en pourcentage">
                            <i class="fa-solid fa-percent"></i>
                            <span>DT</span>
                        </div>
                    </div>
                    <div>
                        <label>Type <span class="red">*</span></label>
                        <div>
                            <select id="categorie" name="type">
                                <option value="">-- Sélectionnez une le type --</option>
                                <option value="primaire">Primaire</option>
                                <option value="college">Collége</option>
                                <option value="secondaire">Secondaire</option>
                                <option value="bac">Bac</option>

                            </select>
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                    </div>

                </div>

                <div class="double">
                    <div class="single description">
                        <label for="">Description</label>
                        <div>
                            <textarea name="description" id="" placeholder="Entrez la description de l'article"></textarea>
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                    </div>
                    <div class="single">
                            <label for="">Image de l'article <span class="red">*</span></label>
                            <label class="custum-file-upload" for="file">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                                </div>
                                <div class="text">
                                    <span>Click to upload image</span>
                                </div>
                                <input type="file" name="packImage" id="file">
                        </label>

                    </div>
                </div>
                </fieldset>

                <fieldset>
                    <div class="heading">
                        <h3>Les Articles Selectionnées</h3>
                    </div>
                    <div class="top">
                        <div>
                            <p>Catégories </p>
                            <div>
                                <select name="" id="productCategorie">
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
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>
                        <div>
                            <p>Nom de l'article</p>
                            <div class="inputDiv">
                                <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                                <input type="text" name="" id="productLibelle" placeholder="Rechercher un article...">
                            </div>
                        </div>
                        <div>
                            <p>Prix Max (DT)</p>
                            <div class="inputDiv">
                                <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                                <input type="number" name="" id="productPrixMax" placeholder="Ex: 100.000">
                            </div>
                        </div>

                        <div>
                            <p>Stock </p>
                            <div>
                                <select name="" id="productStock">
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
                                <select name="" id="productTrie">
                                    <option value="" selected>-- None --</option>
                                    <option value="id article" >ID Article</option>
                                    <option value="libellé" >Libellé</option>
                                    <option value="prix unitaire" >Prix Unitaire</option>
                                    <option value="stock" >Stock</option>
                                    <option value="nombre de vente" >Nombre de vente</option>
                                </select>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>


                        <div>
                            <p>reglage</p>
                            <button type="button" id="bouttonRechercher">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                Rechercher
                            </button>
                        </div>
                        
                    </div>
                    <div class="tableContainer">
                        
                        <table id="addPackTable">
                            <thead>
                                <th>Article</th>
                                <th>Catégorie</th>
                                <th>Marque</th>
                                <th>Prix Unitaire</th>
                                <th>Stock</th>
                                <th>Quantité a ajouter</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="firstTablePopUpCard">
                                <!-- example of table row  -->
                                <!-- <tr>
                                    <td>
                                        <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                        <div class="text">
                                            <h4>Cahier 96 pages</h4>
                                            <p>Cah_96</p>
                                        </div>
                                    </td>
                                    <td>papeterie</td>
                                    <td>Kimia </td>
                                    <td>1,250 DT</td>
                                    <td>450</td>
                                    <td><input type="number" name="" id="" value="1"></td>
                                    <td><button class="confirmProduct" data-idProduit="1">Confirmé</button></td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>

                    <div class="bottom">
                        <div class="pagination">
                            <a href="" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                            <a href="" class="pagination-selected">1</a>
                            <a href="" >2</a>
                            <a href="" >3</a>
                            <a href="" >4</a>
                            <a href="">5</a>
                            <a href="" id="three-dots">...</a>
                            <a href="" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div>

                    <div class="articleSelectionne">
                        <div class="heading">
                            <h3>Les Articles Selectionnées</h3>
                        </div>
                        <div class="tableContainer">
                            
                            <table id="addPackTable">
                                <thead>
                                    <th>Article</th>
                                    <th>Catégorie</th>
                                    <th>Marque</th>
                                    <th>Prix Unitaire</th>
                                    <th>Stock</th>
                                    <th>Quantité</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="articleSelectionnéeTBody">
                                    <!-- exemple of table row -->
                                    <!-- <tr data-idProduit="id" class="articleSelectionner" data-quantity=5>
                                        <td>
                                            <img src="https://imgs.search.brave.com/YrXoOSIBI3dNT-8nmHwgFfrUVF5WlxJWR5dbNZJck3E/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tLm1l/ZGlhLWFtYXpvbi5j/b20vaW1hZ2VzL0kv/NzFZRGdYQXZFS0wu/anBn" alt="">
                                            <div class="text">
                                                <h4>Cahier 96 pages</h4>
                                                <p>Cah_96</p>
                                            </div>
                                        </td>
                                        <td>papeterie</td>
                                        <td>Kimia </td>
                                        <td>1,250 DT</td>
                                        <td>450</td>
                                        <td>5</td>
                                        <td><button class="deleteProduct" data-idProduit="1">Supprimée</button></td>
                                    </tr> -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <div class="last">
                    <input type="reset" id="reset" value="Reset">
                    <input type="submit" value="Ajouter Pack">
                </div>
            </div>
        </div>
    </form>










    </div>


    <script src="../assets/js/packManager.js"></script>
</body>
</html>

<?php endif;?>