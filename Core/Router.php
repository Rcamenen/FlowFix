<?php
namespace Core;

use Exception;
use PDOException;
use App\Exceptions\AuthenticateException;
use App\Exceptions\AuthorizationException;
use App\Exceptions\RoleException;
use App\Exceptions\FormException;

class Router{

    private array $AVAILABLES_ROUTES;

    public function __construct($AVAILABLES_ROUTES){

        $this->AVAILABLES_ROUTES = $AVAILABLES_ROUTES;

    }

    public function getController(){

        $action = $this->parseRoute();

        if($action){
            $controller=null;
            try{

                $controller = new $action["controller"];
                $method = $action["method"];

                $controller->$method($action["params"]);

            }catch(FormException $e){

                $_SESSION["error"]=$e->getMessage();
                $_SESSION["formErrors"]=$e->getErrors();
                header("Location: /".$e->getView());
                exit;

            }catch(RoleException $e){

                $_SESSION["error"]=$e->getMessage();
                header("Location: /".$e->getView());
                exit;

            }catch(PDOException $e){

                echo $e->getMessage();

            }catch(Exception $e){

                echo $e->getMessage();
                header("Location: /");

            }
            

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
        
        //Chargement des routes dispos
        $AVAILABLES_ROUTES = $this->AVAILABLES_ROUTES[$requestMethod];

        foreach($AVAILABLES_ROUTES as $pattern => $action){

            if(!empty($params))unset($params);

            $pattern = explode("/",trim($pattern,"/"));
            
            if(count($pattern)==count($requestedPath)){
                
                $match = true;

                for ($i=0; $i < count($pattern) ; $i++) {

                    if((str_starts_with($pattern[$i],"{") && str_ends_with($pattern[$i],"}")) && is_numeric($requestedPath[$i])){

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