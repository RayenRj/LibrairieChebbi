<?php 
    // client Repository : fih kol chay relatif ll client
    require_once(__DIR__ . "/Repository.php");
    require_once(__DIR__ . "/../models/Client.php");
    class ClientRepository extends Repository{ 
        // constructeur : on a une attribut db qui represent le pdo
        public function __construct(){parent::__construct();}



        // ################################
        // Crud Operations
        // ################################
        public function findClientById(int $id){
            $query = "select from client where id_client = ?;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_BOTH)[0];
        }
        public function deleteById(int $id) : bool{
            $query = "delete from client where id_client = ?;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        }
        public function createClient(Client $client): bool{
            $query = "insert into client(nom,prenom,tel,email,password,role) values(?,?,?,?,?,?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$client->getNom(), $client->getPrenom() , $client->getTel(), $client->getEmail(), $client->getPassword() , $client->getRole()]);
        }   
        public function findAllClient(){
            $stmt = $this->db->prepare("select * from client;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }
        public function findAllAdmins(){
            $stmt = $this->db->prepare("select * from client where role = client ;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }
        public function findClientByEmail(string $email){
           $query = "select * from client where email = ? ;"; 
           $stmt = $this->db->prepare($query);
           $stmt->execute([$email]);
           return $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // FETCH_CLASS , "className" => yraja3lk les donné sous formes d'un object client
        }   

        // ###############################################################        
        // function Recherche : recherche des client dans la page User.php and admin.php
        // ###############################################################        
        public function searchClientsById(int $id){
            $query = "select * from client where id_client like '%?%'";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }
        public function searchClientsByNom(string $nom){
            $query = "select * from client where nom like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nom]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }
        public function searchClientsByPrenom(string $prenom){
            $query = "select * from client where prenom like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$prenom]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }
        public function searchClientsByEmail(string $email){
            $query = "select * from client where email like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }
        public function searchClientsByTel(string $tel){
            $query = "select * from client where tel like '%?%' ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$tel]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }

        // ####################################
        // problemmee !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // ####################################
        public function modifyClient(int $id, array $data) : bool{
            $query = "update client set ";
            $params=[];
            if (isset($data["nom"])){
                $query .= " nom = ? , ";
                $params[] = $data["nom"];
            }
            if (isset($data["prenom"])){
                $query .= " prenom = ? , ";
                $params[] = $data["prenom"];
            }
            if (isset($data["tel"])){
                $query .= " tel = ?  , ";
                $params[] = $data["tel"];
            }
            if (isset($data["email"])){
                $query .= " email = ? , ";
                $params[] = $data["email"];
            }
            if (isset($data["password"])){
                $query .= " password = ? , ";
                $params[] = $data["password"];
            }
            if (isset($data["role"])){
                $query .= " role = ? , ";
                $params[] = $data["role"];
            }
            if(empty($params)){return false;}
            $query = substr($query , 0 , -2) . " where id_client = ? ;";
            $params[] = $id;
            $stmt = $this->db->prepare($query);
            return $stmt->execute($params); 
        }
        // #########################
        // Ajouter un admin
        // #########################
        public function addAdmin(string $id): bool{
            $query = "update client set role = 'admin' where id_client = ? ;";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        }

        //email existe
        public function isEmailExist(string $email) : ?array{
            $stmt = $this->db->prepare("select * from client where email = ? ;");
            $stmt->execute([$email]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }

        public function getCommandeByIdClient($idClient) : ?array{
            $query = "select * from commande where id_client = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$idClient]);
            return $stmt->fetch(PDO::FETCH_BOTH) ?: null;
        }
        
    }

?>