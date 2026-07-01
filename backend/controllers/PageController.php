<?php
    // PageController : used to link the api to a rendred page
    define("PATH" , __DIR__ .  "/../../pages/");
    class PageController{
        public function dashboardPage(){require_once(PATH . "Dashboard.php");}
        public function allProductPage(){require(PATH . "AllProduct.php");}
        public function CommandeManagerPage(){require(PATH . "CommandesManager.php");}
        public function packManagerPage(){require(PATH . "PackManager.php");}
        public function articleManagerPage(){require(PATH . "ArticleManager.php");}
        public function contactUsPage(){require(PATH . "ContactUs.php");}
        public function gamesPage(){require(PATH . "Games.php");}
        public function mainPage(){require(PATH . "Main.php");}
        public function packPage(){require(PATH . "Pack.php");}
        public function articlePage(){require(PATH . "Product.php");}
        public function promotionPage(){require(PATH . "Promotions.php");}
        public function adminsPage(){require(PATH . "Admin.php");}
        public function clientsPage(){require(PATH . "Utilisateur.php");}
        public function panierPage(){require(PATH . "Panier.php");}
        public function commandePage(){require(PATH . "Commande.php");}
        public function collectionPage(){require(PATH . "Collection.php");}

    }

?>