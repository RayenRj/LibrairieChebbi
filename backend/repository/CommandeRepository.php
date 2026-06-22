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

        public function nombreTotaleCommandesSelonStatutCeMois(string $statut){
            $query = "select count(*) from commande where statut = '?' and month(date_commande) = month(current_date()) and year(date_commande) = year(curdate());";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$statut]);
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }

        // partie actions
        public function changeStatut($id_commande, $new_statut): bool{
            $query = "update commande set statut = ? where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$new_statut,$id_commande]);
        }
        public function deleteCommande($id_commande): bool{
            $query = "delete from commande where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id_commande]);
        }
        public function getCommandeById($id_commande): bool{
            $query = "select * from commande where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_commande]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // partie search 


    }

?>