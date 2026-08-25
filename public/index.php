<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
    include_once __DIR__ . "/../core/Router.php";
    include_once __DIR__ . "/../backend/controllers/ClientController.php";
    include_once __DIR__ . "/../backend/controllers/CommandeController.php";
    include_once __DIR__ . "/../backend/controllers/PackController.php";
    include_once __DIR__ . "/../backend/controllers/ProductController.php";
    // include_once __DIR__ . "/../backend/controllers/StatistiqueController.php";
    include_once __DIR__ . "/../backend/controllers/PageController.php";

    $route = new Router();
    
    // ici on va ajouter tous les api : 
    // si l 'url = https://www.librairieChebbi.tn/api/book
    // on va s'interresee a l'uri = /api/book => on va eliminer la partie qui fait reference au serveur d'hosting
    

    // el forme : requet method | path patter | controller | action
    // routes pour les page 
    // $route->add("GET", "/api/");

    //pages
    $route->add("GET", "/products" , "PageController","allProductPage");
    $route->add("GET", "/dashboard" , "PageController","dashboardPage");
    $route->add("GET", "/contactus" , "PageController","contactUsPage");
    $route->add("GET", "/games" , "PageController","gamesPage");
    $route->add("GET", "/main" , "PageController","mainPage");
    $route->add("GET", "/" , "PageController","mainPage");
    $route->add("GET", "/packs" , "PageController","packPage");
    $route->add("GET", "/products/product" , "PageController","articlePage");
    $route->add("GET", "/dashboard/commandes" , "PageController","CommandeManagerPage");
    $route->add("GET", "/dashboard/promotions" , "PageController","promotionPage");
    $route->add("GET", "/dashboard/admins" , "PageController","adminsPage");
    $route->add("GET", "/dashboard/clients" , "PageController","clientsPage");
    $route->add("GET", "/dashboard/articles" , "PageController","articleManagerPage");
    $route->add("GET", "/dashboard/packs" , "PageController","packManagerPage");
    $route->add("GET", "/panier" , "PageController","panierPage");
    $route->add("GET", "/commande" , "PageController","commandePage");
    $route->add("GET", "/collections" , "PageController","collectionPage");
    $route->add("GET", "/test" , "PageController","test");
    $route->add("GET", "/packs/pack" , "PageController","productPack");
    $route->add("GET", "/client" , "PageController","clientPage");
    $route->add("GET", "/packs/livres" , "PageController","packLivrePage");
    $route->add("GET", "/packs/livres/parascolaire" , "PageController","ParascolairePage");
    $route->add("GET", "/google-callback" , "PageController","callbackPage");
    $route->add("GET", "/google-login" , "PageController","logInPage");

    //=========> Product Routes <=======
    $route->add("POST","/api/articles","ProductController","addProduct");
    $route->add("DELETE","/api/articles/{id}","ProductController","deleteProduct");
    $route->add("PATCH","/api/articles/{id}","ProductController","modifyProduct");
    $route->add("GET", "/api/articles" , "ProductController" , "getAllProduct");
    $route->add("GET", "/api/articles/search" , "ProductController" , "rechercherArticle");
    $route->add("POST", "/api/articles/vente" , "ProductController" , "nombreDeVenteParMois");
    $route->add("GET", "/api/articles/ventes/categories" , "ProductController" , "nbreDeVentePourChaqueCategorieCeMois");
    $route->add("GET","/api/products/{id}","ProductController","getProductById");
    $route->add("PATCH","/api/articles/remise/{id}","ProductController","addRemise");
    $route->add("GET","/api/venteParJour/{id}","ProductController","nombreDeVenteParJour");
    $route->add("GET","/api/venteParCategorie","ProductController","nombreDeVentePourChaqueCategorie");




    // $route->add("GET","/librairie/LibrairieChebbi/public/api/products","ProductController","getAllProducts"); //  pagination independante ml uri
    $route->add("PATCH","/api/products/addRemise/{id}","ProductController","addRemise");
    //=========> End Product Routes <=======



    //=========> Pack Routes <======
    $route->add("DELETE" , "/api/packs/{id}", "PackController","deletePack");
    $route->add("POST" , "/api/packs/createPack", "PackController","savePack");

    //=========> User Routes <======
    
    $route->add("POST" , "/api/users/createUser" , "ClientController","SignUp");
    $route->add("POST" , "/api/users/signIn" , "ClientController","signIn");
    $route->add("PATCH","/api/users/addAdmin/{id}","ClientController","addAdmin");
    $route->add("PATCH","/api/users/deletAdmin/{id}","ClientController","removeAdmin");
    $route->add("DELETE","/api/users/deleteClient/{id}","ClientController","deleteClient");
    $route->add("GET","/api/users", "ClientController" , "getAllUsers");
    $route->add("GET","/api/users/isClientLoggedIn", "ClientController" , "isClientLoggedIn");
    $route->add("GET","/api/users/logout", "ClientController" , "logOut");
    $route->add("GET","/api/users/user/{id}", "ClientController" , "getClientByIdentifier");


    //=========> commande Routes <=======
    $route->add("DELETE" , "/api/commandes/{id}", "CommandeController","deleteCommande");
    $route->add("POST" , "/api/commandes/save", "CommandeController","saveCommande");
    $route->add("PATCH" , "/api/commandes/confirme/{id}", "CommandeController","confirmeCommande");
    $route->add("PATCH" , "/api/commandes/annule/{id}", "CommandeController","annuleeCommande");
    $route->add("PATCH" , "/api/commandes/livre/{id}", "CommandeController","livreeCommande");
    $route->add("PATCH" , "/api/commandes/livre/{id}", "CommandeController","livreeCommande");
    $route->add("GET" , "/api/commandes/{id}", "CommandeController","getCommandeById");
    $route->add("GET" , "/api/commandes/{id}/articles", "CommandeController","getCommandeArticles");






    $route->dispatch();


?>