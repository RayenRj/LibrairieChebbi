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
                <button class="btn-add"><span>+</span>Ajouter un pack</button>
            </div>  

            <!-- 4 cards  -->
            <div class="four-cards">

                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <div class="text">
                        <p>Total Packs</p>
                        <h3>18</h3>
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
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div class="text">
                        <p>Packs Actifs</p>
                        <h3>95</h3>
                        <p>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up"  hidden></i>
                                12.5%
                            </span>
                            vs le mois dernier
                        </p>
                    </div>
                </div>


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        
                    </div>
                    <div class="text">
                        <p>Packs En Repture</p>
                        <h3>12</h3>
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


                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="text">
                        <p>Revenues Packs</p>
                        <h3>3,892 DT</h3>
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


            <div class="packManagerBottomPart">
                <div class="top">
                    <div>
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="packSearch" id="packSearch" placeholder="Rechercher un pack...">
                    </div>
                    <div>
                        <p>Niveau scolaire</p>
                        <div>
                            <select name="" id="">
                                <option value="all" selected>Tous les Niveau</option>
                                <option value="all" >Primaire</option>
                                <option value="all" >Collège</option>
                                <option value="all" >Secondaire</option>
                                <option value="all" >Bac</option>
                            </select>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </div>
                    <div>
                        <p>Statut</p>
                        <div>
                            <select name="" id="">
                                <option value="all" selected>Tous les Niveau</option>
                                <option value="all" >Primaire</option>
                                <option value="all" >Collège</option>
                                <option value="all" >Secondaire</option>
                                <option value="all" >Bac</option>
                            </select>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </div>
                    <div>
                        <p>reglage</p>
                        <button type="reset">
                            <i class="fa-solid fa-arrow-rotate-left"></i>
                             Réinitialiser
                        </button>
                    </div>
                    
                </div>



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

                        <tr>
                            <td>
                                <img src="https://www.agrafe.tn/4242-large_default/pochette-de-12-stylo-feutre-kids-bic.jpg" alt="">
                            </td>
                            <td>
                                <div class="text">
                                    <h5>Pack Primaire Standard</h5>
                                    <p class="description">Pack complet pour les éleves du primaire</p>
                                </div>
                            </td>

                            <td>
                                <span class="primaire" hidden>primaire</span>
                                <span class="secondaire" hidden>Secondaire</span>
                                <span class="collège" hidden>Collège</span>
                                <span class="bac" >Bac</span>
                            </td>
                            <td>
                                <p class="prix">59 DT</p>
                            </td>
                            <td>12 produits</td>
                            <td>
                                <span class="actif">
                                    <i class="fa-solid fa-circle"></i>Actif
                                </span>
                                <!-- <span class="repture">
                                    <i class="fa-solid fa-circle"></i>En repture
                                </span> -->
                            </td>
                            <td>
                                <ul>
                                    <li><a href=""><i class="fa-regular fa-eye"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-pen-to-square"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-trash-can"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.agrafe.tn/4242-large_default/pochette-de-12-stylo-feutre-kids-bic.jpg" alt="">
                            </td>
                            <td>
                                <div class="text">
                                    <h5>Pack Primaire Standard</h5>
                                    <p class="description">Pack complet pour les éleves du primaire</p>
                                </div>
                            </td>

                            <td>
                                <span class="primaire" hidden>primaire</span>
                                <span class="secondaire" hidden>Secondaire</span>
                                <span class="collège" hidden>Collège</span>
                                <span class="bac" >Bac</span>
                            </td>
                            <td>
                                <p class="prix">59 DT</p>
                            </td>
                            <td>12 produits</td>
                            <td>
                                <span class="actif">
                                    <i class="fa-solid fa-circle"></i>Actif
                                </span>
                                <!-- <span class="repture">
                                    <i class="fa-solid fa-circle"></i>En repture
                                </span> -->
                            </td>
                            <td>
                                <ul>
                                    <li><a href=""><i class="fa-regular fa-eye"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-pen-to-square"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-trash-can"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.agrafe.tn/4242-large_default/pochette-de-12-stylo-feutre-kids-bic.jpg" alt="">
                            </td>
                            <td>
                                <div class="text">
                                    <h5>Pack Primaire Standard</h5>
                                    <p class="description">Pack complet pour les éleves du primaire</p>
                                </div>
                            </td>

                            <td>
                                <span class="primaire" hidden>primaire</span>
                                <span class="secondaire" hidden>Secondaire</span>
                                <span class="collège" >Collège</span>
                                <span class="bac" hidden>Bac</span>
                            </td>
                            <td>
                                <p class="prix">59 DT</p>
                            </td>
                            <td>12 produits</td>
                            <td>
                                <!-- <span class="actif">
                                    <i class="fa-solid fa-circle"></i>Actif
                                </span> -->
                                <span class="repture">
                                    <i class="fa-solid fa-circle"></i>En repture
                                </span>
                            </td>
                            <td>
                                <ul>
                                    <li><a href=""><i class="fa-regular fa-eye"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-pen-to-square"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-trash-can"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.agrafe.tn/4242-large_default/pochette-de-12-stylo-feutre-kids-bic.jpg" alt="">
                            </td>
                            <td>
                                <div class="text">
                                    <h5>Pack Primaire Standard</h5>
                                    <p class="description">Pack complet pour les éleves du primaire</p>
                                </div>
                            </td>

                            <td>
                                <span class="primaire" hidden>primaire</span>
                                <span class="secondaire" hidden>Secondaire</span>
                                <span class="collège" hidden>Collège</span>
                                <span class="bac" >Bac</span>
                            </td>
                            <td>
                                <p class="prix">59 DT</p>
                            </td>
                            <td>12 produits</td>
                            <td>
                                <span class="actif">
                                    <i class="fa-solid fa-circle"></i>Actif
                                </span>
                                <!-- <span class="repture">
                                    <i class="fa-solid fa-circle"></i>En repture
                                </span> -->
                            </td>
                            <td>
                                <ul>
                                    <li><a href=""><i class="fa-regular fa-eye"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-pen-to-square"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-trash-can"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.agrafe.tn/4242-large_default/pochette-de-12-stylo-feutre-kids-bic.jpg" alt="">
                            </td>
                            <td>
                                <div class="text">
                                    <h5>Pack Primaire Standard</h5>
                                    <p class="description">Pack complet pour les éleves du primaire</p>
                                </div>
                            </td>

                            <td>
                                <span class="primaire" hidden>primaire</span>
                                <span class="secondaire" hidden>Secondaire</span>
                                <span class="collège" hidden>Collège</span>
                                <span class="bac" >Bac</span>
                            </td>
                            <td>
                                <p class="prix">59 DT</p>
                            </td>
                            <td>12 produits</td>
                            <td>
                                <span class="actif">
                                    <i class="fa-solid fa-circle"></i>Actif
                                </span>
                                <!-- <span class="repture">
                                    <i class="fa-solid fa-circle"></i>En repture
                                </span> -->
                            </td>
                            <td>
                                <ul>
                                    <li><a href=""><i class="fa-regular fa-eye"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-pen-to-square"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-trash-can"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.agrafe.tn/4242-large_default/pochette-de-12-stylo-feutre-kids-bic.jpg" alt="">
                            </td>
                            <td>
                                <div class="text">
                                    <h5>Pack Primaire Standard</h5>
                                    <p class="description">Pack complet pour les éleves du primaire</p>
                                </div>
                            </td>

                            <td>
                                <span class="primaire" hidden>primaire</span>
                                <span class="secondaire" hidden>Secondaire</span>
                                <span class="collège" hidden>Collège</span>
                                <span class="bac" >Bac</span>
                            </td>
                            <td>
                                <p class="prix">59 DT</p>
                            </td>
                            <td>12 produits</td>
                            <td>
                                <span class="actif">
                                    <i class="fa-solid fa-circle"></i>Actif
                                </span>
                                <!-- <span class="repture">
                                    <i class="fa-solid fa-circle"></i>En repture
                                </span> -->
                            </td>
                            <td>
                                <ul>
                                    <li><a href=""><i class="fa-regular fa-eye"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-pen-to-square"></i></a></li>
                                    <li><a href=""><i class="fa-regular fa-trash-can"></i></a></li>
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
        </section>
    </div>

</body>
</html>