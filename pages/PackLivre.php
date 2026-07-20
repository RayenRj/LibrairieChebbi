<?php
  include_once(__DIR__ . "/../backend/services/ProductServices.php");
  $service_product = new ProductServices();

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
        <!-- remplissage avec js -->
      </div>
    </div>

    <div class="article-list">

      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      
      
    </div>
  </section>

    

  <section>
    <div class="topPart partTwo">
      <div class="text">
        <h2>Tous les livres</h2>
        <p>Découvrez notre collection compléte de livres scolaires .</p>
      </div>
      <div>
        <input type="text" name="libelle" id="" placeholder="libellé du livre...">
        <select name="anneeScolaire" class="anneeScolaire" >
          <option value="">-- Sélectionnez une année --</option>
        </select>
        <button type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
            Rechercher
        </button>
      </div>
    </div>

    <div class="article-list">

      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      <article>
        <img src="/assets/images/Designes/packLivre.png" alt="">
        <h4>1ére Année Primaire</h4>
        <p class="nombreDisponible"><i class="fa-solid fa-bag-shopping"></i> 5 Packs disponibles</p>
        <div class="last">
          <p class="prix">3.500 DT</p>
          <button type="button"><i class="fa-solid fa-cart-plus"></i></button>
        </div>
      </article>
      
      
    </div>
            <div class="pagination">
                <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                <a href="#" class="pagination-selected">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#" id="three-dots">...</a>
                <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
            </div>
  </section>




  <?php include(__DIR__ . "/../includes/footer.php"); ?>
  <script src="/assets/js/packLivre.js"></script>
</body>
</html>