<?php 
    require_once(__DIR__ . "/../backend/services/PackServices.php");
    $pack_service = new PackServices();

    $pack_primaire = $pack_service->getPackByType("primaire");
    $pack_secondaire = $pack_service->getPackByType("secondaire");
    $pack_bac = $pack_service->getPackByType("bac");
    $pack_college = $pack_service->getPackByType("college");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packs</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/pack.css">
</head>
<body class="pack">
    
    <!-- include ll header -->
    <?php include("../includes/header.php");?>




    <div class="regulateur-header-imageContainer-espace">
        <div class="image-container boxwidth">
            <img src="../assets/images/pack/pack.png" alt="packs image">
            <div class="text">
                <h1>🎒Packs Scolaires Complets 2026</h1>
                <p>Trouvez le pack adapté a chaque niveau scolaire et economisez <span>jusqu'à 20%</span></p>
                <div class="button">
                    <a href="">Voir les Packs</a>
                    <a href="">Decouvrir Promotions</a>
                </div>
            </div>
        </div>
    </div>


    <div class="card-container boxwidth" >
        <div class="card">
            <img src="/assets/images/pack/calc.png" alt="">
            <h2>Primaire</h2>
            <a href="#pack-primaire"><span>Voir les packs</span> ⭢</a>
        </div>
        <div class="card">
            <img src="/assets/images/pack/palette.png" alt="">
            <h2>Collège</h2>
            <a href="#pack-college"><span>Voir les packs</span> ⭢</a>
        </div>
        <div class="card">
            <img src="/assets/images/pack/book.png" alt="">
            <h2>Secondaire</h2>
            <a href="#pack-secondaire"><span>Voir les packs</span> ⭢</a>
        </div>
        <div class="card">
            <img src="/assets/images/pack/hat.webp" alt="">
            <h2>Bac</h2>
            <a href="#pack-bac"><span>Voir les packs</span> ⭢</a>
        </div>
    </div>
    <!-- endof card part -->



    <!-- start of pack part -->
     <section class="packs-part boxwidth">

        <div class="pack-primaire packs-container" id="pack-primaire">
            <div class="text">
                <img src="../assets/images/pack/palette.png" alt="">
                <h2>Packs Primaire</h2>
            </div>
            <main>
                <?php foreach($pack_primaire as $pack): ?>
                    <article>
                        <div class="image">
                            <img src="<?= $pack["image_url"] ?>" alt="image d'un pack de fourniture scholaire en tunisie | Librairie Chebbi">
                        </div>
                        <div class="text-pack">
                            <h2>Pack primaire</h2>
                            <p><?= $pack_service->getNumberPackArticles($pack["id_produit"]); ?> articles</p>
                            <p class="price"><?= $pack["prix"] ?> Dt</p>
                        </div>
                        <div class="button-pack">
                            <a href="/packs/pack?idPack=<?= $pack["id_produit"] ?>">Voir Details</a>
                            <a href=""><i class="fa-solid fa-cart-arrow-down"></i> Ajouter au panier</a>
                        </div>
                    </article>
                <?php endforeach; ?>

            </main>
        </div>
        <!-- end of primary part -->




        <!-- colluege part  -->

        <div class="pack-college packs-container" id="pack-college">
            <div class="text">
                <img src="../assets/images/pack/palette.png" alt="">
                <h2>Packs Primaire</h2>
            </div>
            <main>
                <?php foreach($pack_college as $pack): ?>
                    <article>
                        <div class="image">
                            <img src="<?= $pack["image_url"] ?>" alt="image d'un pack de fourniture scholaire en tunisie | Librairie Chebbi">
                        </div>
                        <div class="text-pack">
                            <h2>Pack primaire</h2>
                            <p><?= $pack_service->getNumberPackArticles($pack["id_produit"]); ?> articles</p>
                            <p class="price"><?= $pack["prix"] ?> Dt</p>
                        </div>
                        <div class="button-pack">
                            <a href="/packs/pack?idPack=<?= $pack["id_produit"] ?>">Voir Details</a>
                            <a href=""><i class="fa-solid fa-cart-arrow-down"></i> Ajouter au panier</a>
                        </div>
                    </article>
                <?php endforeach; ?>

            </main>
        </div>









        <div class="pack-secondaire packs-container" id="pack-secondaire">
            <div class="text">
                <img src="../assets/images/pack/palette.png" alt="">
                <h2>Packs Primaire</h2>
            </div>
            <main>
                <?php foreach($pack_secondaire as $pack): ?>
                    <article>
                        <div class="image">
                            <img src="<?= $pack["image_url"] ?>" alt="image d'un pack de fourniture scholaire en tunisie | Librairie Chebbi">
                        </div>
                        <div class="text-pack">
                            <h2>Pack primaire</h2>
                            <p><?= $pack_service->getNumberPackArticles($pack["id_produit"]); ?> articles</p>
                            <p class="price"><?= $pack["prix"] ?> Dt</p>
                        </div>
                        <div class="button-pack">
                            <a href="/packs/pack?idPack=<?= $pack["id_produit"] ?>">Voir Details</a>
                            <a href=""><i class="fa-solid fa-cart-arrow-down"></i> Ajouter au panier</a>
                        </div>
                    </article>
                <?php endforeach; ?>

            </main>
        </div>







    <div class="pack-bac packs-container" id="pack-bac">
            <div class="text">
                <img src="../assets/images/pack/palette.png" alt="">
                <h2>Packs Primaire</h2>
            </div>
            <main>
                <?php foreach($pack_bac as $pack): ?>
                    <article>
                        <div class="image">
                            <img src="<?= $pack["image_url"] ?>" alt="image d'un pack de fourniture scholaire en tunisie | Librairie Chebbi">
                        </div>
                        <div class="text-pack">
                            <h2>Pack primaire</h2>
                            <p><?= $pack_service->getNumberPackArticles($pack["id_produit"]); ?> articles</p>
                            <p class="price"><?= $pack["prix"] ?> Dt</p>
                        </div>
                        <div class="button-pack">
                            <a href="/packs/pack?idPack=<?= $pack["id_produit"] ?>">Voir Details</a>
                            <a href=""><i class="fa-solid fa-cart-arrow-down"></i> Ajouter au panier</a>
                        </div>
                    </article>
                <?php endforeach; ?>

            </main>
        </div>


     </section>
     
    <?php include("../includes/footer.php"); ?>
</body>
</html>