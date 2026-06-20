<?php

    // use Dotenv\Dotenv;

    require "../vendor/autoload.php";
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();
    class ConnexionDB{
        private string $dbName = $_ENV["DB_NAME"];
        private string $user= $_ENV["DB_USERNAME"];
        private string $password = $_ENV["DB_PASSWORD"]; 
        private string $host = $_ENV["DB_HOST"];
        public static ?PDO $db=null;

        private function __construct(){
            try{
                self::$db = new PDO("mysql:host={$this->host};dbname={$this->dbName}" , $this->user,$this->password);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }


        public static function getConnexionDB(): PDO{
            if(self::$db == null){new ConnexionDB();}
            return self::$db;
        }



    }

?>