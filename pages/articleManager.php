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
                    <h2>Article Manager 📚</h2>
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


    <form action="" class="popUpPart" hidden>
        <div class="popUpContainer">
            <div class="overlay"></div>
            <div class="popUpCard">
                <div class="popUpHead">
                    <h2>Ajouer un article</h2>
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
                            <input type="text" name="libelle" id="" placeholder="Entrer la quantité" required> 
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>
                </div>
                <div class="double">
                    <div>
                        <label>Categorie</label>
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
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                    </div>
                    <div>
                        <label>Marque</label>
                        <div>
                            <select name="marque" id="marque">
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
                        <input type="file" id="file">
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
    <script src="../assets/js/articleManager.js"></script>
</body>
</html>