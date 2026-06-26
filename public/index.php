<?php 
    include_once __DIR__ . "/../core/Router.php";
    include_once __DIR__ . "/../backend/controllers/*.php";

    $route = new Router();
    
    // ici on va ajouter tous les api : 
    // si l 'url = https://www.librairieChebbi.tn/api/book
    // on va s'interresee a l'uri = /api/book => on va eliminer la partie qui fait reference au serveur d'hosting
    

    // el forme : requet method | path patter | controller | action
    $route->add();
    

    $route->dispatch();


?>