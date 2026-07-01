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
                $result = $this->commande_services->saveCommande($body["idClient"],$body["dateCommande"],$body["statut"] ,$body["addresse"] , $body["ville"],$body["codePostal"],$body["prixTotale"],$body["comment"],$body["ligneCommandes"]);
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





        
    }

?>