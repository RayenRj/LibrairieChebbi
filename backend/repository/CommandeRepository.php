<?php 
    require_once(__DIR__ . "/IRepository.php");
    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "../models/Commande.php");
    class CommandeRepository extends Repository{
        //constructor
        private string $tName = "commande";
        public function __construct(){parent::__construct();}

        // ##################
        // partie statistique
        // ##################
        public function nombreTotaleCommandes(){
            $query= "select count(*) from {$this->tName};";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        public function nombreTotaleCommandesCeMois(){
            $query = "select count(*) from commande where month(date_commande) = month(current_date()) and year(date_commande) = year(curdate());";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }

        public function nombreTotaleCommandesConfirméeCeMois(){
            $query = "select count(*) from commande where statut = 'confirmée' and month(date_commande) = month(current_date()) and year(date_commande) = year(curdate());";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        public function nombreTotaleCommandesAnnuléeCeMois(){
            $query = "select count(*) from commande where statut = 'confirmée' and month(date_commande) = month(current_date()) and year(date_commande) = year(curdate());";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        // kamel el commande repository


    }

?>