<?php
    // header('Content-Type: application/json');
    include __DIR__ . "/../services/ProductServices.php";
    class ProductController{
        private ProductServices $productServices;
        public function __construct(){
            $this->productServices = new ProductServices();
        }


        //done
        public function getProductById($request){
            try{
                $params = $request["params"];
                $result = $this->productServices->getProductById(intval($params[0]));
                $response = [
                    "success" => true,
                    "message" => "Finding Client by Email",
                    "numberOfLine" => null,
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;

            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(),
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }
        }
        
        //
        // public function rechercherUnArticle($request){
        //     try{
        //         $body = $request["body"];
        //         $query = $request["query"];
        //         $result = $this->productServices->rechercherArticle($body["idProduct"] , );
                
        //         $response = [
        //             "success" => true,
        //             "message" => "Finding Client by Email",
        //             "numberOfLine" => null,
        //             "data" => $result,
        //             "error" => null
        //         ];
        //         echo json_encode($response);
        //         return;

        //     }catch(Exception $e){
        //         $response = [
        //             "success" => false,
        //             "numberOfLine" => null,
        //             "message" => $e->getMessage(),
        //             "data" => null,
        //             "error" => null
        //         ];
        //         echo json_encode($response);
        //         return;
        //     } 
        // }

        //done
        public function addProduct($request){
            try{
                $image = $request["file"]["image"];
                $body = $request["body"];
                $result = $this->productServices->createProduct($body["libelle"] ,
                                                                floatval($body["prix"]), 
                                                                intval($body["quantity"]),
                                                                $body["categorie"], 
                                                                $body["marque"], 
                                                                floatval($body["remise"]) ?? 0 , 
                                                                $body["description"],
                                                                $image,
                                                                $body["codeBarre"]);
                $response = [
                    "success" => true,
                    "numberOfLine" => null,
                    "message" => "Article Added successfully", 
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }

        }
        //done
        public function getAllProduct($request){
            
            try{
                $query = $request["query"];
                $result = $this->productServices->getAllProduct($query["limit"],$query["page"]);
                $response = [
                    "success" => true,
                    "numberOfLine" => sizeof($result),
                    "message" => "getting all products successfully", 
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }   
        }
        
        public function rechercherArticle($request){
            try{
                $query = $request["query"];
                $result = $this->productServices->rechercherArticle($query["categorie"] ?? "",$query["libelle"] ?? "",$query["prixMax"] ?? 0,$query["prixMin"] ?? 0,$query["stock"] ?? "",$query["trie"] ?? "" ,$query["limit"] ?? 1 ,$query["page"] ?? 1);
                $response = [
                    "success" => true,
                    "numberOfLine" => $this->productServices->nombreLigneRechercherArticle($query["categorie"] ?? "",$query["libelle"] ?? "",$query["prixMax"] ?? 999999,$query["prixMin"] ?? 0,$query["stock"] ?? "",$query["trie"] ?? "" ,$query["limit"] ?? 1 ,$query["page"] ?? 1),
                    "message" => "getting all products successfully", 
                    "data" => $result,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "numberOfLine" => null,
                    "message" => $e->getMessage(), 
                    "data" => null,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            } 
        }

}


?>