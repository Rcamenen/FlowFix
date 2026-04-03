<?php
namespace Core;

class Router{

    private array $AVAILABLES_ROUTES;

    public function __construct($AVAILABLES_ROUTES){

        $this->AVAILABLES_ROUTES = $AVAILABLES_ROUTES;
        echo "Routeur chargé ! <br>";
        echo "=================<br><br>";
        echo "La route demandée est la suivante : <br><br>";

    }

    public function getController(){

        $action = $this->parseRoute();

        if($action){

            $controller = new $action["controller"];
            $method = $action["method"];

            $controller->$method($action["params"]);

        }else{

            header("Location: /404?message=test");

        }
        

    }

    public function parseRoute(){

        //Récupération de la méthode de la requête HTTP
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        //Récupération de l'url
        $uri = $_SERVER['REQUEST_URI'];

        //Récupération du chemon demandé
        $requestedPath = parse_url($uri,PHP_URL_PATH);
        $requestedPath = explode("/",trim($requestedPath,"/"));
        var_dump($requestedPath);
        echo "<br><br>=================<br>";

        //Chargement des routes dispos
        $AVAILABLES_ROUTES = $this->AVAILABLES_ROUTES[$requestMethod];

        foreach($AVAILABLES_ROUTES as $pattern => $action){

            if(!empty($params))unset($params);

            $pattern = explode("/",trim($pattern,"/"));
            
            if(count($pattern)==count($requestedPath)){
                
                $match = true;

                for ($i=0; $i < count($pattern) ; $i++) {

                    if(str_starts_with($pattern[$i],"{") && str_ends_with($pattern[$i],"}")){

                        $param = trim($pattern[$i],"{}");
                        $$param = $requestedPath[$i];
                        $params[$param]=$$param;

                    }
                    else if($pattern[$i]!=$requestedPath[$i]){

                        $match=false;

                    }

                }

                if($match) return ["controller"=>$action["controller"],"method"=>$action["method"],"params"=>$params ?? null];

            }

        }

    }


}

?>