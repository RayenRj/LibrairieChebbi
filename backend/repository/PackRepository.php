<?php
    include_once(__DIR__ . "/Repository.php");
    include_once(__DIR__ . "/../models/Pack.php");
    
    class PackRepository extends Repository{
        public function __construct(){parent::__construct();}


        // nbre totale de pack
        public function NombreTotalePack() : int{
            $stmt = $this->db->prepare("select count(*) from pack ;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM)[0];
        }


        // pack actif
        public function NombreTotalePackActif() : int{
            $stmt = $this->db->prepare("select count(*) from pack p , produit pr
                                        where p.id_pack = pr.id_produit and pr.quantite_stock > 0;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_NUM)[0];
        }
        // pack en repture 
        public function packEnRepture(): int {return ($this->NombreTotalePack() - $this->NombreTotalePackActif());}

        // revvenue de pack ce mois
        public function revenuePackCeMois(){
            $query = "select "
        }

        // recherche + pagination
    }
?>