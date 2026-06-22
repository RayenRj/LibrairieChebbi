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
        public function getCommandeById($id_commande){
            $query = "select * from commande where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_commande]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // partie search 

    /**
         * *
         * @param string $statut => statut ei bch ta3ml 3leha el filtrage
         * @return array liste feha les commandes filtrer selon la  critére
         */
        public function nombreTotaleCommandeCeMois(string $statut){
            $query = "select count(*) from commande where statut = '?' and month(date_commande) = month(current_date()) and year(date_commande) = year(curdate());";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$statut]);
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }

        // statistique en generales
        public function FiltreCommandesParStatut(string $statut){
            $query = "select * from {$this->tName} where statut = '?' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$statut]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        // recherche de commande :
        // recherche par une seule critere 
        /**
         * Summary of filtreCommandeParDate
         * @param string $dateDebut si la valeur est null donc bch tetna7a ml filtrage
         * @param string $dateFin si la valeur est null donc bch tetna7a ml filtrage
         * @return array lista feha 
         */
        public function filtreCommandeParDate(string $dateDebut , string $dateFin){
            if ($dateDebut == null && $dateFin==null){return null;}
            else if($dateDebut == null){
                $query = "select * from {$this->tName} where date_commande < ? ;";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$dateFin]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else if($dateFin== null){
                $query = "select * from {$this->tName} where date_commande > ? ;";
                $stmt= $this->db->prepare($query);
                $stmt->execute([$dateDebut]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else{
                $query = "select * from {$this->tName} where date_commande > ? and date_commande < ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$dateDebut , $dateFin]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        /**
         * Summary of filtreCommandePartielle
         * @param string $critere => el critere eli bch ysir 3leha el filtrage
         * @param string $data => el data eli bch nesta3melha reellement fl filtrage
         * @return array liste of filtreed data
         */
        public function filtreCommandePartielle(string $critere , string $data){
            $query = "select * from {$this->tName} where ? like '%?%'";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$critere, $data]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }




    }

?>


