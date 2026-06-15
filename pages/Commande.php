<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos Coordonnées
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <!-- <link rel="stylesheet" href="../assets/css/output.css"> -->
    <link rel="stylesheet" href="../assets/css/commande.css">
    <link rel="stylesheet" href="../assets/css/order.css">
</head>
<body>
    <?php include("../includes/header.php") ?>
    <div class="container">
        <div class="commande">

            <!-- partie li feha le deux cercle -->
            <div class="part-commande-top">
                <div class="item">
                    <div class="cercle first">1</div>
                    <div class="text">
                        <h2>Coordonnées</h2>
                        <p>Vos informations</p>
                    </div>
                </div>
                <hr>
                <div class="item">
                    <div class="cercle">2</div>
                    <div class="text seconde">
                        <h2>Confirmations</h2>
                        <p>Verifiez et confirmez</p>
                    </div>
                </div>
            </div>


            <div class="part-commande-bottom">
                <div class="part-commande-coordonne">

                    <!-- text sur le fieldset -->
                    <div class="text-commande">
                        <h1>Vos Coordonnées</h1>
                        <p>Veuillez remplir vos informations pour la livraison de votre commande.</p>
                    </div>

                    <!-- fieldset -->
                    <fieldset>
                        <div class="top-part">
                            <h2>informations Personelles</h2>
                            <div class="double">
                                <div class="with-label">
                                    <label for="nom">Nom Complet</label>
                                    <input type="text" placeholder="Entrer votre nom complet" required>
                                </div>
                                <div class="with-label">
                                    <label for="nom">Numero de téléphone</label>
                                    <input type="text" placeholder="Ex: 51 234 528" required>
                                </div>
                            </div>
                            <div class="email">
                                <div class="with-label">
                                    <label for="nom">Email</label>
                                    <input type="text" placeholder="Entrez votre email" required>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="bottom-part">
                            <h2>Adresse de livraison</h2>
                            <div class="double">
                                <div class="with-label">
                                    <label for="nom">Gouvernorat</label>
                                    <select name="" id="" >
                                        <option value="#" selected disabled>Sélectionnez votre gouvernorat</option>
                                    </select>
                                </div>
                                <div class="with-label">
                                    <label for="nom">Delegation</label>
                                    <select name="" id="">
                                        <option value="#" selected disabled>Sélectionnez votre délégation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="adresse-complete">
                                <div class="with-label">
                                    <label for="nom">Adresse Complète</label>
                                    <input type="text" placeholder="Numéro de rue, nom de rue , quartier..." required>
                                </div>
                            </div>
                            <div class="double">
                                <div class="with-label">
                                    <label for="nom">Code Postal</label>
                                    <input type="text" placeholder="Ex: 2063" required>
                                </div>
                                <div class="with-label">
                                    <label for="nom">Instructions spéciales (optionel)</label>
                                    <input type="text" placeholder="Insctruction pour la livraison..." >
                                </div>
                            </div>

                            <div class="button-confirmation">
                                <a href="#" class="btn-confirmation">Confirmer Votre Commade <i class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>

                    </fieldset>
                </div>
                <div class="part-commande-resume">
                    <main>
                        <h4>Résumé de la commande</h4>
                        <div class="articles">
                            <article>
                                <div>
                                    <img src="../assets/images/pack/pack_images/pack1.png" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">Pack Bac Math</p>
                                        <p class="quantite">x1</p>
                                    </div>
                                </div>
                                <p class="prix">149Dt</p>
                            </article>
                            <article>
                                <div>
                                    <img src="../assets/images/pack/pack_images/pack1.png" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">Pack Bac Math</p>
                                        <p class="quantite">x1</p>
                                    </div>
                                </div>
                                <p class="prix">149Dt</p>
                            </article>
                            <article>
                                <div>
                                    <img src="../assets/images/pack/pack_images/pack1.png" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">Pack Bac Math</p>
                                        <p class="quantite">x1</p>
                                    </div>
                                </div>
                                <p class="prix">149Dt</p>
                            </article>
                            <article>
                                <div>
                                    <img src="../assets/images/pack/pack_images/pack1.png" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">Pack Bac Math</p>
                                        <p class="quantite">x1</p>
                                    </div>
                                </div>
                                <p class="prix">149Dt</p>
                            </article>
                            <article>
                                <div>
                                    <img src="../assets/images/pack/pack_images/pack1.png" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">Pack Bac Math</p>
                                        <p class="quantite">x1</p>
                                    </div>
                                </div>
                                <p class="prix">149Dt</p>
                            </article>
                            <article>
                                <div>
                                    <img src="../assets/images/pack/pack_images/pack1.png" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">Pack Bac Math</p>
                                        <p class="quantite">x1</p>
                                    </div>
                                </div>
                                <p class="prix">149Dt</p>
                            </article>
                        </div>

                        <hr>
                        <div class="les-prix">
                            <div>
                                <p>Sous-total</p>
                                <p class="prix">456 Dt</p>
                            </div>
                            <div>
                                <p>Frais de livraison</p>
                                <p class="prix">6 Dt</p>
                            </div>

                        </div>
                        <hr>
                        <div class="totale">
                            <div>
                                <h4>Total</h4>
                                <p class="prix-bleu">462 Dt</p>
                            </div>
                            <p>TVA inclue</p>
                        </div>

                        <div class="paiement-securise">
                                <div>
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <div>
                                        <p>Paiement sécurisé</p>
                                        <p>Vos informations sont protégées et sécurisées</p>
                                    </div>
                                </div>
                                <i class="fa-solid fa-lock"></i>
                        </div>

                    </main>

                    <div class="aide">
                        <div class="icon"><i class="fa-solid fa-headphones"></i></div>
                        <div class="aide-text">
                            <h5>Besoin d'aide</h5>
                            <p>Notre équipe est la pour vous aider</p>
                            <a href="ContactUs.php">Nous Contacter <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- el pop up eli tatla3 ki tenzel 3al bouton confirmer la commande -->
    <div class="popup" hidden>
            <span class="overlay-order"></span>
            <main class="order">
                <div class="card-order"> 
                    <a class="dismiss button" href="#" hidden>×</a> 
                    <div class="header-order"> 
                        <div class="image">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </div> 
                        <div class="content-order">
                            <span class="title">Commande confirmée</span> 
                            <p class="message">Merci pour votre achat. Votre commande sera livrée dans un délai de 2 jours à compter de la date d'achat.</p> 
                        </div> 
                        <div class="actions-order">
                            <button class="history button" type="button">Historique</button> 
                            <a class="track button" href="main.php" type="button">Page Acceuill</a> 
                        </div> 
                    </div> 
                </div>
            </main>
    </div>


    <?php include("../includes/footer.php") ?>
    <script src="../assets/js/commande.js"></script>
</body>
</html>