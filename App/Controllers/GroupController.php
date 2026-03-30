<?php
namespace App\Controllers;
use App\Services\GroupService;
use Core\BaseController;
use Exception;
use App\Exceptions\ForbiddenException;
use App\Exceptions\UnauthorizedException;
use PDOException;

class GroupController extends BaseController{

    /** home()
     * Retrieve group's home data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (groupId, ...)
     * @return void Render group home view in case of success, throw exception if not
     */

    public function home($params){

        try{

            if(isset($_SESSION["userId"])){

                $userId = $_SESSION["userId"];
                $groupId = $params["groupId"];
                $groupService = new GroupService();
                $response["data"]=$groupService->home($userId,$groupId);

            }else throw new UnauthorizedException("Vous devez être connecté pour voir cette page...");

            $this->renderView("groupHome",$response ?? null);

        }catch(PDOException $e){
            echo $e->getMessage();
            // $response["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            // $this->renderView("groupsPanel",$response);

        }catch(ForbiddenException $e){

            echo $e->getMessage();

        }catch(UnauthorizedException $e){

            echo $e->getMessage();

        }
        catch(Exception $e){
            
            echo $e->getMessage();
            // $response["accessRightsError"] = $e->getMessage();
            // header("Location: \home");

        }
        


    }
}

?>