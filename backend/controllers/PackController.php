<?php
    require_once(__DIR__ . "/../services/PackServices.php");
    class PackController{
        private PackServices $packServices;
        public function __construct(){$this->packServices = new PackServices();}

        //done
        public function deletePack($request){
            try{
                $param = $request["params"];
                $result = $this->packServices->deletePack(intval($param[0]));
                $response = [
                    "success" => true,
                    "message" => "Suppression de pack",
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "message" => $e->getMessage(),
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }
        }
        
        //done
        public function savePack($request){
            try{
                $body = $request["body"];
                $file = $request["file"];
                $data = json_decode($body["articleList"],true);
                $result = $this->packServices->createPack(  $data,
                                                            floatval($body["prix"]),
                                                            $body["type"],
                                                            $body["categorie"] ,
                                                            $body["libelle"],
                                                            $body["quantite_stock"],
                                                            $file,
                                                            floatval($body["remise"]) ?? 0,
                                                            $body["description"],
                                                            $body["anneeScolaire"] ?? null
                                                            );
                $response = [
                    "success" => true,
                    "numberOfLine" => null,
                    "message" => "New Pack Created SUCCESSFULLY !!!", 
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" =>$e->getMessage(), 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }  
        }
        public function editPack($request){
            try{
                $id = $request["params"][0];
                $body = $request["body"];
                $file = $request["file"];
                $data = json_decode($body["articleList"],true);
                $result = $this->packServices->updatePack(  $id,
                                                            $data,
                                                            floatval($body["prix"]),
                                                            $body["type"],
                                                            $body["categorie"] ?? null ,
                                                            $body["libelle"],
                                                            $body["quantite_stock"],
                                                            $file,
                                                            floatval($body["remise"]) ?? 0,
                                                            $body["description"],
                                                            $body["anneeScolaire"] ?? null
                                                            );
                $response = [
                    "success" => true,
                    "numberOfLine" => null,
                    "message" => "Pack updated successfully", 
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" =>$e->getMessage(), 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }  
        }


        public function getPackById($request){
            try{
                $id = $request["params"][0];
                $result = $this->packServices->getPackById($id);
                $response = [
                    "success" => true,
                    "numberOfLine" => null,
                    "message" => "Getting pack data By ID", 
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" =>$e->getMessage(), 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }  
        }
        public function getPackProduct($request){
            try{
                $id = $request["params"][0];
                $result = $this->packServices->getPackArticles($id);
                $response = [
                    "success" => true,
                    "numberOfLine" => null,
                    "message" => "Getting pack articles By ID", 
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" =>$e->getMessage(), 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }  
        }
    }

?>