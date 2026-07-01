<?php 
    class Router{
        private array $routes=[];
        public function add(string $method ,string $pattern , string $controller , string $action){
            $this->routes[] = compact("method","pattern" , "controller" , "action");
        }
        public function dispatch(){
            $method = $_SERVER["REQUEST_METHOD"];
            $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
            $queryString = parse_url($_SERVER["REQUEST_URI"] , PHP_URL_QUERY) ?? "" ;
            parse_str($queryString , $query);
            foreach($this->routes as $route){
                if($route["method"] !== $method) continue;

                // request method = route method
                // create regex pour remplace chaque {} par ([^/]+)
                $regex = preg_replace("#\{[a-zA-Z_]+\}#","([^/]+)" , $route["pattern"]); // pattern ama fih regex bch nmatchih donc nafs structure el uri just fih des zone de capture
                if(preg_match( "#^$regex$#" , $uri , $matches )){
                    array_shift($matches); // na7iw awel ka3ba 5ater ta3tik match kemel
                    // les restes dans matches ce sont les valeurs capturée
                    
                    try{
                        if(!class_exists($route["controller"])){throw new Exception($route["controller"] . " : cette controller n'existe pas.");}
                        $controller_obj = new $route["controller"]();
                        if(!method_exists($controller_obj , $route["action"])){throw new Exception($route["action"] . " : cette method n'existe pas.");}
                    }catch(Exception $e){
                        http_response_code(500);
                        echo json_encode([
                            "success" => false,
                            "message" => $e->getMessage(),
                            "data" => null,
                            "error" => null
                        ]);
                        return;
                    }

                    $decode_data = file_get_contents("php://input");
                    $body = json_decode($decode_data , true) ;
                    if($body == null){
                        $body = $_POST;
                    }
                    
                    
                    $request = [
                        "params" => $matches,
                        "body" => $body,
                        "query" =>$query,
                        "file" => $_FILES
                    ];

                    call_user_func_array([$controller_obj, $route["action"]] , [$request]);
                    return;
                }
            }
            http_response_code(404);
            echo json_encode([
                "success" => false,
                "message" => "page not found",
                "data" => null,
                "error" => null
            ]);
            return;
        }
    }

?>