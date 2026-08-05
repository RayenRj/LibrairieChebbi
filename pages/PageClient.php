<?php
    require_once(__DIR__ . "/../backend/services/ClientServices.php");
    require_once(__DIR__ . "/../backend/models/Client.php");
    require_once(__DIR__ . "/../backend/services/CommandeServices.php");
    $services_client = new ClientServices();
    $services_commande = new CommandeServices();
    if(!isset($_SESSION["userId"])){
        header("Location: /main");
        exit;
    }

    if(isset($_SESSION["userId"])){
        $client_data = $services_client->searchClientsByEmail($_SESSION["clientEmail"]);
    }else{

        $clientId = intval($_SESSION["userId"]);
        $client_data = $services_client->getClientById($clientId);
    }


    $client = new Client(
        $client_data["nom"] ?? $_SESSION["nom"],
        $client_data["prenom"] ?? $_SESSION["prenom"],
        $client_data["tel"] ?? "",
        $client_data["email"] ?? $_SESSION["clientEmail"],
        $client_data["password"] ?? "",
        $client_data["role"] ?? $_SESSION["role"],
        $client_data["addresse"] ?? ""
    );


    $liste_commande = $services_commande->getCommandeByClient($_SESSION["userId"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Librairie Chebbi</title>
    <link rel="stylesheet" href="/assets/css/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

    <?php include(__DIR__ . "/../includes/header.php");?>
    
    <div class="container">
        <main>
            <div class="card">
                <div class="profileCard">
                    <img src="https://imgs.search.brave.com/jOOmSTKR7Yk1ZdctkdbMeGFEzjKduBpH1v6TRCjOoHM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/bWFnbmlmaWMuY29t/L3ByZW1pdW0tdmVj/dG9yL21hbi1hdmF0/YXItcHJvZmlsZS1w/aWN0dXJlLXZlY3Rv/ci1pbGx1c3RyYXRp/b25fMjY4ODM0LTUz/OC5qcGc_c2VtdD1h/aXNfaHlicmlkJnc9/NzQwJnE9ODA" alt="">
                    <div class="text">
                        <h3><?= $client->getNom(); ?> <?= $client->getPrenom() ?></h3>
                        <p><?= $client->getEmail() ?></p>
                    </div>
                </div>
                <div class="link">
                    <ul>
                        <a href="#" >
                            <li><i class="fa-regular fa-user"></i> Information du compte</li>
                        </a>
                        <a href="#">
                            <li class="logOut"><i class="fa-solid fa-arrow-right-from-bracket"></i> Déconnexion</li>
                        </a>
                    </ul>
                </div>
            </div>
        </main>




        <!-- LA 2eme card -->
        <main>
            <div class="secondCard">
                <div class="text">
                    <h3>Informations du compte</h3>
                    <p>Gérez vos informations personnelles</p>
                </div>
                <div class="card">
                    <ul>
                        <li>
                            <section>
                                <p>Nom</p>
                                <div>
                                    <input type="text" name="nom" id="" placeholder="Tapez votre nom ..." value="<?= $client->getNom() ?>">
                                    <div class="icon"><i class="fa-regular fa-user"></i></div>
                                </div>
                            </section>
                        </li>
                        <li>
                            <section>
                                <p>Prénom</p>
                                <div>
                                    <input type="text" name="nom" id="" placeholder="Tapez votre prenom ..." value="<?= $client->getPrenom() ?>">
                                    <div class="icon"><i class="fa-regular fa-user"></i></div>
                                </div>
                            </section>
                        </li>
                        <li>
                            <section>
                                <p>Email</p>
                                <div>
                                    <input type="email" name="nom" id="" placeholder="Tapez votre email ..." value="<?= $client->getEmail() ?>">
                                    <div class="icon"><i class="fa-regular fa-envelope"></i></div>
                                </div>
                            </section>
                        </li>
                        <li>
                            <section class="mps">
                                <p>Mot de passe</p>
                                <div>
                                    <input type="password" name="nom" id="" placeholder="Tapez votre mot de passe ..." value="<?= $client->getPassword() ?>">
                                    <div class="icon"><i class="fa-solid fa-lock"></i></div>
                                    <div class="passwordIcon"><i class="fa-regular fa-eye-slash"></i></div>

                                </div>
                            </section>
                        </li>
                        <li>
                            <section>
                                <p>Adresse</p>
                                <div>
                                    <input type="text" name="nom" id="" placeholder="Tapez votre adresse ..." value="<?= $client->getAdresse() ?>">
                                    <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                                </div>
                            </section>
                        </li>
                        <li>
                            <section>
                                <p>Numéro de téléphone</p>
                                <div>
                                    <input type="text" name="nom" id="" placeholder="Tapez votre numero de telephone ..." value="<?= $client->getTel() ?>">
                                    <div class="icon"><i class="fa-solid fa-phone"></i></div>
                                </div>
                            </section>
                        </li>
                        <li>
                            <button class="saveModification"><i class="fa-regular fa-floppy-disk"></i> Enregistrer les modifications</button>
                        </li>
                    </ul>

                </div>
            </div>
        </main>




        <!-- 3 eme Partie -->
        <main>
            <div class="thirdCard">


                <div class="text">
                    <h3>Historique de Vos Commandes</h3>
                    <p>Retrouvez toutes vos Commandes</p>
                </div>


                
                <div class="card">

                    <?php if(sizeof($liste_commande)==0):?>
                        <div class="empty-history-container">
                            <!-- SVG d'une boîte de commande vide -->
                            <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>

                            <!-- Le message -->
                            <p class="empty-text">Vous n'avez pas encore passé de commande</p>

                            <!-- Le bouton -->
                            <a href="/products" class="start-shopping-btn">Commencer mes achats <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    <?php else: ?>
                        <?php $counter = 0; ?>
                        <?php foreach($liste_commande as $commande): ?>
                            
                            <?php $counter++; ?>
                            <article>
                                <label for="check<?= $counter ?>">
                                    <ul>
                                        <li>Commande #<?= $commande["id_commande"] ?></li>
                                        <?php 
                                            $dateObj = new DateTime($commande["date_commande"]);
                                            $day = $dateObj->format("d");
                                            $month =  $dateObj->format("F");
                                            $year = $dateObj->format("Y");
                                            $time = $dateObj->format("G:i");


                                        ?>
                                        <li><?= $day . " " . $month . " " . $year ?></li>
                                        <li><?= number_format($commande["prix_totale"] , 3 , "," , " ") ?> Dt</li>
                                        <?php if(in_array($commande["statut"],["confirmée","attente"])): ?>
                                            <li class="tableStatut Expediee">Expediée</li>
                                        <?php elseif($commande["statut"] == "annulée"): ?>
                                            <li class="tableStatut Annulee">Annulée</li>
                                        <?php elseif($commande["statut"] == "livrée"): ?>
                                            <li class="tableStatut Livree">Livrée</li>
                                            
                                        <?php endif; ?>
                                        <li class="arrowContainer">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </li>
                                    </ul>
                                </label>
                                <input type="checkbox" id="check<?= $counter ?>">
                                <div class="commandeContainer">
                                    <div class="topPart">
                                        <div>
                                            <div>
                                                <h4>Commande#<?= $commande["id_commande"] ?></h4>
                                                <?php if(in_array($commande["statut"],["confirmée","attente"])): ?>
                                                    <li class="statutExpediee statutCommande">Expediée</li>
                                                <?php elseif($commande["statut"] == "annulée"): ?>
                                                    <li class="statutAnnulee statutCommande">Annulée</li>
                                                <?php elseif($commande["statut"] == "livrée"): ?>
                                                    <li class="statutLivree statutCommande">Livrée</li>
                                                <?php endif; ?>
                                            </div>
                                            <p>Passé le <?= "$day $month $year" ?> à <?= $time ?></p>
                                        </div>

                                        <div>
                                            <p>Total : <span><?= number_format($commande["prix_totale"] , 3 , "," , " ") ?> Dt</span></p>
                                        </div>

                                    </div>

                                    <?php $liste_article = $services_commande->getCommandeArticles($commande["id_commande"]);?>
                                    <!-- 1 article  -->

                                    

                                    <div class="listArticles">
                                        <p>Articles Commandés</p>
                                        <ul class="articleContainer">
                                            <?php foreach($liste_article as $article): ?>
                                                <li>
                                                    <ul>
                                                        <li>
                                                            <img src="<?= $article["image_url"] ?>" alt="Image d'une fourniture scholaire | Librairie chebbi | tunisie">
                                                            <div class="text">
                                                                <h5><?= $article["libelle"] ?></h5>
                                                                <p><?= $article["categorie"] ?>, <?= $article["marque"] ?></p>
                                                            </div>
                                                        </li>
                                                        <li>x<?= $article["quantite"] ?></li>
                                                        <li><?= number_format(floatval($article["quantite"]) * floatval($article["prix"]) , 3 , "," , " ") ?> Dt</li>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>

                                    <div class="bottomPart">
                                        <div class="double">
                                            <h5>Sous-total</h5>
                                            <p><?= number_format(floatval($commande["prix_totale"]) - 7 , 3 , "," , " ") ?> Dt</p>
                                        </div>
                                        <div class="double">
                                            <h5>Livraison</h5>
                                            <p>7,000 Dt</p>
                                        </div>
                                        <hr>
                                        <div class="double">
                                            <h3>Total</h3>
                                            <h3><?= number_format($commande["prix_totale"] , 3 , "," , " ") ?> Dt</h3>
                                        </div>
                                    </div>
                                </div>
                            </article>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    <?php include(__DIR__ . "/../includes/footer.php");?>
    <script src="/assets/js/client.js"></script>
</body>
</html>