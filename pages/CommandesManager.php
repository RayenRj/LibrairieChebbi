<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes Manager</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        />      
    <link rel="stylesheet" href="../assets/css/commandeManager.css">
    <link rel="stylesheet" href="../assets/css/packManager.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?>

    <div class="commande-manager">
        <section>
            <!-- Partie elli feha el text wl input ta3 el date -->
            <div class="top-part">
                <h2>Commandes Manager 📦</h2>
                <p>Gérez vos Commandes : ajoutez , modifiez ou supprimez les Commandes disponibles</p>
            </div>  

            <!-- 4 cards  -->
            <div class="five-cards">

                <div class="card">
                    <div class="icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="text">
                        <p>Total Commandes</p>
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
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="text">
                        <p>Confirmée</p>
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
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="text">
                        <p>En attente</p>
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
                        <i class="fa-solid fa-circle-xmark"></i>
                        
                    </div>
                    <div class="text">
                        <p>Annulées</p>
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
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div class="text">
                        <p>Livrées</p>
                        <h3>312</h3>
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


            <div class="commandeManagerBottomPart">
                <div class="top">
                    <div>
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="packSearch" id="packSearch" placeholder="Rechercher un pack...">
                    </div>

                    <div>
                        <p>Critere de recherche </p>
                        <div>
                            <select name="" id="">
                                <option value="all" selected>Client</option>
                                <option value="all" >Telephone</option>
                                <option value="all" >Prix</option>
                                <option value="all" >Email</option>
                                <option value="all" >Id Commande</option>
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
                        <p>Datte Début</p>
                        <input type="date" name="" id="">
                    </div>
                    <div>
                        <p>Datte Fin</p>
                        <input type="date" name="" id="">
                    </div>


                    <div>
                        <p>reglage</p>
                        <button type="reset">
                            <i class="fa-solid fa-filter"></i>
                            Filtrer
                        </button>
                    </div>
                    
                </div>



                <div class="table-part">
                    <table>
                        <thead>
                            <th>Commande ID</th>
                            <th>Clients</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Montant</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </thead>
                        <!--el <p> hne just reglage ll font size -->
                        <tr>
                            <td><p>#CMD_1058</p></td>
                            <td><p>Rayen Rjibi</p></td>
                            <td><p>rjibi.rayen01@gmail.com</p></td>
                            <td><p>50559320</p></td>
                            <td><p class="prix">59 DT</p></td>
                            <td class="statut">
                                <!--
                                    <span class="attente">En attente</span>
                                    <span class="annulee" >Annulé</span>
                                    <span class="livree">Livrée</span>
                                -->
                                <span class="confirmee">Confirmée</span>
                            </td>
                            <td><p>30/05/2024 <br>10:30</p></td>
                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-check"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-x"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-truck"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-print"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#CMD_1058</p></td>
                            <td><p>Rayen Rjibi</p></td>
                            <td><p>rjibi.rayen01@gmail.com</p></td>
                            <td><p>50559320</p></td>
                            <td><p class="prix">59 DT</p></td>
                            <td class="statut">
                                <!--
                                    <span class="attente">En attente</span>
                                    <span class="annulee" >Annulé</span>
                                    <span class="livree">Livrée</span>
                                -->
                                <span class="confirmee">Confirmée</span>
                            </td>
                            <td><p>30/05/2024 <br>10:30</p></td>
                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-check"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-x"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-truck"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-print"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#CMD_1058</p></td>
                            <td><p>Rayen Rjibi</p></td>
                            <td><p>rjibi.rayen01@gmail.com</p></td>
                            <td><p>50559320</p></td>
                            <td><p class="prix">59 DT</p></td>
                            <td class="statut">
                                <!--
                                    <span class="attente">En attente</span>
                                    <span class="annulee" >Annulé</span>
                                    <span class="livree">Livrée</span>
                                -->
                                <span class="confirmee">Confirmée</span>
                            </td>
                            <td><p>30/05/2024 <br>10:30</p></td>
                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-check"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-x"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-truck"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-print"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#CMD_1058</p></td>
                            <td><p>Rayen Rjibi</p></td>
                            <td><p>rjibi.rayen01@gmail.com</p></td>
                            <td><p>50559320</p></td>
                            <td><p class="prix">59 DT</p></td>
                            <td class="statut">
                                <!--
                                    <span class="attente">En attente</span>
                                    <span class="annulee" >Annulé</span>
                                    <span class="livree">Livrée</span>
                                -->
                                <span class="confirmee">Confirmée</span>
                            </td>
                            <td><p>30/05/2024 <br>10:30</p></td>
                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-check"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-x"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-truck"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-print"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#CMD_1058</p></td>
                            <td><p>Rayen Rjibi</p></td>
                            <td><p>rjibi.rayen01@gmail.com</p></td>
                            <td><p>50559320</p></td>
                            <td><p class="prix">59 DT</p></td>
                            <td class="statut">
                                <!--
                                    <span class="attente">En attente</span>
                                    <span class="annulee" >Annulé</span>
                                    <span class="livree">Livrée</span>
                                -->
                                <span class="confirmee">Confirmée</span>
                            </td>
                            <td><p>30/05/2024 <br>10:30</p></td>
                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-check"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-x"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-truck"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-print"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#CMD_1058</p></td>
                            <td><p>Rayen Rjibi</p></td>
                            <td><p>rjibi.rayen01@gmail.com</p></td>
                            <td><p>50559320</p></td>
                            <td><p class="prix">59 DT</p></td>
                            <td class="statut">
                                <!--
                                    <span class="attente">En attente</span>
                                    <span class="annulee" >Annulé</span>
                                    <span class="livree">Livrée</span>
                                -->
                                <span class="confirmee">Confirmée</span>
                            </td>
                            <td><p>30/05/2024 <br>10:30</p></td>
                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-check"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-x"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-truck"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-print"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-trash-can"></i></li></a>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td><p>#CMD_1058</p></td>
                            <td><p>Rayen Rjibi</p></td>
                            <td><p>rjibi.rayen01@gmail.com</p></td>
                            <td><p>50559320</p></td>
                            <td><p class="prix">59 DT</p></td>
                            <td class="statut">
                                <!--
                                    <span class="attente">En attente</span>
                                    <span class="annulee" >Annulé</span>
                                    <span class="livree">Livrée</span>
                                -->
                                <span class="confirmee">Confirmée</span>
                            </td>
                            <td><p>30/05/2024 <br>10:30</p></td>
                            <td>
                                <ul>
                                    <a href=""><li><i class="fa-solid fa-check"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-x"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-truck"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-eye"></i></li></a>
                                    <a href=""><li><i class="fa-solid fa-print"></i></li></a>
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
        </section>
    </div>

</body>
</html>