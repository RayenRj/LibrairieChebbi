<?php
    require_once(__DIR__ . "/../backend/services/CommandeServices.php");
    $commandeService = new CommandeServices();
    $limit = 10;
    $page = $_GET["page"] ?? 1;
    $nbreDeligneFirstListOfCommandes = $commandeService->nbreDeLigneDeRecherche("" , "" , "","","");
    $firstListOfcommands = $commandeService->getCommandeFiltred("" , "" , "","","",$limit,$page);

    
    $nbreTotalePage = intval(ceil($nbreDeligneFirstListOfCommandes / $limit));
    

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
                        <h3><?= $commandeService->nombreTotaleCommandeCeMois(""); ?></h3>
                        <p>
                            <?php if(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("") ,$commandeService->nombreTotaleCommandeDernierMois("") ) >= 0): ?>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?= number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("") ,$commandeService->nombreTotaleCommandeDernierMois("") ),1) ?> %
                            </span>
                            <?php else: ?>
                            <span class="lost-effect">
                                <i class="fa-solid fa-arrow-down"></i>
                                <!-- <i class="fa-solid fa-arrow-up" hidden></i> -->
                                <?= number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("") ,$commandeService->nombreTotaleCommandeDernierMois("") ),1) ?> %
                            </span>
                            <?php endif; ?>
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
                        <h3><?= $commandeService->nombreTotaleCommandeCeMois("confirmée"); ?></h3>
                        <p>
                            <?php if(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("confirmée") ,$commandeService->nombreTotaleCommandeDernierMois("confirmée") ) >= 0): ?>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?= number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("confirmée") ,$commandeService->nombreTotaleCommandeDernierMois("confirmée") ) , 1) ?> %
                            </span>
                            <?php else: ?>
                            <span class="lost-effect">
                                <i class="fa-solid fa-arrow-down"></i>
                                <!-- <i class="fa-solid fa-arrow-up" hidden></i> -->
                                <?= number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("confirmée") ,$commandeService->nombreTotaleCommandeDernierMois("confirmée") ) , 1) ?> %
                            </span>
                            <?php endif; ?>
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
                        <h3><?= $commandeService->nombreTotaleCommandeCeMois("attente"); ?></h3>
                        <p>
                            <?php if(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("attente") ,$commandeService->nombreTotaleCommandeDernierMois("attente") ) >= 0): ?>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?=  number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("attente") ,$commandeService->nombreTotaleCommandeDernierMois("attente") ) , 1) ?> %
                            </span>
                            <?php else: ?>
                            <span class="lost-effect">
                                <i class="fa-solid fa-arrow-down"></i>
                                <!-- <i class="fa-solid fa-arrow-up" hidden></i> -->
                                <?=  number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("attente") ,$commandeService->nombreTotaleCommandeDernierMois("attente") ) , 1) ?> %
                            </span>
                            <?php endif; ?>
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
                        <h3><?= $commandeService->nombreTotaleCommandeCeMois("annulée"); ?></h3>
                        <p>
                            <?php if(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("annulée") ,$commandeService->nombreTotaleCommandeDernierMois("annulée") ) >= 0): ?>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?= number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("annulée") ,$commandeService->nombreTotaleCommandeDernierMois("annulée") ) , 1)  ?> %
                            </span>
                            <?php else: ?>
                            <span class="lost-effect">
                                <i class="fa-solid fa-arrow-down"></i>
                                <!-- <i class="fa-solid fa-arrow-up" hidden></i> -->
                                <?= number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("annulée") ,$commandeService->nombreTotaleCommandeDernierMois("annulée") ) , 1)  ?> %
                            </span>
                            <?php endif; ?>
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
                        <h3><?= $commandeService->nombreTotaleCommandeCeMois("livrée"); ?></h3>
                        <p>
                            <?php if(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("livrée") ,$commandeService->nombreTotaleCommandeDernierMois("livrée") ) >= 0): ?>
                            <span class="gain-effect">
                                <!-- <i class="fa-solid fa-arrow-down"></i> -->
                                <i class="fa-solid fa-arrow-up" ></i>
                                <?= number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("livrée") ,$commandeService->nombreTotaleCommandeDernierMois("livrée") ) , 1)  ?> %
                            </span>
                            <?php else: ?>
                            <span class="lost-effect">
                                <i class="fa-solid fa-arrow-down"></i>
                                <!-- <i class="fa-solid fa-arrow-up" hidden></i> -->
                                <?=number_format(calculDePourcentage($commandeService->nombreTotaleCommandeCeMois("livrée") ,$commandeService->nombreTotaleCommandeDernierMois("livrée") ) , 1)  ?> %
                            </span>
                            <?php endif; ?>
                            vs le mois dernier
                        </p>
                    </div>
                </div>
            </div>

            
            <div class="commandeManagerBottomPart" id="commandeTable">
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
                                <option value="all" selected>Tous</option>
                                <option value="all" >En attente</option>
                                <option value="all" >Confirmée</option>
                                <option value="all" >Livrée</option>
                                <option value="all" >Annulée</option>
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
                        <button type="sumbit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Rechercher
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
                        <?php 
                            foreach($firstListOfcommands as $key => $row):
                                $statut = $row["statut"];
                        ?>
                        <tr>
                            <td><p><?= $row["id_commande"]?></p></td>
                            <td><p><?= $row["nom"]?></p></td>
                            <td><p><?= $row["email"]?></p></td>
                            <td><p><?= $row["tel"]?></p></td>
                            <td><p class="prix"><?= $row["prix_totale"]?> DT</p></td>
                            <td class="statut">
                                <?php if($statut == "attente"): ?>
                                    <span class="attente">En attente</span>
                                <?php elseif($statut == "confirmée"): ?>
                                    <span class="confirmee">Confirmée</span>
                                <?php elseif($statut== "annulée"): ?>
                                    <span class="annulee" >Annulé</span>
                                <?php elseif($statut == "livrée"): ?>
                                    <span class="livree">Livrée</span>
                                <?php endif; ?>
                                
                            </td>
                            <td><p><?= $row["date_commande"]?></p></td>
                            <td>
                                <ul>
                                    <?php if($statut == "attente" ): ?>
                                        <a href="#" class="check"><li><i class="fa-solid fa-check"></i></li></a>
                                        <a href="#" class="croit-rouge"><li><i class="fa-solid fa-x"></i></li></a>
                                        <a href="#" class="eye"><li><i class="fa-solid fa-eye"></i></li></a> 
                                    <?php endif; ?>
                                    <?php if($statut == "livrée"): ?>
                                        <a href="#" class="print"><li><i class="fa-solid fa-print"></i></li></a>
                                        <a href="#" class="eye"><li><i class="fa-solid fa-eye"></i></li></a>
                                        <a href="#" class="croit-rouge commandeTrashLink" data-id="<?= $row["id_commande"] ?>"><li><i class="fa-solid fa-trash-can"></i></li></a>
                                    <?php endif; ?>
                                    <?php if($statut == "annulée"): ?>
                                        <a href="#" class="eye"><li><i class="fa-solid fa-eye"></i></li></a> 
                                        <a href="#" class="croit-rouge commandeTrashLink" data-id="<?= $row["id_commande"] ?>"><li><i class="fa-solid fa-trash-can"></i></li></a>
                                    <?php endif; ?>
                                    <?php if($statut == "confirmée"): ?>
                                        <a href="#" class="truck"><li><i class="fa-solid fa-truck"></i></li></a>
                                        <a href="#" class="print"><li><i class="fa-solid fa-print"></i></li></a>
                                        <a href="#" class="eye"><li><i class="fa-solid fa-eye"></i></li></a> 
                                        <a href="#" class="croit-rouge commandeTrashLink" data-id="<?= $row["id_commande"] ?>"><li><i class="fa-solid fa-trash-can"></i></li></a>
                                    <?php endif; ?>
                                    
                                </ul>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </table>

                </div>


                <div class="bottom">
                    <p>Affichage de <?= (($page - 1) * $limit ) +1  ?> à <?= min((($page + 1) * $limit )  , $nbreDeligneFirstListOfCommandes) ?> sur <?= $nbreDeligneFirstListOfCommandes ?> commandes</p>
                    <div class="pagination">
                        <!-- before -->
                        <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                        <?php if($page> 3):?>
                            <a href="#" id="three-dots">...</a>
                        <?php endif; ?>


                        <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                            <a href="/dashboard/commandes?page=<?= $i ?>#commandeTable"><?= $i ?></a>
                        <?php endfor; ?>

                        <!-- current page -->
                        <a href="#" class="pagination-selected"><?= $page ?></a>
                        <?php for($i=$page +1  ; $i <= min($page + 2 , $nbreTotalePage) ; $i++):?>
                            <a href="/dashboard/commandes?page=<?= $i ?>#commandeTable"><?= $i ?></a>
                        <?php endfor; ?> 
                                    
                            
                        <?php if(($nbreTotalePage - $page)> 2): ?>
                            <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                        <?php endif; ?>

                        <!-- after -->
                        <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>













            </div>
        </section>
    </div>
    <script src="/assets/js/commandeManager.js"></script>
</body>
</html>