<?php 
echo "Hello";
require __DIR__ ."/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();
if(!isset($_GET["state"]) || $_GET["state"] !== $_SESSION["oauth2state"]){
    unset($_SESSION["oauth2state"]);
    exit("Invalid state parameter");
}

if(isset($_GET["error"])){
    exit("Google returned an error: " . htmlspecialchars($_GET["error"]));
}

$client = new Google\Client();
$client->setClientId($_ENV["GOOGLE_CLIENT_ID"]);
$client->setClientSecret($_ENV["GOOGLE_CLIENT_SECRET"]);
$client->setRedirectUri($_ENV["GOOGLE_REDIRECT_URI"]);
$client->setPrompt("consent select_account");
$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
if(isset($token["error"])){
    exit("Failed to get Log in token : " . $token["error"]);
}

$client->setAccessToken($token);

$payload = $client->verifyIdToken();

if($payload){
    $googleId = $payload["sub"];
    $email = $payload["email"];
    $name = $payload["name"];

    $_SESSION["googleID"] = $googleId;
    $_SESSION["userId"] = $googleId;
    $_SESSION["clientEmail"] = $email;
    $_SESSION["role"] = "client";
    $_SESSION["nom"]= explode(" ",$name)[0];
    $_SESSION["prenom"] = explode(" ",$name)[1];
    header("Location: /main");

}else{
    exit("invalid ID Token");
}









?>