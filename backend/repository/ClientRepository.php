<?php 
    require_once(__DIR__ . "/IRepository.php");
    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "../models/Client.php");
    class ClientRepository extends Repository{ 
        // constructeur : on a une attribut db qui represent le pdo
        public function __construct(){parent::__construct();}



        // ################################
        // trouver une seule personne by id
        // ################################
        public function findClientById(int $id){
            $query = "select from client where id_client = ?;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ###############################################################        
        // function Recherche : recherche des client dans la page User.php
        // ###############################################################        
        public function searchClientsById(int $id){
            $query = "select * from client where id_client like '%?%'";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function searchClientsByNom(string $nom){
            $query = "select * from client where nom like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nom]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function searchClientsByPrenom(string $prenom){
            $query = "select * from client where prenom like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$prenom]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function searchClientsByEmail(string $email){
            $query = "select * from client where email like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function searchClientsByTel(string $tel){
            $query = "select * from client where tel like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$tel]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        // #########################
        // delete une seule personne
        // #########################
        public function deleteById(int $id) : bool{
            $query = "delete from client where id_client = ?;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        }



        // #########################
        // inserer un nouveau client
        // #########################
        public function createClient(Client $client){
            $query = "insert into client values(?,?,?,?,?,?,?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$client->getIdClient(), $client->getNom(), $client->getPrenom() , $client->getTel(), $client->getEmail(), $client->getPassword() , $client->getRole()]);
        }   

        
        // ####################################
        // modifier un client apartir de son id
        // ####################################
        public function modifyClient(string $id) : bool{
            $query = "update client set nom=? , prenom=? , tel=? , email=? , password=? where id_client=?;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]); 
        }

        
    }

?>