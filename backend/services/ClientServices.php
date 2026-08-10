<?php
    
    require_once(__DIR__ . "/../repository/ClientRepository.php");
    require_once(__DIR__ . "/../models/Client.php");
    class ClientServices{
        private ClientRepository $clientRepo;

        public function __construct(){
            $this->clientRepo = new ClientRepository();
        }
        


        //done
        public function getClientById(int $id){
            if($id < 1){throw new Exception("L'id du client doit etres > 1");}
            return $this->clientRepo->findClientById($id);
        }

        //done :
        public function authenticate(string $email , string $password){
            $email = trim($email);
            $password = trim($password);
            if(empty($email)){throw new Exception("Email est vide!");}
            if(empty($password)){throw new Exception("password est vide!");}
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){throw new Exception("Email est invalide!");}
            $client = $this->clientRepo->findClientByEmail($email);
            if($client === null || $client === false){return false;}
            $password_hash = $client['password'];
            if(password_verify($password , $password_hash)){return $client;}
            return false;
        }

        
        public function searchClientsByEmail($email){
            return $this->clientRepo->searchClientsByEmail($email);
        }
        //done
        public function getAllClients() : array{
            return $this->clientRepo->findAllClient();
        }

        //done
        public function deleteClient(int $id) : bool {
            if($id<1){throw new Exception("L'identifiant doit etre > 0");}
            if($this->clientRepo->findClientById($id) === null){throw new Exception("Cette id ne correspond a aucun client!");}
            if(!($this->clientRepo->deleteById($id))){throw new Exception("Delete Client failed!");}
            return true;
        }
        //done
        public function createClient(string $nom , string $prenom , string $tel, string $email , string $password){
            $nom = trim($nom);
            $prenom = trim($prenom);
            $tel = trim($tel);
            $email = trim($email);
            if(empty($nom)){throw new Exception("Nom est vide!");}
            if(empty($prenom)){throw new Exception("Prenom est vide!");}
            // if(empty($tel) || !preg_match("/^[0-9]{8,15}$/", $tel)){throw new Exception("numero telephone est vide!");}
            // if(empty($password) || strlen($password) < 6){throw new Exception("password est invalide!");}
            if(empty($email) || !filter_var($email , FILTER_VALIDATE_EMAIL)){throw new Exception("Email est invalide!");}
            $password_hash = password_hash($password , PASSWORD_DEFAULT);
            $client = new Client($nom , $prenom , $tel , $email , $password_hash , "client", "");
            $result = $this->clientRepo->createClient($client);
            if(!$result){throw new Exception("L'insertion du client echoue !!");}
            return true;
        }   
        // Teste Si l'email est taken
        public function isEmailTaken(string $email): bool{
            if(empty($email)){throw new Exception("Email est vide !");}
            if(!filter_var($email , FILTER_VALIDATE_EMAIL)){throw new Exception("Email invalide!");};
            return $this->clientRepo->isEmailExist($email) !== null;
        }

        //done
        public function getAllAdmins(int $limit ,int $page) : ?array {
            if($limit<1){throw new Exception("La limite est invalide!");}
            if($page<1){throw new Exception("La valeur de la page est invalide!!");}
            return $this->clientRepo->findAllAdmins($limit , ($page - 1) * $limit);
        }
        //done
        public function updateClient(int $idClient , array $data) : bool{
            if($idClient <1){throw new Exception("l'id ne peux pas etre <= 0");}
            if(empty($data)){throw new Exception("le tableau de données est vide!");}
            $result = $this->clientRepo->modifyClient($idClient, $data);
            if(!$result){throw new Exception("Error lors de l'update du client row!");}
            return $result;
        }
        //done
        public function changePassword(int $idClient , string $newPassword){
            if($idClient <1){throw new Exception("l'id ne peux pas etre <= 0");}
            if(empty($newPassword)){throw new Exception("New password est vide!");}
            $data = ["password"=>password_hash($newPassword, PASSWORD_DEFAULT)];
            return $this->clientRepo->modifyClient($idClient,$data);
        }
        //done
        public function getClientOrders(int $idClient) : ?array{
            if($idClient <1){throw new Exception("l'id ne peux pas etre <= 0");}
            if($this->clientRepo->findClientById($idClient) === false){throw new Exception("Le client avec cette ID n'existe pas!");}
            return $this->clientRepo->getCommandeByIdClient($idClient) ?: null;
        }
        public function lastInsertedId(){
            return $this->clientRepo->lastInsertedId();
        }
        //done
        public function addAdmin(int $idClient){
            return $this->clientRepo->addAdmin($idClient);
        }
        //done
        public function removeAdmin(int $idClient){
            return $this->clientRepo->modifyClient($idClient, ["role" => "client"]);
        }

        //done
        public function nombreLigneAllAdmin(){return $this->clientRepo->nombreLigneAllAdmin();}

        //done
        public function searchClient(string $idClient , string $nom , string $prenom , string $email , string $tel , int $limit , int $page){
            if($limit < 1){throw new Exception("La limite est invalide!");}
            if($page < 1){throw new Exception("La page est invalide!page");}
            $offset = ($page - 1) * $limit;
            return $this->clientRepo->searchClient($idClient , $nom , $prenom , $email , $tel , $limit, $offset);
        }
        public function nombreDeLigneSearchClient(string $idClient , string $nom , string $prenom , string $email , string $tel){
            return $this->clientRepo->nombreDeLigneSearchClient($idClient , $nom , $prenom , $email , $tel);
        }

        public function getClietIdByEmail($email){
            return $this->clientRepo->getClietIdByEmail($email);
        }

    }
?>