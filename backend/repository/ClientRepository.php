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
            $query = "select * from client where id_client = ?;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function deleteById(int $id) : bool{
            $query = "delete from client where id_client = ? ";
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
        public function findAllAdmins(int $limit , int $offset){
            $stmt = $this->db->prepare("select * from client where role = 'admin' limit $limit offset $offset");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
        }

        public function nombreLigneAllAdmin(){
            $stmt = $this->db->prepare("select count(*) from client where role = 'admin' ");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0] ?: null;
        }
        public function findClientByEmail(string $email){
           $query = "select * from client where email = ? ;"; 
           $stmt = $this->db->prepare($query);
           $stmt->execute([$email]);
           return $stmt->fetch(PDO::FETCH_ASSOC); // FETCH_CLASS , "className" => yraja3lk les donné sous formes d'un object client
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
            $query = "select * from client where email like ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute(["%$email%"]);
            return $stmt->fetch(PDO::FETCH_BOTH) ?: null;
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
            // if (isset($data["email"])){
            //     $query .= " email = ? , ";
            //     $params[] = $data["email"];
            // }
            if (isset($data["password"])){
                $query .= " password = ? , ";
                $params[] = password_hash($data["password"],PASSWORD_DEFAULT);
            }
            if(isset($data["role"])){
                $query .= " role = ? , ";
                $params[] = $data["role"];
            }
            if(isset($data["addresse"])){
                $query .= " addresse = ? , ";
                $params[] = $data["addresse"];
            }
            if(empty($params)){return false;}
            $query = substr($query , 0 , -2) . " where id_client = ? ";
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
        

        // recherche client
        public function searchClient(string $idClient , string $nom , string $prenom , string $email , string $tel , int $limit , int $offset){
            $nom = trim(mb_strtolower($nom));
            $idClient = trim(mb_strtolower($idClient));
            $prenom = trim(mb_strtolower($prenom));
            $email = trim(mb_strtolower($email));
            $tel = trim(mb_strtolower($tel));

            $query = "select * from client ";
            $params=[];
            $query_list=[];
            if(!empty($idClient)){
                $query_list[] = "id_client = ?";
                $params[] = $idClient;
            }

            if(!empty($nom)){
                $query_list[] = "nom = ?";
                $params[] = $nom;                
            }
            if(!empty($prenom)){
                $query_list[] = "prenom = ?";
                $params[] = $prenom;   
            }
            if(!empty($email)){
                $query_list[] = "email = ?";
                $params[] = $email;   
            }
            if(!empty($tel)){
                $query_list[] = "tel = ?";
                $params[] = $tel;   
            }

            if(sizeof($params)>0){
                $query .= " where ";
                $query .= implode(" and " , $query_list); 
            }
            $query .= " LIMIT $limit OFFSET $offset ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function nombreDeLigneSearchClient(string $idClient , string $nom , string $prenom , string $email , string $tel){
            $nom = trim(mb_strtolower($nom));
            $idClient = trim(mb_strtolower($idClient));
            $prenom = trim(mb_strtolower($prenom));
            $email = trim(mb_strtolower($email));
            $tel = trim(mb_strtolower($tel));

            $query = "select count(*) from client ";
            $params=[];
            $query_list=[];
            if(!empty($idClient)){
                $query_list[] = "id_client = ?";
                $params[] = $idClient;
            }

            if(!empty($nom)){
                $query_list[] = "nom = ?";
                $params[] = $nom;                
            }
            if(!empty($prenom)){
                $query_list[] = "prenom = ?";
                $params[] = $prenom;   
            }
            if(!empty($email)){
                $query_list[] = "email = ?";
                $params[] = $email;   
            }
            if(!empty($tel)){
                $query_list[] = "tel = ?";
                $params[] = $tel;   
            }

            if(sizeof($params)>0){
                $query .= " where ";
                $query .= implode(" and " , $query_list); 
            }
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
        public function getClietIdByEmail(string $email){
            $query = "select id_client from client where email = ? ;";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC)["id_client"] ?: null;
        }


    }



?>