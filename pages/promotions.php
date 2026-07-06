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
                <div class="top">

                    <div>
                        <p>Recherche par Identifiat</p>
                        <div>
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="packSearch" id="packSearch" placeholder="Identifiant du produit...">
                        </div>
                    </div>
                    <div>
                        <p>Recherche par nom</p>
                        <div>
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="libelle" id="packSearch" placeholder="Nom du produit...">
                        </div>
                    </div>

                    
                    <div>
                        <p>Categorie </p>
                        <div>
                            <select name="" id="">
                                <option value="all" selected>Stylo</option>
                                <option value="all" >Packs</option>
                                <option value="all" >Sac à dos</option>
                                <option value="all" >Cahier</option>
                                <option value="all" >Livre</option>
                            </select>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                    </div>

                    <div class="nbr">
                        <p>Prix max</p>
                        <div>
                            <input type="number" name="" id="">
                            <span>DT</span>
                        </div>
                    </div>

                    <div class="nbr">
                        <p>Prix min</p>
                        <div>
                            <input type="number" name="" id="">
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

                            
                                <tr>
                                    <td><p>#PRD_1058</p></td>
                                    <td><p>Sac à dos Avengers</p></td>
                                    <td><p>129.000</p></td>
                                    <td><p>0</p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a href=""><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>
                                <tr>
                                    <td><p>#PRD_1058</p></td>
                                    <td><p>Sac à dos Avengers</p></td>
                                    <td><p>129.000</p></td>
                                    <td><p>0</p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a href=""><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>
                                <tr>
                                    <td><p>#PRD_1058</p></td>
                                    <td><p>Sac à dos Avengers</p></td>
                                    <td><p>129.000</p></td>
                                    <td><p>0</p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a href=""><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>
                                <tr>
                                    <td><p>#PRD_1058</p></td>
                                    <td><p>Sac à dos Avengers</p></td>
                                    <td><p>129.000</p></td>
                                    <td><p>0</p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a href=""><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>
                                <tr>
                                    <td><p>#PRD_1058</p></td>
                                    <td><p>Sac à dos Avengers</p></td>
                                    <td><p>129.000</p></td>
                                    <td><p>0</p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a href=""><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>
                                <tr>
                                    <td><p>#PRD_1058</p></td>
                                    <td><p>Sac à dos Avengers</p></td>
                                    <td><p>129.000</p></td>
                                    <td><p>0</p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a href=""><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>
                                <tr>
                                    <td><p>#PRD_1058</p></td>
                                    <td><p>Sac à dos Avengers</p></td>
                                    <td><p>129.000</p></td>
                                    <td><p>0</p></td>
                                    <td><input type="number" name="" id="" placeholder="Ex: 99.000"></td>
                                    <td><a href=""><i class="fa-regular fa-circle-check"></i> Confirmer</a></td>
                                </tr>

                            </tbody>
                        
                        
                        </form>
                    </table>
                </div>


                <div class="bottom">
                    <p>Affichage de 1 à 6 sur 125 produits</p>
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