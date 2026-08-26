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
                    "message" =>$e->getMessage() . " . image type : " . $file["packImage"]["type"], 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }  
        }
    }

?>