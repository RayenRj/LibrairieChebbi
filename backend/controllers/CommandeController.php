<?php
    require_once(__DIR__ . "/../services/CommandeServices.php");

    class CommandeController{
        //el method hedhi tjiblek liste des commande
        private CommandeServices $commande_services;
        private Commande $commande;
        public function __construct()
        {
            $this->commande_services = new CommandeServices();
        }

        // getCommande => donne une liste de commande selon des critere de filtrage et pagination
        public function getCommande($request){
            try{
                $query = $request["query"];
                $body = $request["body"];
                $result = $this->commande_services->getCommandeFiltred($body["data"],
                                                                       $body["critere"],
                                                                       $body["statut"],
                                                                       $body["dateDebut"],
                                                                       $body["dateFin"],
                                                                       $query["limit"],
                                                                       $query["page"]);

                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "getting the commands filtered",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "data" => $e->getMessage(),
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }

        // deleteCommande => api pour supprimer une commande via son identifiat
        public function deleteCommande($request){
            try{
                $param = $request["params"];
                $result = $this->commande_services->deleteCommande($param[0]);
                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "suppression de la commande ayant l'id = " . $param[0],
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }

        //getCommandeById => retourne tous les details d'une commande by ID
        public function getCommandeById($request){
            try{
                $param = $request["params"];
                $result = $this->commande_services->getCommandeById($param[0]);
                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "get commande by ID",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }
        //saveCommande => permet d'enregistrer une commande avec tous ces details
        public function saveCommande($request){
            try{
                $body = $request["body"];
                $result = $this->commande_services->saveCommande($body["id_client"],$body["date_commande"],$body["statut"] ,$body["addresseComplete"] , $body["ville"],$body["codePostal"],$body["prix_totale"],$body["comment"],json_decode($body["ligneCommandes"],true));
                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "inserting commande in the database",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }
        //confirmeeCommande => permet de change la statut de la commande en confirmée
        public function confirmeCommande($request){
            try{
                $param = $request["params"];
                $result = $this->commande_services->confirmeCommande($param[0]);
                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "get commande by ID",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }
        //annuleeCommande => permet de change la statut de la commande en annulée
        public function annuleeCommande($request){
            try{
                $param = $request["params"];
                $result = $this->commande_services->annuleeCommande($param[0]);
                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "get commande by ID",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }
        //livreCommande => permet de change la statut de la commande en Livrée
        public function livreeCommande($request){
            try{
                $param = $request["params"];
                $result = $this->commande_services->livreeCommande($param[0]);
                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "get commande by ID",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }


        // public function addRemise($request){
        //     try{
        //         $param = $request["params"];
        //         $body = $request=["body"];
        //         $result = $this->commande_services->addRemise($param[0]);
        //         $response=[
        //             "success" => true,
        //             "numberOfLine" =>null,
        //             "message" => "get commande by ID",
        //             "data" => $result,
        //             "error" => null
        //         ];
        //         echo json_encode($response);
        //         return;
        //     }catch(Exception $e){
        //         $response=[
        //             "success" => false,
        //             "numberOfLine" => null,
        //             "message" => $e->getMessage(), 
        //             "data" => null,
        //             "error" =>null
        //         ];
        //         echo json_encode($response);
        //         return;
        //     }
        // }


        //done
        public function getCommandeArticles($request){
            try{
                $idCommade = intval($request["params"][0]);
                $result = $this->commande_services->getCommandeArticles($idCommade);
                $response=[
                    "success" => true,
                    "numberOfLine" =>null,
                    "message" => "getting the requested commande articles",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response=[
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" =>null
                ];
                echo json_encode($response);
                return;
            }
        }


        
    }

?>