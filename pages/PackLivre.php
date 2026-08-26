<?php
  require_once(__DIR__ . "/../backend/services/ProductServices.php");
  require_once(__DIR__ . "/../backend/services/PackServices.php");
  $service = new ProductServices();
  $service_pack = new PackServices();


  $libelle = isset($_GET["libelle"]) ? $_GET["libelle"] : "";
  $niveau = isset($_GET["niveau"]) ? $_GET["niveau"] : "";
  $page = isset($_GET["page"]) ? $_GET["page"] : 1;
  $limit = isset($_GET["limit"]) ? $_GET["limit"] : 16;
  $annee = isset($_GET["anneeScolaire"]) ? $_GET["anneeScolaire"] : "";


  $pack_list = $service_pack->getPackLivre($annee);
  $liste_livre = $service->findLivreScolaire($libelle , $niveau , $limit , $page);
  $nombre_row_totale = $service->numberOfLinesfindLivreScolaire($libelle ,$niveau);

    $nombre_totale_page = ceil($nombre_row_totale / $limit);


    // getting the query element chaque fois
    $query_array= [];
    foreach($_GET as $key=>$val){
        if($key !== "page")
        $query_array[] = "$key=$val";
        
    } 
    $query_string = implode("&", $query_array) ?? "";

  // Information : ne9sa torbet partie el repository bl services w t implementi el be9i fl php


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livre scolaire | Librairie Chebbi</title>
  <link rel="stylesheet" href="/assets/css/packLivre.css">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
  />
</head>
<body>
    <?php include(__DIR__ . "/../includes/header.php"); ?>


  <section>
    <div class="topPart">
      <div class="text">
        <h2>Packs De Livres scolaires</h2>
        <p>Choisissez l'année scolaire pour découvrir les packs de livres correspondants.</p>
      </div>
      <div>
        <select name="anneeScolaire" class="anneeScolaire"></select>
        <button type="submit" class="submitButtonTop">
            <i class="fa-solid fa-magnifying-glass"></i>
            Rechercher
        </button>
      </div>
    </div>

    <div class="article-list">
      <?php foreach($pack_list as $pack): ?>
        <div class="box">
          <div class="containerBackFlip">
              <div class="face">
                <img src="<?= $pack["image_url"] ?>" alt="" class="packImage">
                
                </div>
                <div class="back">
                  <article>
                    <a href="/packs/pack?idPack=<?=$pack["id_pack"] ?>">
                    <img src="/assets/images/Designes/packLivre3.png" alt="">
                    <h4><?= $pack["libelle"] ?></h4>
                    <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> <?= $pack["quantite_stock"] ?> Packs disponibles</p>
                    <div class="last">
                      <p class="prix"><?= number_format($pack["prix"],3,",", " ") ?> DT</p>
                      <button type="button" data-idproduit="<?= $pack["id_pack"] ?>" class="addToCartBtn" data-name="<?= $pack["libelle"] ?>" data-price="<?= $pack["prix"] ?>"><i class="fa-solid fa-cart-plus"></i></button>
                    </div>  
                  </a>
                </article>
              </div>
          </div>
        </div>
      <?php endforeach; ?>

      
    </div>
  </section>

    

  <section>
    <div class="topPart partTwo" id="livres">
      <div class="text">
        <h2>Tous les livres</h2>
        <p>Découvrez notre collection compléte de livres scolaires .</p>
      </div>
      <form action="" id="formLivre">
      <div>
        <input type="text" name="libelle" id="" placeholder="libellé du livre..." value="<?= isset($_GET["libelle"]) ? $_GET["libelle"] : "" ?>">
        <select name="niveau" class="anneeScolaire" >
          <option value="">-- Sélectionnez une année --</option>
        </select>
        <button type="submit" class="submitButton">
            <i class="fa-solid fa-magnifying-glass"></i>
            Rechercher
        </button>
      </div>
      </form>
    </div>

    <div class="article-list">
      <?php foreach($liste_livre as $parascolaire): ?>
        <article>
          <a href="/products/product?idproduit=<?= $parascolaire["id_produit"] ?>">
            <img src="<?= $parascolaire["image_url"] ?>" alt="">
            <h4><?= $parascolaire["libelle"] ?></h4>
            <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> <?= $parascolaire["quantite_stock"] ?> Packs disponibles</p>
            <div class="last">
              <p class="prix"><?= number_format($parascolaire["prix"], 3 , "," ," ") ?> DT</p>
              <button type="button" data-idproduit="<?= $parascolaire["id_produit"] ?>"  class="addToCartBtn" data-name="<?= $parascolaire["libelle"] ?>" data-price="<?= $parascolaire["prix"] ?>"><i class="fa-solid fa-cart-plus"></i></button>
            </div>
          </a>
        </article>
      <?php endforeach; ?>
      
    </div>
    <!-- partie eli feha pagination -->
                <div class="bottom">
                    <div class="pagination">
                        <!-- before -->
                        <?php if($page > 1) : ?>
                            <a  href="/packs/livres?page=<?= $page - 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#livres" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php else : ?>
                            <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php endif; ?>



                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/packs/livres?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#livres"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>
                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_totale_page) ; $i++):?>
                            <a href="/packs/livres?page=<?= $i ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#livres"><?= $i ?></a>
                        <?php endfor; ?> 
                        
                        <!-- three dots after -->
                        <?php if(($nombre_totale_page - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <?php if($page < $nombre_totale_page) : ?>
                            <a href="/packs/livres?page=<?= $page + 1 ?><?= $query_string !== "" ? "&" . $query_string : "" ?>#livres" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php else : ?>
                             <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                        <?php endif; ?>

                    </div>
    </section>




  <?php include(__DIR__ . "/../includes/footer.php"); ?>
  <div id="toast-region"></div>
  <script src="/assets/js/packLivre.js"></script>
  <script src="/assets/js/popUpAddToCart.js"></script>
</body>
</html>