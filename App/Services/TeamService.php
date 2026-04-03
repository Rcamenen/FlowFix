<?php
namespace App\Services;
use Core\BaseService;
use App\Models\TeamMemberModel;
use App\Models\TreatmentModel;
use App\Models\FrictionModel;
use App\Exceptions\ForbiddenException;
use App\Models\Team;

class TeamService extends BaseService{

    private TeamMemberModel $teamMemberModel;
    private TreatmentModel $treatmentModel;
    private FrictionModel $frictionModel;

    public function __construct()
    {
        $this->teamMemberModel = new TeamMemberModel();
        $this->frictionModel = new FrictionModel();
        $this->treatmentModel = new TreatmentModel();
    }

    /** createUser()
     * Apply business verification & ask the model to add the user in the DB's user table.
     * 
     * @param {UserEntity} $userEntity : Object which represent user
     * @return bool true in case of success, false if not
     */

    public function home($userId,$groupId){

        echo "<br> TeamService->home : <br><br>";

        //VÉRIFICATION DES DROITS D'ACCÈS

        $teamMemberId = $this->teamMemberModel->getMemberId($userId,$groupId); // Retourne le membre => Tranformer en getMemberId;

        // if(isset($teamMember["left_at"]) && $teamMember["left_at"] != null ) throw new ForbiddenException("Vous ne faites plus partie du groupe !");

        // ======================================== Check if friction to pilot exist

        if($this->treatmentModel->isPilot($teamMemberId)){

            $treatment=$this->treatmentModel->findByPilot($teamMemberId);


                $friction=$this->frictionModel->getById($treatment["friction_id"]);

                $response["frictionToPilot"] = [
                    "id"=>$friction["id"],
                    "title"=>$friction["title"],
                    "description"=>$friction["description"],
                    "creationDate"=>$friction["created_at"],
                    "author"=>$friction["author_id"],
                    "team_id"=>$friction["team_id"]
                ];

        };

        // =========================================

        // ======================================== Check if friction in progress

        $frictionsInProgress = $this->frictionModel->getByGroupAndStatus($groupId,1);

        $response["frictionsInProgress"] = $frictionsInProgress;

        // =========================================

        return $response;
        // AFFICHER LES IRRITANTS QUI SONT EN COURS



        // AFFICHER LES IRRITANTS POUR LESQUELS ON A VOTÉ POUR LE PROCHAIN CYCLE

        // AFFICHER LE NOMBRE DE VOTE RESTANT


    }

}

?>