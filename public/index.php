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

    // instanciation du routeur
    $route = new Router();
    
    /**
     * Summary of rateLimiter
     * @param mixed $maxRate => el max rate eli ya3mlou el Ip @ 3al URI eli bch ta3teha
     * @param mixed $refillTime => el refill time eli t9is bih wa9teh y3awed ynajem yodkhl bl ip Adresse
     * @return void
     */
    function rateLimiter($maxRate = 200 , $refillTime = 60){
        $ip = $_SERVER["REMOTE_ADDR"] ?? "unknown";
        $ipHash = hash("sha256",$ip);
        $folder = __DIR__ . "/../storage/rateLimiter/";
        
        if(!is_dir($folder)){mkdir($folder , 0755 , true);}
            
        $file = __DIR__ . "/../storage/rateLimiter/" . $ipHash . ".json";
        $now = time();

        if(file_exists($file)){
            $data = json_decode(file_get_contents($file), true);
            if(!is_array($data)){
                $data = [];
            }
        }else{
            $data= [];
        }
            // fitrage ll Time Stamps : kol timestamp tmathel request sarret bl ip hedhi
        $data = array_filter($data,fn($TimeStampOfEveryRateWithThisIp)=> $TimeStampOfEveryRateWithThisIp > (time() - $refillTime));
        if(count($data) > $maxRate){
                http_response_code(429);
                // header("content-type: application/json");
                // header("retry-after: " . ((min($data) + $refillTime) - time()));
                // echo json_encode([
                //     "success"=> false,
                //     "message" => "Essayer de nouveau après : " . ((min($data) + $refillTime) - time())  . " Secondes"
                // ]);
                // exit;
                $retryAfter= ((min($data) + $refillTime) - time());
                $_SERVER["rateLimitTime"] = $retryAfter;
                header("Location: /ratelimitpassed?retry=" . $retryAfter);
                exit;
        }
        $data[] = $now;
        file_put_contents(
                $file,
                json_encode(array_values(($data))),
                LOCK_EX
        );
    }


    //pages
        $uriList = [
    "/products",
    "/dashboard",
    "/contactus",
    "/games",
    "/main",
    "/",
    "/packs",
    "/products/product",
    "/dashboard/commandes",
    "/dashboard/promotions",
    "/dashboard/admins",
    "/dashboard/clients",
    "/dashboard/articles",
    "/dashboard/packs",
    "/panier",
    "/commande",
    "/collections",
    "/test",
    "/packs/pack",
    "/client",
    "/packs/livres",
    "/packs/livres/parascolaire",
    "/google-callback",
    "/google-login",
    "/verify",
    "/testMail",
    "/verify-email",
    "/ratelimitpassed",
    "/error",
    "/dashboard/messages",
    "/api/users/message/send",
    "/api/users/message/lu",
    "/api/users/messages"
];
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
    $route->add("GET", "/verify" , "PageController","testMail");
    $route->add("GET", "/testMail" , "PageController","testMail");
    $route->add("GET", "/verify-email", "PageController", "verifyEmailPage");
    $route->add("GET", "/ratelimitpassed", "PageController", "rateLimiterPage");
    $route->add("GET", "/error", "PageController", "erorPage");
    $route->add("GET", "/dashboard/messages", "PageController", "messageBox");



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

    // $route->add("GET","/api/articles/collection","ProductController","");
    // $route->add("GET","/api/articles/game","ProductController","");
    // $route->add("GET","/api/articles/livre","ProductController","");



    // $route->add("GET","/librairie/LibrairieChebbi/public/api/products","ProductController","getAllProducts"); //  pagination independante ml uri
    $route->add("PATCH","/api/products/addRemise/{id}","ProductController","addRemise");
    //=========> End Product Routes <=======



    //=========> Pack Routes <======
    $route->add("DELETE" , "/api/packs/{id}", "PackController","deletePack");
    $route->add("POST" , "/api/packs/createPack", "PackController","savePack");
    $route->add("POST" , "/api/packs/edit/{id}", "PackController","editPack");
    $route->add("GET","/api/packs/{id}","PackController","getPackById");
    $route->add("GET","/api/packs/{id}/products","PackController","getPackProduct");

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
    $route->add("POST","/api/users/update", "ClientController" , "updateClient");
    $route->add("POST","/api/users/resend-code","ClientController","resendVerificationCode");
    $route->add("POST","/api/users/verify-email","ClientController","verifyEmail");
    $route->add("POST","/api/users/message/send","ClientController","sendMessage");
    $route->add("POST","/api/users/message/lu","ClientController","setMessageLu");
    $route->add("POST","/api/users/messages","ClientController","getMessageList");

    //=========> commande Routes <=======
    $route->add("DELETE" , "/api/commandes/{id}", "CommandeController","deleteCommande");
    $route->add("POST" , "/api/commandes/save", "CommandeController","saveCommande");
    $route->add("PATCH" , "/api/commandes/confirme/{id}", "CommandeController","confirmeCommande");
    $route->add("PATCH" , "/api/commandes/annule/{id}", "CommandeController","annuleeCommande");
    $route->add("PATCH" , "/api/commandes/livre/{id}", "CommandeController","livreeCommande");
    $route->add("PATCH" , "/api/commandes/livre/{id}", "CommandeController","livreeCommande");
    $route->add("GET" , "/api/commandes/{id}", "CommandeController","getCommandeById");
    $route->add("GET" , "/api/commandes/{id}/articles", "CommandeController","getCommandeArticles");
    




    // adding the router ;
    // setting defaut Limit for every uri
    $method = mb_strtolower($_SERVER["REQUEST_METHOD"]);
    $url_uri = mb_strtolower(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
    $uri = $method . " " . $url_uri;


    // if(!in_array($url_uri , $uriList)){
    //     if(str_starts_with($url_uri , "/api/")){
    //         http_response_code(404);
    //         header("Content-Type: application/json");
    //         echo json_encode([
    //             "success" => false,
    //             "data"=>null,
    //             "message"=>"API route not found",
    //             "redirect" => "/error"
    //         ]);
    //         exit;
    //     }else{
    //         header("Location: /error");
    //         exit;
    //     }
    // }
    if(!in_array($url_uri , $uriList) && !str_starts_with($url_uri,"/api/")){
        header("Location: /error");
        exit;

    }

    
    
    $restricted_uri_array = ["post /api/users/createuser","post /api/users/signin" , "post /api/users/verify-email",""];
    if(in_array($uri,$restricted_uri_array)){
        rateLimiter(20);
    }else if($uri == "get /ratelimitpassed"){
        rateLimiter(100,30);
    }else{
        rateLimiter(50,60);
    }



    $route->dispatch();


?>