<?php 
    $url = "http://librairieChebbi.tn/products/panier?id=5&categorie=list";
    echo parse_url($url, PHP_URL_HOST);
    echo "<br>";
    echo parse_url($url , PHP_URL_PATH);
    echo "<br>";
    echo parse_url($url , PHP_URL_SCHEME);
    echo "<br>";
    print_r(explode("&", parse_url($url , PHP_URL_QUERY)));
    echo "<br>";
    echo parse_url($url , PHP_URL_PORT);

?>