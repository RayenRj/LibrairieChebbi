<?php

    // use Dotenv\Dotenv;

    require __DIR__ . "/../../vendor/autoload.php";
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
    $dotenv->load();
    class ConnexionDB{
        private string $dbName;
        private string $user;
        private string $password ; 
        private string $host;
        public static ?PDO $db=null;

        private function __construct(){
            $this->dbName = $_ENV["DB_NAME"];
            $this->user= $_ENV["DB_USERNAME"];
            $this->password = $_ENV["DB_PASSWORD"];
            $this->host = $_ENV["DB_HOST"];
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