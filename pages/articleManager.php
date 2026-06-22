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
                    <h2>Article Manager 📚</h2>
                    <p>Gérez vos articles : ajoutez , modifiez ou supprimez les articles disponibles</p>
                </div>
                <button>
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
                        <h3>1,248</h3>
                        <p>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" hidden></i>
                                12.5%
                            </span>
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
                        <h3>2,356</h3>
                        <a href="" class="cardLink">Voir la liste</a>
                    </div>
                </div>


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </div>
                    <div class="text">
                        <p>Article jamais vendus</p>
                        <h3>3,892</h3>
                        <a href="" class="cardLink">Voir la liste</a>
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
                            <ul>
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

            <div class="articleManagerBottomPart">
                <div class="top">
                    <div>
                        <p>Catégories </p>
                        <div>
                            <select name="" id="">
                                <option value="all" selected>Toutes les Catégories</option>
                                <option value="all" >Telephone</option>
                                <option value="all" >Prix</option>
                                <option value="all" >Email</option>
                                <option value="all" >Id Commande</option>
                            </select>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </div>
                    <div>
                        <p>Nom de l'article</p>
                        <div class="inputDiv">
                            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                            <input type="text" name="packSearch" id="packSearch" placeholder="Rechercher un article...">
                        </div>
                    </div>
                    <div>
                        <p>Prix Max (DT)</p>
                        <div class="inputDiv">
                            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                            <input type="number" name="packSearch"  placeholder="Ex: 100.000">
                        </div>
                    </div>

                    <div>
                        <p>Stock </p>
                        <div>
                            <select name="" id="">
                                <option value="all" selected>Tous</option>
                                <option value="all" >Stock élevé</option>
                                <option value="all" >Stock Moyen</option>
                                <option value="all" >Stock Faible</option>
                                <option value="all" >Repture de stock</option>
                            </select>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </div>
                    <div>
                        <p>Trié par</p>
                        <div>
                            <select name="" id="">
                                <option value="all" selected>ID Article</option>
                                <option value="all" >Libellé</option>
                                <option value="all" >Prix Unitaire</option>
                                <option value="all" >Stock</option>
                                <option value="all" >Nombre de vente</option>
                            </select>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </div>


                    <div>
                        <p>reglage</p>
                        <button type="reset">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Rechercher
                        </button>
                    </div>
                    
                </div>



                <div class="table-part">
                    <table>
                        <thead>
                            <th>ID Article </th>
                            <th>Libellé</th>
                            <th>Prix Unitaire (DT)</th>
                            <th>Stock</th>
                            <th>Nbre Vente</th>
                            <th>Actions</th>
                        </thead>
                        <!--el <p> hne just reglage ll font size -->
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#PRD_1058</p></td>
                            <td><p>Sac à dos Avengers</p></td>
                            <td><p>129.000</p></td>
                            <td><p>25</p></td>
                            <td><p>152</p></td>

                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>


                    </table>

                </div>


                <div class="bottom">
                    <p>Affichage de 1 à 6 sur 125 packs</p>
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
                </div>













            </div>



            <!-- partie eli feha 2 tableaux -->

            <div class="twoList">
                <div class="ListOne">
                    <h3>Top 10 des articles les plus vendus ce mois</h3>
                    <table>
                        <thead>
                            <th>Rang</th>
                            <th>Article</th>
                            <th>Catégorie</th>
                            <th>Ventes</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>🥇</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>🥈</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>🥉</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                            </tr>

                        </tbody>
                    </table>
                </div>




                <div class="ListTwo">
                    <h3>Articles à faible rotation ce mois</h3>
                    <table>
                        <thead>
                            <th>Article</th>
                            <th>Catégorie</th>
                            <th>Stock</th>
                            <th>Ventes</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Sac à dos spiderMan</td>
                                <td>Sac</td>
                                <td>152</td>
                                <td>0</td>
                            </tr>

                    </table>
                </div>



                
            </div>

            <div class="statStock">
                <h2>Statistiques du stock</h2>
                <div class="cardContainer">
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Stock élevé</h5>
                            <h2>120 produits</h2>
                            <p>(plus de 20 en stock)</p>
                        </div>
                    </div>
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Stock Moyen</h5>
                            <h2>120 produits</h2>
                            <p>(entre 6 et 20 en stock)</p>
                        </div>
                    </div>
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Stock Faible</h5>
                            <h2>120 produits</h2>
                            <p>(entre 1 et 5 en stock)</p>
                        </div>
                    </div>
                    <div>
                        <i class="fa-solid fa-box-open"></i>
                        <div class="text">
                            <h5>Repture de Stock</h5>
                            <h2>120 produits</h2>
                            <p>(0 en stock)</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/articleManager.js"></script>
</body>
</html>