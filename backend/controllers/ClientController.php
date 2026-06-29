<?php 
    // $base_url = "/librairie/LibrairieChebbi/";
    // include_once $base_url . "backend/services/ClientServices.php";
    include_once __DIR__ . "/../services/ClientServices.php";
    class ClientController {
        private ClientServices $clientServices;
        public function __construct(){
            $this->clientServices = new ClientServices();
        }

        //done
        public function signIn($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->authenticate($body["email"], $body["password"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by Email",
                    "numberOfLine" =>null,
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
        public function SignUp($request){
            try{
                $body = $request["body"];
                $res =  $this->clientServices->createClient($body["lastName"],$body["firstName"],$body["tel"],$body["email"], $body["password"]);
                $_SESSION["userId"] = $this->clientServices->lastInsertedId();
                $_SESSION["firstName"] = $body["firstName"];
                $_SESSION["lastName"] = $body["lastName"];
                $response = [
                    "success" => true,
                    "message" => "Client Created successfully",
                    "redirect" => null,
                    "data" => $res,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "message" => $e->getMessage(),
                    "data" =>null,
                    "error" => null
                ];
                echo json_encode($response);
                return;      
            }
        }
        //done
        public function createClient($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->createClient($body["lastName"], $body["firstName"],$body["tel"],$body["email"],$body["password"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by Email",
                    "numberOfLine" =>null,
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
        // done
        public function getAllClients($request){
            try{
                $response = [
                    "success" => true,
                    "message" => "",
                    "data" => $this->clientServices->getAllClients(),
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }catch(Exception $e){
                $response = [
                    "success" => false,
                    "message" => $e->getMessage(),
                    "data" => null ,
                    "error" => null
                ];
                echo json_encode($response);
                return;
            }
        }
        //done
        public function getAllAdmins($request){
            try{
                $response = [
                    "success" => true,
                    "message" => "Getting List of all Admins",
                    "data" => $this->clientServices->getAllAdmins(),
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
        public function findClientByEmail($request){
            try{
                $body = $request["body"];
                $response = [
                    "success" => true,
                    "message" => "Finding Client by Email",
                    "data" => $this->clientServices->findClientByEmail($body["email"]),
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
        public function getClientById($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->getClientById($body["idClient"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by id",
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
        //done
        public function deleteClient($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->deleteClient($body["idClient"]);
                $response = [
                    "success" => true,
                    "message" => "checking if the email exist",
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


        //done
        public function isEmailTaken($request){
            try{
                $response = [
                    "success" => true,
                    "message" => null,
                    "data" => $this->clientServices->isEmailTaken($request["body"]["email"]),
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
        public function updateClient($request){
            try{
                $response = [
                    "success" => true,
                    "message" => "Client updated successfully",
                    "data" => $this->clientServices->modifyClient($request["body"]["idClient"],$request["body"]),
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
        public function addAdmin($request){
            try{
                $response = [
                    "success" => true,
                    "message" => "add Admin successfully",
                    "data" => $this->clientServices->addAdmin($request["body"]["idClient"]),
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
        public function getAllCommandesByIdClient($request){
            try{
                $response = [
                    "success" => true,
                    "message" => "add Admin successfully",
                    "data" => $this->clientServices->getCommandeByIdClient($request["body"]["idClient"]),
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
        public function isEmailExist($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->isEmailExist($body["email"]);
                $response = [
                    "success" => true,
                    "message" => "checking if the email exist",
                    "numberOfLine" => sizeof($result),
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


        //#####################################################
        // Partie Search
        //#####################################################
        //done
        public function searchClientById($request){
            try{
                $body = $request["body"];
                $result= $this->clientServices->searchClientById($body["idClient"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by Id",
                    "numberOfLine" => sizeof($result),
                    "data" =>$result,
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
        public function searchClientsByNom($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->searchClientById($body["lastName"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by last name",
                    "numberOfLine" => sizeof($result),
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
        public function searchClientsByPrenom($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->searchClientsByPrenom($body["firstName"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by First Name",
                    "numberOfLine" => sizeof($result),
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
        public function searchClientsByTel($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->searchClientsByTel($body["tel"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by tel",
                    "numberOfLine" => sizeof($result),
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
        public function searchClientsByEmail($request){
            try{
                $body = $request["body"];
                $result = $this->clientServices->searchClientsByEmail($body["email"]);
                $response = [
                    "success" => true,
                    "message" => "Finding Client by Email",
                    "numberOfLine" => sizeof($result),
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
        //#####################################################
        //#####################################################







    }


?>