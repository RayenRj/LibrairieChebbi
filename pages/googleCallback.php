<?php 
require_once __DIR__ ."/../vendor/autoload.php";
require_once __DIR__ . "/../backend/services/ClientServices.php";
$service_client = new ClientServices();
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

    if($service_client->isEmailTaken($email)===false){
        $client = $service_client->createClient(explode(" ",$name)[0] ,explode(" ",$name)[1],"",$email,  "","","" );      
    }

    $_SESSION["userId"] = $service_client->getClietIdByEmail($email);
    $_SESSION["googleID"] = $googleId;
    $_SESSION["clientEmail"] = $email;
    $_SESSION["role"] = $service_client->getClientRoleByEmail($email) ?: "client";
    $_SESSION["firstName"]= explode(" ",$name)[0];
    $_SESSION["lastName"] = explode(" ",$name)[1];

    header("Location: /main");
}else{
    exit("invalid ID Token");
}









?>