<?php 
    require_once __DIR__ . "/../backend/repository/StatisticsRepository.php";
    $statRepo = new StatisticsRepository(); 
    $currentMonth = intval(date("m"));
    $currentYear = intval(date("Y"));
    $lastMonth = intval(date("m" , strtotime("-1 month")));
    $lastMonthYear = intval(date("m" , strtotime("-1 month")));
    
    $topArticlesVendues = $statRepo->topArticlesVendues(4);
    $liste_article_en_repture_stock = $statRepo->ArticleEnReptureStock();
    function calculDePourcentage($currentMonthValue , $lastMonthValue){
        $x = $currentMonthValue - $lastMonthValue;
        if($lastMonthValue==0){return 100;} 
        return ($x * 100)/$lastMonthValue;
    }

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
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?>

    <div class="dashboard">
        <section>
            <!-- Partie elli feha el text wl input ta3 el date -->
            <div class="top-part">
                <div class="text">
                    <h2>Bonjour Admin 👋🏼</h2>
                    <p>Voici un apercu de votre Boutique aujourd'hui <?= $currentYear ?></p>
                </div>

                <!--<div class="input">
                    <input type="date" name="" id="">
                        <i class="fa-regular fa-calendar"></i>
                    <i class="fa-solid fa-caret-down"></i>
                </div>-->

            </div>  

            <!-- 4 cards  -->
            <div class="four-cards">

                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="text">
                        <p>Total Commandes</p>
                        <h3><?= $statRepo->TotaleCommande($currentMonth ,$currentYear); ?></h3>
                        <p>
                            
                            <span class="gain-effect">
                                <i class="fa-solid fa-arrow-down"></i>
                                <!-- <i class="fa-solid fa-arrow-up" hidden></i> -->
                                <?= calculDePourcentage($statRepo->TotaleCommande($currentMonth ,$currentYear) , $statRepo->TotaleCommande($lastMonth ,$lastMonthYear)); ?>%
                            </span>
                            vs le mois dernier
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-money-bills"></i>
                    </div>
                    <div class="text">
                        <p>Chiffre d'affaires</p>
                        <h3><?= number_format($statRepo->ChiffreAffaire($currentMonth,$currentYear), 0 , ".") ?> DT</h3>
                        <p>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up"  hidden></i>
                                <?= calculDePourcentage($statRepo->ChiffreAffaire($currentMonth, $currentYear) ,$statRepo->ChiffreAffaire($lastMonth, $lastMonthYear) );  ?>%
                           
                            </span>
                            vs le mois dernier
                        </p>
                    </div>
                </div>


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-box-open"></i>
                        
                    </div>
                    <div class="text">
                        <p>Packs Vendus</p>
                        <h3><?= $statRepo->PackVendu($currentMonth , $currentYear) ?></h3>
                        <p>
                            <span class="gain-effect"> 
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?= calculDePourcentage($statRepo->PackVendu($currentMonth, $currentYear) ,$statRepo->PackVendu($lastMonth, $lastMonthYear) );  ?>%
                            </span>
                            vs le mois dernier
                        </p>
                    </div>
                </div>


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div class="text">
                        <p>Utilisateurs</p>
                        <h3><?= $statRepo->NbreOfUser(); ?></h3>
                        <p>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" ></i>
                                12.5%
                            </span>
                            vs le mois dernier
                        </p>
                    </div>
                </div>
            </div>


            <!--  Evolution de vente -->
            <div class="top-chart">
                <div class="left">
                    <h3>évolution des ventes</h3>
                    <canvas id="evolution_vente"></canvas>
                </div>

                <div class="right">
                    <div class="top-part">
                        <h3>Commandes récentes</h3>
                        <a href="CommandesManager.php">Voir toutes <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <table>
                        <tr>
                            <td >#CMD-1058</td>
                            <td >Yassine Ben Ali</td>
                            <td >Pack Secondaire</td>
                            <td>
                                <span class="livree">Livrée</span>
                                <!-- <span class="en_cours">En cours</span> -->
                                <!-- <span class="en_attente">En attente</span> -->
                                <!-- <span class="annulee">Annulé</span> -->
                            </td>
                            <td>30/05/2024</td>
                            <td>159Dt</td>
                        </tr>
                        <tr>
                            <td >#CMD-1058</td>
                            <td >Yassine Ben Ali</td>
                            <td >Pack Secondaire</td>
                            <td>
                                <!-- <span class="livree">Livrée</span> -->
                                <span class="en_cours">En cours</span>
                                <!-- <span class="en_attente">En attente</span> -->
                                <!-- <span class="annulee">Annulé</span> -->
                            </td>
                            <td>30/05/2024</td>
                            <td>159Dt</td>
                        </tr>
                        <tr>
                            <td >#CMD-1058</td>
                            <td >Yassine Ben Ali</td>
                            <td >Pack Secondaire</td>
                            <td>
                                <!-- <span class="livree">Livrée</span> -->
                                <!-- <span class="en_cours">En cours</span> -->
                                <span class="en_attente">En attente</span>
                                <!-- <span class="annulee">Annulé</span> -->
                            </td>
                            <td>30/05/2024</td>
                            <td>159Dt</td>
                        </tr>
                        <tr>
                            <td >#CMD-1058</td>
                            <td >Yassine Ben Ali</td>
                            <td >Pack Secondaire</td>
                            <td>
                                <!-- <span class="livree">Livrée</span> -->
                                <!-- <span class="en_cours">En cours</span> -->
                                <!-- <span class="en_attente">En attente</span> -->
                                <span class="annulee">Annulé</span>
                            </td>
                            <td>30/05/2024</td>
                            <td>159Dt</td>
                        </tr>
                        <tr>
                            <td >#CMD-1058</td>
                            <td >Yassine Ben Ali</td>
                            <td >Pack Secondaire</td>
                            <td>
                                <!-- <span class="livree">Livrée</span> -->
                                <!-- <span class="en_cours">En cours</span> -->
                                <span class="en_attente">En attente</span>
                                <!-- <span class="annulee">Annulé</span> -->
                            </td>
                            <td>30/05/2024</td>
                            <td>159Dt</td>
                        </tr>
                        <tr>
                            <td >#CMD-1058</td>
                            <td >Yassine Ben Ali</td>
                            <td >Pack Secondaire</td>
                            <td>
                                <!-- <span class="livree">Livrée</span> -->
                                <!-- <span class="en_cours">En cours</span> -->
                                <span class="en_attente">En attente</span>
                                <!-- <span class="annulee">Annulé</span> -->
                            </td>
                            <td>30/05/2024</td>
                            <td>159Dt</td>
                        </tr>
                    </table>
                </div>

            </div>

            <div class="bottom-chart">
                <div class="pie">
                    <h3>Ventes des packs</h3>
                    <div>
                        <div class="chart">
                            <canvas id="pie-chart"></canvas>
                            <div class="text">
                                <h4>Total</h4>
                                <h2 id="total_pack_vente"><?= $statRepo->totaleVenteDePack() ?></h2>
                            </div>
                        </div>
                        <ul class="legend">
                                <li>
                                    <h5>Primaire</h5>
                                    <p>52% (589)</p>
                                </li>
                                <li>
                                    <h5>Collége</h5>
                                    <p>52% (589)</p>
                                </li>
                                <li>
                                    <h5>Secondaire</h5>
                                    <p>52% (589)</p>
                                </li>
                                <li>
                                    <h5>Bac</h5>
                                    <p>52% (589)</p>
                                </li>
                        </ul>

                        
                    </div>
                </div>



                <div class="top-article">
                    <div class="top-part">
                        <h3>Top Articles Vendues</h3>
                        <!-- <a href="">Voir toutes <i class="fa-solid fa-arrow-right"></i></a> -->
                    </div>
                    <ul class="articles">
                        <?php foreach($topArticlesVendues as $product): ?>
                            <li>
                                <div>
                                    <img src="<?= $product["image_url"] ?>" alt="image de l'article">
                                    <div class="text">
                                        <h5><?= $product["libelle"] ?></h5>
                                        <p class="nbre-vente"><?= $product["quantite_total"] ?> ventes</p>
                                    </div>
                                </div>
                                <p class="prix"><?= number_format($product["prix"],2,",") ?> Dt</p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>


                <div class="article-repture">
                    <div class="top-part">
                        <div>
                            <h3>Articles en repture de stock</h3>
                            <span>12 Produits</span>
                        </div>
                        <a href="/dashboard/articles?stock=repture%20de%20stock#formFiltrage">Voir toutes <i class="fa-solid fa-arrow-right"></i></a>
                    </div>

                    <ul>
                        <li>
                            <div>
                            <img src="https://spacenet.tn/302029-large_default/sac-a-dos-scolaire-gris.jpg" alt="">
                            <h5>Sac à dos avengers</h5>
                            </div>
                            <div>
                                <span class="zero">0</span>
                                <span class="presque-zero" hidden>5</span>
                            </div>
                            <div class="buttons">
                                <a href="">Reapprovisionner</a>
                                <a href="">Supprimer</a>
                            </div>
                        </li>
                        <li>
                            <div>
                            <img src="https://spacenet.tn/302029-large_default/sac-a-dos-scolaire-gris.jpg" alt="">
                            <h5>Sac à dos avengers</h5>
                            </div>
                            <div>
                                <span class="zero" hidden>0</span>
                                <span class="presque-zero" >5</span>
                            </div>
                            <div class="buttons">
                                <a href="">Reapprovisionner</a>
                                <a href="">Supprimer</a>
                            </div>
                        </li>
                        <li>
                            <div>
                            <img src="https://spacenet.tn/302029-large_default/sac-a-dos-scolaire-gris.jpg" alt="">
                            <h5>Sac à dos avengers</h5>
                            </div>
                            <div>
                                <span class="zero">0</span>
                                <span class="presque-zero" hidden>5</span>
                            </div>
                            <div class="buttons">
                                <a href="">Reapprovisionner</a>
                                <a href="">Supprimer</a>
                            </div>
                        </li>
                        <li>
                            <div>
                            <img src="https://spacenet.tn/302029-large_default/sac-a-dos-scolaire-gris.jpg" alt="">
                            <h5>Sac à dos avengers</h5>
                            </div>
                            <div>
                                <span class="zero">0</span>
                                <span class="presque-zero" hidden>5</span>
                            </div>
                            <div class="buttons">
                                <a href="">Reapprovisionner</a>
                                <a href="">Supprimer</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>