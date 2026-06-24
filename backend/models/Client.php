<?php
    // Entity Client + Admin Completed : contains all information about one client
    class Client{
        private int $idClient;
        private string $nom;
        private string $prenom;
        private string $tel;
        private string $email;
        private string $password;
        private string $role;

        public function __construct(string $nom, string $prenom , string $tel , string $email , string $pass , string $role){
            $this->nom  = $nom;
            $this->prenom = $prenom;
            $this->tel = $tel;
            $this->password = $pass;
            $this->email = $email;
            $this->role = $role;
        }


        //getter
        public function getIdClient(){return $this->idClient;}
        public function getNom(){return $this->nom;}
        public function getPrenom(){return $this->prenom;}
        public function getEmail(){return $this->email;}
        public function getTel(){return $this->tel;}
        public function getPassword(){return $this->password;}
        public function getRole(){return $this->role;}

        //setter
        public function setIdClient(int $id){$this->idClient = $id;}
        public function setNom(string $nom){$this->nom=$nom;}
        public function setPrenom(string $prenom){$this->prenom=$prenom;}
        public function setEmail(string $email){$this->email=$email;}
        public function setTel(string $tel){$this->tel = $tel;}
        public function setPassword(string $password){$this->password=$password;}
        public function setRole(string $role){$this->role = $role;}

        // tosting function
        public function __toString()
        {
            return  "nom : " . $this->getNom() .
                    " Prenom = " . $this->getPrenom() . 
                    " Email : " . $this->getEmail() . 
                    " Password : " . $this->getPassword() . 
                    " tel : " . $this->getTel() . 
                    " Role : " . $this->getRole();
        }




    }




?>