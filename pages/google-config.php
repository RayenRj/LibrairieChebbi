<?php
require_once __DIR__ . "/../vendor/autoload.php";
// use Dotenv\Dotenv;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../.env");
// $dotenv->load();
$client = new Google\Client();
$client->setClientId($_ENV["GOOGLE_CLIENT_ID"]);
$client->setClientSecret($_ENV["GOOGLE_CLIENT_SECRET"]);
$client->setRedirectUri($_ENV["GOOGLE_REDIRECT_URI"]);
$client->setPrompt("consent select_account");
$state = bin2hex(random_bytes(16));
$_SESSION["oauth2state"]=$state;
$client->addScope("email");
$client->addScope("profile");
$client->setState($state);

?>