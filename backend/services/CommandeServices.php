<?php
    require_once(__DIR__ . "/../models/Commande.php");
    require_once(__DIR__ . "/../models/Product.php");
    require_once(__DIR__ . "/../models/Pack.php");
    require_once(__DIR__ . "/../models/LigneCommande.php");
    require_once(__DIR__ . "/../repository/CommandeRepository.php");
    require_once(__DIR__ . "/../repository/ProductRepository.php");
    require_once(__DIR__ . "/../repository/PackRepository.php");
    require_once(__DIR__ . "/../repository/ClientRepository.php");


    class CommandeServices{
        private CommandeRepository $commande_repo;
        private ProductRepository $product_repo;
        private ClientRepository $client_repo;
        private Commande $commande;
        public function __construct(){
            $this->commande_repo = new CommandeRepository();
            $this->product_repo = new ProductRepository();
            $this->client_repo = new ClientRepository();
        }

        //done
        public function getCommandeFiltred(string $data , string $critere , string $statut , string $dateDebut , string $dateFin , int $limit , int $page){
            if($limit <0 ){throw new Exception("La Limite ne peux pas etre négatif");}
            if($page <0 ){throw new Exception("La offset ne peux pas etre négatif");}
            if(!in_array($statut ,["",'attente','confirmée','annulée','livrée'])){throw new Exception("la staut n'est pas valide");}
            if(!in_array($critere,["","nom","tel","email","prix_totale","id_commande"])){throw new Exception("la critére n'est pas valide");}
            if(strcmp($dateFin , $dateDebut)<0 ){throw new Exception("Error : dateFin < dateDebut");}
            $offset = ($page - 1) * $limit;
            return $this->commande_repo->rechercheCommandes($data , $critere , $statut , $dateDebut , $dateFin , $limit , $offset);
        }
        public function nbreDeLigneDeRecherche(string $data , string $critere , string $statut , string $dateDebut , string $dateFin){
            if(!in_array($statut ,["",'attente','confirmée','annulée','livrée'])){throw new Exception("la staut n'est pas valide");}
            if(!in_array($critere,["","nom","tel","email","prix_totale","id_commande"])){throw new Exception("la critére n'est pas valide");}
            if(strcmp($dateFin , $dateDebut)<0 ){throw new Exception("Error : dateFin < dateDebut");}
            return $this->commande_repo->nbreDeLigneDeRecherche($data , $critere , $statut , $dateDebut , $dateFin);
        }
        //done
        // public function creeCommande(int $id_client, string $addresse , string $ville , string $codePostal , string $comment , array $ligneCommandes) : bool{ 
        //     $dateCommande = (new DateTime('now'))->format("Y-m-d");
        //     $statut = "attente";
        //     if(empty($id_client)){throw new Exception("l'identifiant du client ne doit pas etre vide!");}
        //     if(empty($addresse)){throw new Exception("l'addresse doit etre non vide!");}
        //     if(empty($ville)){throw new Exception("la ville doit etre non vide");}
        //     if(empty($ligneCommandes)){throw new Exception("La commande doit contenir au moins un produit!");}

        //     $somme= 0;
        //     foreach($ligneCommandes as $ligneCommande){
        //         $article = $ligneCommande->getProduit();
        //         $quantite = $ligneCommande->getQuantite();
        //         $prix_tot = $ligneCommande->getPrixTotale();
        //         if($quantite > $article->getStock()){
        //             throw new Exception("La quantite est supérieure au stock!");
        //         }
        //         $somme += $prix_tot;

        //     }

        //     $commande = new Commande(mb_strtolower($id_client),$dateCommande, $statut , $addresse , $ville , $codePostal , $somme , $comment , $ligneCommandes);
        //     return $this->commande_repo->saveCommande($commande);
        // }
        //done
        public function deleteCommande(int $idCommande) : bool{
            if($idCommande <= 0){
                throw new Exception("L'identifiant de la commande doit etres > 0 !");
            }
            if($this->commande_repo->getCommandeById($idCommande) === null){
                throw new Exception("Cette Commande n'existe pas .");
            }
            
            if(!($this->commande_repo->delete($idCommande))){
                throw new Exception("L'operation de suppression du commande echoue");
            }
            return true;
        }
        //done
        public function confirmeCommande(string $id_commande) : bool{
            if(!empty($id_commande)){
                $this->commande_repo->changeStatut($id_commande , "confirmée");
                return true;
            }
            return false;
        }
        //done
        public function annuleeCommande(string $id_commande) : bool{
            if(!empty($id_commande)){
                $this->commande_repo->changeStatut($id_commande , "annulée");
                return true;
            }
            return false;
        }
        //done
        public function livreeCommande(string $id_commande) : bool{
            if(!empty($id_commande)){
                $this->commande_repo->changeStatut($id_commande , "livrée");
                return true;
            }
            return false;
        }
        //done
        public function getCommandeById(int $id){
            if($id < 0){throw new Exception("l'identifiant du commande ne doit pas etre negatif!");}
            $commande = $this->commande_repo->getCommandeById($id);
            if($commande == null){
                throw new Exception("Cette Identifiant ne correspond a aucune commande!");
            }
            return $commande;
        }
        //done
        public function getCommandeByClient(int $idClient) : ?array{
            if($idClient < 1){throw new Exception("L'identifiant du client doit etre > 0 !!");}
            if($this->client_repo->findClientById($idClient) === null){throw new Exception("Cette Client n'existe pas dans la base !");}

            return $this->commande_repo->getCommandeByIdClient($idClient);
    
        }
        //done
        public function getAllCommandes(int $id , int $limit , int $page){
        }
        //done
        public function nombreTotaleCommandeCeMois(string $statut){
            if(!in_array($statut, ["",'attente','confirmée','annulée','livrée'])){throw new Exception("Le status de la commande est invalide!");}
            return $this->commande_repo->nombreTotaleCommandeCeMois($statut);
        }
        //done
        public function nombreTotaleCommandeDernierMois(string $statut){
            if(!in_array($statut, ["",'attente','confirmée','annulée','livrée'])){throw new Exception("Le status de la commande est invalide!");}
            return $this->commande_repo->nombreTotaleCommandeDernierMois($statut);
        }
        //done
        public function saveCommande(string $idClient , string $dateCommande , string $statut , string $addresse , string $ville , string $codePostal , string $prixTotale , string $comment ,array $ligneCommandes){
            if($idClient < 1 ){throw new Exception("La valeur de l'identifiatn de client qui passe la commande est invalide!");}
            if(empty($dateCommande)){throw new Exception("La date de commande est vide!");}
            if(empty($statut)){throw new Exception("La statut de commande est vide!");}
            if(!in_array($statut,['attente','confirmée','annulée','livrée'])){throw new Exception("La statut de commande est invalide!");}
            if(empty($addresse)){throw new Exception("L'addresse du client est vide!");}
            if(empty($ville)){throw new Exception("L'ville du client est vide!");}
            if($prixTotale < 0){throw new Exception("Prix totale de la commande est invalide!");}
            if(empty($ligneCommandes)){throw new Exception("La Liste des articles de la commande est vide!");}
            return $this->commande_repo->saveCommande($idClient , $dateCommande ,  $statut ,  $addresse ,  $ville ,  $codePostal ,  $prixTotale ,  $comment , $ligneCommandes);
        }
        //done 
        public function getCommandeArticles(int $idCommande){
            if($idCommande < 1 ){throw new Exception("La valeur de l'identifiatn de client qui passe la commande est invalide!");}
            return $this->commande_repo->getCommandeArticles($idCommande);
        }
        
    
}

















?> 