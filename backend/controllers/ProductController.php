<?php

    include __DIR__ . "/../services/ProductServices.php";
    class ProductController{
        private ProductServices $productServices;
        public function __construct(){
            $this->productServices = new ProductServices();
        }


        //done
        public function getProductById($request){
            try{
                $body = $request["body"];
                $result = $this->productServices->getProductById($body["idProduct"]);
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
        public function rechercherUnArticle($request){
            try{
                $body = $request["body"];
                $query = $request["query"];
                $result = $this->productServices->rechercherArticle($body["idProduct"] , );
                
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

    }


?>