<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\FrictionService;
use App\Services\UserService;

use App\Exceptions\AuthenticateException;
use App\Exceptions\AuthorizationException;
use App\Exceptions\RoleException;
use App\Models\TreatmentModel;

class FrictionController extends BaseController{

    private FrictionService $frictionService;
    private UserService $userService;

    public function __construct(){
        $this->frictionService = new FrictionService;
        $this->userService = new UserService;
;
    }

    /** getFrictionView()
     * Retrieve friction data from the service using session and route parameters
     * Call the appropriate view to render the friction page
     * @param array $params Route parameters containing teamId and frictionId
     * @return void
     */
    public function showFrictionPage($params){

        if(!$this->checkRole("user")) throw new AuthenticateException("Vous devez être connecté pour voir cette page");
        if(!$this->checkRole("member",$params["teamId"])) throw new AuthorizationException("teams","Vous devez faire partie du groupe pour voir cette page.");

        $userId = $_SESSION["userId"] ?? null;
        $currentTeamId = $params["teamId"] ?? null;
        $frictionId = $params["frictionId"] ?? null;

        $data = $this->frictionService->getFrictionData($frictionId,$currentTeamId,$userId);
        $data["teamId"] = (string) $currentTeamId;

        $this->renderView("/team/friction/frictionDetails",$data);

    }

    /** createFriction()
     * Get $_POST values and route parameters, structure them and send to the service to handle friction creation
     * Redirect to the newly created friction page on success
     * @param array $params Route parameters containing teamId
     * @return void
     */
    public function createFriction($params){

        if(!$this->checkRole("user")) throw new AuthenticateException("Vous devez être connecté pour voir cette page");
        if(!$this->checkRole("member",$params["teamId"])) throw new AuthorizationException("teams","Vous devez faire partie du groupe pour voir cette page.");

        $this->checkAccess($params);

        // Récupération et structuration des données pour appel au service
        $createFrictionData = $this->getPost(["title","description"]);
        $createFrictionData["userId"]=$_SESSION["userId"];
        $createFrictionData["teamId"]=$params["teamId"];

        // Appel au service
        $frictionCreatedId = $this->frictionService->createFriction($createFrictionData);

        header("Location: /team/".$createFrictionData["teamId"]."/friction/".$frictionCreatedId["id"]);
        
    }

    public function voteFriction($params){

        echo "<br> FrictionController->voteFriction : <br><br>";

        if(!$this->checkRole("user")) throw new AuthenticateException("Vous devez être connecté pour voir cette page");
        if(!$this->checkRole("member",$params["teamId"])) throw new AuthorizationException("teams","Vous devez faire partie du groupe pour voir cette page.");
        
        $userId = $_SESSION["userId"];
        $teamId = $params["teamId"];
        $frictionId = $params["frictionId"];

        $this->frictionService->voteFriction($userId,$teamId,$frictionId);

        header("Location: /team/".$teamId."/friction/".$frictionId);

    }

    public function voteTreatment($params){

        echo "<br> FrictionController->voteFriction : <br><br>";

        if(!$this->checkRole("user")) throw new RoleException("teams","Vous devez être connecté pour voir cette page");
        if(!$this->checkRole("member",$params["teamId"])) throw new RoleException("teams","Vous devez faire partie du groupe pour voir cette page");
        
        $userId = $_SESSION["userId"];
        $teamId = $params["teamId"];
        $treatmentId = $params["treatmentId"];
        $frictionId = $params["frictionId"];
        $voteResult = $params["voteResult"];

        $this->frictionService->voteTreatment($userId,$teamId,$treatmentId,$voteResult);

        header("Location: /team/".$teamId."/friction/".$frictionId);

    }
    
    /** renderCreationForm()
     * Retrieve the current team context and pass it to the service to render the friction creation form view
     * @param array $params Route parameters containing teamId
     * @return void
     */
    public function showFrictionCreationPage($params){

        if(!$this->checkRole("user")) throw new AuthenticateException("Vous devez être connecté pour voir cette page");
        if(!$this->checkRole("member",$params["teamId"])) throw new AuthorizationException("teams","Vous devez faire partie du groupe pour voir cette page.");

        $currentTeamId = $params["teamId"];

        $data=["teamId"=>$currentTeamId];

        $this->renderView("/team/friction/frictionCreation",$data);

    }

    public function showAddingSolutionPage($params){

        $this->checkRole("member");

        $isPilot = $this->userService->isPilot($_SESSION["userId"],$params["teamId"]);

        if(!$isPilot)throw new RoleException("","Vous n'êtes pas pilote de ce traitement");

        $data["frictionId"] = $params["frictionId"];
        $data["teamId"] = $params["teamId"];
        $data["treatmentId"] = $params["treatmentId"];

        $this->renderView("/Team/friction/solutionAdding",$data ?? null);

    }

    public function addSolution($params){

        $isPilot = $this->userService->isPilot($_SESSION["userId"],$params["teamId"]);

        if(!$isPilot)throw new RoleException("","Vous n'êtes pas pilote de ce traitement");

        $data = $this->getPost(["solution"]);

        $this->frictionService->addSolution($data["solution"],$params["treatmentId"]);
        
        header("Location: /team/".$params["teamId"]."/friction/".$params["frictionId"]);
        
        exit();

    }
}



?>