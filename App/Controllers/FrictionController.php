<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\FrictionService;
use App\Services\UserService;

use App\Exceptions\RoleException;

class FrictionController extends BaseController{

    private FrictionService $frictionService;
    private UserService $userService;

    public function __construct(){
        $this->frictionService = new FrictionService;
        $this->userService = new UserService;
;
    }

    /** showFrictionPage()
     * Retrieve friction data using session and route parameters & render the friction details view.
     * 
     * @param {Array} $params : Array which contain route params (teamId, frictionId, ...)
     * @return void Render friction details view in case of success, throw exception if not
     */
    public function showFrictionPage($params){

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $userId = $_SESSION["userId"] ?? null;
        $currentTeamId = $params["teamId"] ?? null;
        $frictionId = $params["frictionId"] ?? null;

        $data = $this->frictionService->getFrictionData($frictionId,$currentTeamId,$userId);
        $data["teamId"] = (string) $currentTeamId;

        $this->renderView("/team/friction/frictionDetails",$data);

    }

    /** createFriction()
     * Collect POST data and route parameters, structure them & delegate friction creation to the service.
     * Redirect to the newly created friction page on success.
     * 
     * @param {Array} $params : Array which contain route params (teamId, ...)
     * @return void Redirect to the friction page in case of success, throw exception if not
     */
    public function createFriction($params){

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $this->checkAccess($params);

        // Récupération et structuration des données pour appel au service
        $createFrictionData = $this->getPost(["title","description"]);
        $createFrictionData["userId"]=$_SESSION["userId"];
        $createFrictionData["teamId"]=$params["teamId"];

        // Appel au service
        $frictionCreatedId = $this->frictionService->createFriction($createFrictionData);

        header("Location:".BASE_URL."/team/".$createFrictionData["teamId"]."/friction/".$frictionCreatedId["id"]);
        
    }

    /** voteFriction()
     * Collect session and route parameters & delegate the friction vote registration to the service.
     * Redirect to the friction page on success.
     * 
     * @param {Array} $params : Array which contain route params (teamId, frictionId, ...)
     * @return void Redirect to the friction page in case of success, throw exception if not
     */
    public function voteFriction($params){

        echo "<br> FrictionController->voteFriction : <br><br>";

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $userId = $_SESSION["userId"];
        $teamId = $params["teamId"];
        $frictionId = $params["frictionId"];

        $this->frictionService->voteFriction($userId,$teamId,$frictionId);

        header("Location:".BASE_URL."/team/".$teamId."/friction/".$frictionId);

    }

    /** voteTreatment()
     * Collect session and route parameters & delegate the treatment vote registration to the service.
     * Redirect to the parent friction page on success.
     * 
     * @param {Array} $params : Array which contain route params (teamId, frictionId, treatmentId, voteResult, ...)
     * @return void Redirect to the friction page in case of success, throw exception if not
     */
    public function voteTreatment($params){

        echo "<br> FrictionController->voteFriction : <br><br>";

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $userId = $_SESSION["userId"];
        $teamId = $params["teamId"];
        $treatmentId = $params["treatmentId"];
        $frictionId = $params["frictionId"];
        $voteResult = $params["voteResult"];

        $this->frictionService->voteTreatment($userId,$teamId,$treatmentId,$voteResult);

        header("Location:".BASE_URL."/team/".$teamId."/friction/".$frictionId);

    }
    
    /** showFrictionCreationPage()
     * Retrieve the current team context & render the friction creation form view.
     * 
     * @param {Array} $params : Array which contain route params (teamId, ...)
     * @return void Render friction creation view in case of success, throw exception if not
     */
    public function showFrictionCreationPage($params){

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $currentTeamId = $params["teamId"];

        $data=["teamId"=>$currentTeamId];

        $this->renderView("/team/friction/frictionCreation",$data);

    }

    /** showAddingSolutionPage()
     * Verify the current user's pilot role on the treatment & render the solution adding form view.
     * 
     * @param {Array} $params : Array which contain route params (teamId, frictionId, treatmentId, ...)
     * @return void Render solution adding view in case of success, throw exception if not
     */
    public function showAddingSolutionPage($params){

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $isPilot = $this->userService->isPilot($_SESSION["userId"],$params["teamId"]);

        if(!$isPilot)throw new RoleException("","Vous n'êtes pas pilote de ce traitement");

        $data["frictionId"] = $params["frictionId"];
        $data["teamId"] = $params["teamId"];
        $data["treatmentId"] = $params["treatmentId"];

        $this->renderView("/Team/friction/solutionAdding",$data ?? null);

    }

    /** addSolution()
     * Verify the current user's pilot role, collect POST data & delegate solution creation to the service.
     * Redirect to the parent friction page on success.
     * 
     * @param {Array} $params : Array which contain route params (teamId, frictionId, treatmentId, ...)
     * @return void Redirect to the friction page in case of success, throw exception if not
     */
    public function addSolution($params){

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $isPilot = $this->userService->isPilot($_SESSION["userId"],$params["teamId"]);

        if(!$isPilot)throw new RoleException("","Vous n'êtes pas pilote de ce traitement");

        $data = $this->getPost(["solution"]);

        $this->frictionService->addSolution($data["solution"],$params["treatmentId"]);
        
        header("Location:".BASE_URL."/team/".$params["teamId"]."/friction/".$params["frictionId"]);
        
        exit();

    }
}



?>