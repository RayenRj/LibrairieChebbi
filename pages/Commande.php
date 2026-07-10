<?php
    require_once(__DIR__ . "/../backend/services/ClientServices.php");
    require_once(__DIR__ . "/../backend/models/Client.php");
    require_once(__DIR__ . "/../backend/services/CommandeServices.php");
    if(!isset($_SESSION["userId"])){
        header("Location: /main");
        exit;
    }
    $services_client = new ClientServices();
    $services_commande = new CommandeServices();
    $clientId = intval($_SESSION["userId"]);
    $client_data = $services_client->getClientById($clientId);
    $client = new Client(
        $client_data["nom"],
        $client_data["prenom"],
        $client_data["tel"],
        $client_data["email"],
        $client_data["password"],
        $client_data["role"],
        $client_data["addresse"] ?? ""
    );



?>

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
                    <form action="" enctype="multipart/form-data" id="commandeForm">
                        <fieldset>
                            <div class="top-part">
                                <h2>informations Personelles</h2>
                                <div class="double">
                                    <div class="with-label">
                                        <label for="nom">Nom Complet</label>
                                        <input type="text" name="nomComplet"  placeholder="Entrer votre nom complet" required value="<?= $client->getNom() . " " . $client->getPrenom() ?>">
                                    </div>
                                    <div class="with-label">
                                        <label for="nom">Numero de téléphone</label>
                                        <input type="text" name="tel" placeholder="Ex: 51 234 528" required value="<?= $client->getTel() ?>">
                                    </div>
                                </div>
                                <div class="email">
                                    <div class="with-label">
                                        <label for="nom">Email</label>
                                        <input type="text" name="email" placeholder="Entrez votre email" required value="<?= $client->getEmail() ?>">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="bottom-part">
                                <h2>Adresse de livraison</h2>
                                <div class="double">
                                    <div class="with-label">
                                        <label for="">Gouvernorat</label>
                                            <select name="gouvernorat" id="gouvernorat">
                                                <option value="">-- Sélectionnez un gouvernorat --</option>
                                                <option value="Ariana">Ariana</option>
                                                <option value="Béja">Béja</option>
                                                <option value="Ben Arous">Ben Arous</option>
                                                <option value="Bizerte">Bizerte</option>
                                                <option value="Gabès">Gabès</option>
                                                <option value="Gafsa">Gafsa</option>
                                                <option value="Jendouba">Jendouba</option>
                                                <option value="Kairouan">Kairouan</option>
                                                <option value="Kasserine">Kasserine</option>
                                                <option value="Kébili">Kébili</option>
                                                <option value="Le Kef">Le Kef</option>
                                                <option value="Mahdia">Mahdia</option>
                                                <option value="Manouba">Manouba</option>
                                                <option value="Médenine">Médenine</option>
                                                <option value="Monastir">Monastir</option>
                                                <option value="Nabeul">Nabeul</option>
                                                <option value="Sfax">Sfax</option>
                                                <option value="Sidi Bouzid">Sidi Bouzid</option>
                                                <option value="Siliana">Siliana</option>
                                                <option value="Sousse">Sousse</option>
                                                <option value="Tataouine">Tataouine</option>
                                                <option value="Tozeur">Tozeur</option>
                                                <option value="Tunis">Tunis</option>
                                                <option value="Zaghouan">Zaghouan</option>
                                            </select>
                                    </div>
                                    <div class="with-label">
                                        <label for="nom">Delegation</label>
                                        <select name="delegation" id="delegation">
                                            <option value="#" selected disabled>Sélectionnez votre délégation</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="adresse-complete">
                                    <div class="with-label">
                                        <label for="nom">Adresse Complète</label>
                                        <input type="text" name="addresseComplete" placeholder="Numéro de rue, nom de rue , quartier..." required>
                                    </div>
                                </div>
                                <div class="double">
                                    <div class="with-label">
                                        <label for="nom">Code Postal</label>
                                        <input type="text" placeholder="Ex: 2063" name="codePostal">
                                    </div>
                                    <div class="with-label">
                                        <label for="nom">Instructions spéciales (optionel)</label>
                                        <input type="text" name="comment" placeholder="Insctruction pour la livraison..." >
                                    </div>
                                </div>

                                <div class="button-confirmation">
                                    <button data-prixtotale="<?=  $_GET["total"] ?>"  data-idclient="<?= $_SESSION["userId"] ?>" type="submit" class="btn-confirmation">Confirmer Votre Commade <i class="fa-solid fa-arrow-right-long"></i></button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
                <div class="part-commande-resume">
                    <main>
                        <h4>Résumé de la commande</h4>
                        <div class="articles">
                            <!--
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
-->
                        </div>

                        <hr>
                        <div class="les-prix">
                            <div>
                                <p>Sous-total</p>
                                <p class="prix"><?= $_GET["total"] ?? 0 ?> Dt</p>
                            </div>
                            <div>
                                <p>Frais de livraison</p>
                                <p class="prix">7 Dt</p>
                            </div>

                        </div>
                        <hr>
                        <div class="totale">
                            <div>
                                <h4>Total</h4>
                                <p class="prix-bleu"><?= $_GET["total"] + 7 ?? 0 ?> Dt</p>
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
                            <a href="/contactus">Nous Contacter <i class="fa-solid fa-arrow-right"></i></a>
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
                    <a class="dismiss button" href="/products" hidden>×</a> 
                    <div class="header-order"> 
                        <div class="image">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M20 7L9.00004 18L3.99994 13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </div> 
                        <div class="content-order">
                            <span class="title">Commande confirmée</span> 
                            <p class="message">Merci pour votre achat. Votre commande sera livrée dans un délai de 2 jours à compter de la date d'achat.</p> 
                        </div> 
                        <div class="actions-order">
                            <a href="/client" class="history button" type="button">Historique</a> 
                            <a class="track button" href="/main" type="button">Page Acceuill</a> 
                        </div> 
                    </div> 
                </div>
            </main>
    </div>


    <?php include("../includes/footer.php") ?>
    <script src="../assets/js/commande.js"></script>
</body>
</html>