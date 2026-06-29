<?php
    require_once(__DIR__ . "/../config/database.php");
    class Repository{
        public PDO $db;
        public function __construct(){
            $this->db = ConnexionDB::getConnexionDB();
        }
        public function lastInsertedId(){
            return $this->db->lastInsertId();
        }
    }
?>