<?php 
    // commande manager: fih kol ma ykhoss el commandes
    
    require_once(__DIR__ . "/ProductRepository.php");
    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "/../models/Commande.php");
    require_once(__DIR__ . "/../models/LigneCommande.php");
    class CommandeRepository extends Repository{
        //constructor
        private string $tName = "commande";
        private ProductRepository $productRepo;
        public function __construct(){
            parent::__construct();
            $this->productRepo = new ProductRepository();
        }



        // ##################
        // partie CRUD
        // ##################












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

        // partie search 

    /**
         * *
         * @param string $statut => statut ei bch ta3ml 3leha el filtrage
         * @return array liste feha les commandes filtrer selon la  critére
         */
        public function nombreTotaleCommandeCeMois(string $statut){
            $query = "select count(*) from commande where month(date_commande) = month(current_date()) and year(date_commande) = year(curdate()) ";
            $params = [];
            if(!empty($statut)){
                $query .= " AND statut = ? ";
                $params[] = $statut;
            }
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        public function nombreTotaleCommandeDernierMois(string $statut){
            $query = "select count(*) from commande where month(date_commande) = month(current_date() - INTERVAL 1 month) and year(date_commande) = year(curdate() - INTERVAL 1 month) ";
            $params = [];
            if(!empty($statut)){
                $query .= " AND statut = ? ";
                $params[] = $statut;
            }
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
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




        // ###################################
        // ######## Filtrer Commandes ########
        // ###################################

        public function rechercheCommandes(string $data , string $critere , string $statut , string $dateDebut , string $dateFin , int $limit , int $offset){
            $query = "SELECT c.id_commande , c.id_client , c.date_commande , c.statut , c.prix_totale , cli.nom , cli.tel , cli.email
                      from commande c , client cli where c.id_client=cli.id_client ";
            $params = [];
            $critere = mb_strtolower($critere);
            $statut = mb_strtolower($statut);
            if (!empty($data)){
                if($critere == "nom"){
                    $query .= " AND cli.nom like ? " ;
                    $params[] = "%$data%";
                }else if($critere == "telephone"){
                    $query .= " AND cli.tel like ? ";
                    $params[] = "%$data%";
                }else if($critere == "prix"){
                    $query .= " AND c.prix_totale <= ? " ; 
                    $params[] = $data;
                }else if($critere == "email"){
                    $query .= " AND cli.email like ? ";
                    $params[] = "%$data%";
                }else if($critere == "id_commande"){
                    $query .= " AND c.id_commande like ? ";
                    $params[] = "%$data%";
                }
                
                
            }

            if(!empty($statut)){
                $query .= " AND c.statut = ? ";
                $params[] = $statut;
            }

            if(!empty($dateDebut) && !empty($dateFin)){
                $query .= " AND c.date_commande BETWEEN ? and ? ";
                $params[] = $dateDebut;
                $params[] = $dateFin;

            }else if(!empty($dateDebut)){
                $query .= " AND c.date_commande > ? ";
                $params[] = $dateDebut;
            }else if(!empty($dateFin)){
                $query .= " AND c.date_commande < ? ";
                $params[] = $dateFin;
            }


            $query .= " ORDER BY date_commande DESC limit $limit offset $offset ;  ";
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ;
        }
        public function nbreDeLigneDeRecherche(string $data , string $critere , string $statut , string $dateDebut , string $dateFin){
            $query = "SELECT count(*) from commande c , client cli where c.id_client = cli.id_client ";
            $params = [];
            $critere = mb_strtolower($critere);
            $statut = mb_strtolower($statut);
            if (!empty($data)){
                if($critere == "nom"){
                    $query .= " AND cli.nom like ? " ;
                    $params[] = "%$data%";
                }else if($critere == "telephone"){
                    $query .= " AND cli.tel like ? ";
                    $params[] = "%$data%";
                }else if($critere == "prix"){
                    $query .= " AND c.prix_totale <= ? " ; 
                    $params[] = $data;
                }else if($critere == "email"){
                    $query .= " AND cli.email like ? ";
                    $params[] = "%$data%";
                }else if($critere == "id_commande"){
                    $query .= " AND c.id_commande like ? ";
                    $params[] = "%$data%";
                }
                
                
            }

            if(!empty($statut)){
                $query .= " AND c.statut = ? ";
                $params[] = $statut;
            }

            if(!empty($dateDebut) && !empty($dateFin)){
                $query .= " AND c.date_commande BETWEEN ? and ? ";
                $params[] = $dateDebut;
                $params[] = $dateFin;

            }else if(!empty($dateDebut)){
                $query .= " AND c.date_commande > ? ";
                $params[] = $dateDebut;
            }else if(!empty($dateFin)){
                $query .= " AND c.date_commande < ? ";
                $params[] = $dateFin;
            }


            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_NUM)[0] ;
        }

        
        // ###################################
        // ######## CRUD    Commandes ########
        // ###################################
        // save done
        public function saveCommande(Commande $commande) : bool{
            $this->db->beginTransaction();
            try{
                foreach($commande->getCommandeLines() as $ligne_commande){
                    $this->productRepo->decreaseQuantity($ligne_commande->getProduit() , $ligne_commande->getQuantite());
                }
                $query = "INSERT into commande(id_client,date_commande, statut , adresse , ville , code_postal , prix_totale , commentaire) values (?,?,?,?,?,?,?,?)";
                $stmt = $this->db->prepare($query);
                if (!$stmt->execute([$commande->getIdClient() ,
                                $commande->getDateCommande() , 
                                $commande->getStatut(),
                                $commande->getAddresse(),
                                $commande->getVille(),
                                $commande->getCodePostal(),
                                $commande->getPrixTotale(),
                                $commande->getComment()])){throw new Exception(message: "Saving the commande failed!");}
                
                                // decrease every product's quantity

                $id_commande = $this->db->lastInsertId();
                $query2 = "INSERT into ligne_commande(id_commande , id_produit , quantite , sous_total) VALUES ";
                // build insert safely
                $params= [];
                $values= [];
                foreach ($commande->getCommandeLines() as $ligne_commande ){
                    $values[] = "(?,?,?,?)";
                    $params[] = $id_commande;// ici il faut avoir l'id de la commande
                    $params[] = $ligne_commande->getProduit()->getId();
                    $params[] = $ligne_commande->getQuantite(); // quantite
                    $params[] = $ligne_commande->getPrixTotale(); 
                }
                
                if(!empty($values)){
                    $query2 .= implode(",",$values);
                    $stmt = $this->db->prepare($query2);
                    if (!$stmt->execute($params)){throw new Exception("Inserting commande lines failed!");}
                }
                $this->db->commit();
                return true;

            }catch(Exception $e){
                $this->db->rollBack();
                return false;
            }

        }
        // delete done 
        public function delete(int $idCommande){
            $this->db->beginTransaction();
            try{
                $query2 = "delete from ligne_commande where id_commande=? ;";
                $stmt2 = $this->db->prepare($query2);
                if(!($stmt2->execute([$idCommande]))){throw new Exception("Can't delete lines from ligne_commande!");}
                $query = "delete from commande where id_commande = ? ;";
                $stmt = $this->db->prepare($query);
                if(!$stmt->execute([$idCommande])){throw new Exception("Can't delete form the commande table!");}
                $this->db->commit();
                return true;
            }catch(Exception $e){
                $this->db->rollBack();
                return false;
            }
        }

        public function modify(Commande $commande){
            $query = "update commande set id_client = ? ,date_commande = ? , statut = ? , adresse = ? , ville = ? , code_postal = ? , prix_totale = ? , commentaire = ? where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$commande->getIdClient() ,
                                   $commande->getDateCommande() , 
                                   $commande->getStatut() , 
                                   $commande->getAddresse(),
                                   $commande->getVille(),
                                   $commande->getCodePostal(),
                                   $commande->getPrixTotale(),
                                   $commande->getComment(),
                                   $commande->getIdCommande()]);
        }

        // changer le statut de la commande : after actions
        public function changeStatut($id_commande, $new_statut): bool{
            $query = "update commande set statut = ? where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$new_statut,$id_commande]);
        }
        // public function deleteCommandeById($id_commande): bool{
        //     $query = "delete from commande where id_commande = ? ;";
        //     $stmt = $this->db->prepare($query);
        //     return $stmt->execute([$id_commande]);
        // }
        public function getCommandeById($id_commande){
            $query = "select * from commande where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_commande]);
            return $stmt->fetch(PDO::FETCH_BOTH)[0];
        }
        public function getCommandeByIdClient(int $idClient) : ?array{
            $query = "select * from commande where id_client = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idClient]);
            return $stmt->fetch(PDO::FETCH_BOTH);
        }
        
        public function deleteCommandeArticles($id_commande){
            $query = "delete from ligne_commande where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id_commande]);     
        }

        public function getCommandeArticles($id_commande){
            $query = "select * from ligne_commande where id_commande = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_commande]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>


