<?php
namespace App\Services;

use App\Exceptions\RoleException;
use App\Models\TeamMemberModel;
use App\Models\FrictionModel;
use App\Models\CycleModel;
use App\Models\FrictionVotesModel;
use Exception;
use App\Models\TreatmentModel;
use App\Models\TreatmentVotesModel;
use DateTime;

class FrictionService{

    private TeamMemberModel $teamMemberModel;
    private CycleModel $cycleModel;
    private FrictionModel $frictionModel;
    private FrictionVotesModel $frictionVoteModel;
    private TreatmentModel $treatmentModel;
    private TreatmentVotesModel $treatmentVotesModel;

    public function __construct(){

        $this->teamMemberModel = new TeamMemberModel();
        $this->cycleModel = new CycleModel();
        $this->frictionModel = new FrictionModel();
        $this->frictionVoteModel = new FrictionVotesModel();
        $this->treatmentModel = new TreatmentModel();
        $this->treatmentVotesModel = new TreatmentVotesModel();
        
    }

    /** getFrictionData()
     * Retrieve and aggregate all friction-related data including votes, author, user permissions
     * & latest treatments with their votes and pilot info.
     * Return a structured response array formatted for the friction details view.
     * 
     * @param {int} $frictionId : Id of the friction to retrieve
     * @param {int} $teamId : Id of the team the friction belongs to
     * @param {int} $userId : Id of the current user
     * @return array Array of friction and treatments data in case of success, throw exception if not
     */
    public function getFrictionData(int $frictionId,int $teamId, int $userId):array{

        // RETRIEVE FRICTION DATA

        $currentCycleId = $this->cycleModel->getCurrentCycleId($teamId);

        $frictionDataWithStatus = $this->frictionModel->getByIdWithStatus($frictionId);

        $isFrictionOwnByTeam = $this->frictionModel->isOwnByTeam($frictionDataWithStatus['author_id'],$teamId); //Vérification de la cohérence friction/team.
        if(!$isFrictionOwnByTeam) throw new Exception("Cette friction ne fait pas partie de ce groupe !");

        $memberId = $this->teamMemberModel->findMemberId($userId,$teamId);

        $response=[];
        $response["cycleId"]=$currentCycleId;
        $response["memberId"]=$memberId;
        
        $frictionVotes =  $this->frictionVoteModel->getVotesCounter($currentCycleId,$frictionId);
        $authorUsername = $this->frictionModel->getAuthorUsername($frictionId);
        $hasVotedFriction = $this->frictionVoteModel->findBy(["id"],["cycle_id"=>$currentCycleId,"member_id"=>$memberId,"friction_id"=>$frictionId]);


        $currentCycleId = $this->cycleModel->getCurrentCycle($teamId);
        $maxTreatments = $this->cycleModel->findBy(["max_active_treatments"],["id"=>$currentCycleId],"onecolumn");
        $memberNbVotes = $this->frictionVoteModel->getCounterByMemberAndTeam($currentCycleId,$memberId);

        $canVoteFriction = (empty($hasVotedFriction) && $frictionDataWithStatus["status_label"] == "Non traité" && $memberNbVotes < $maxTreatments);

        $response["memberNbVotes"]=$memberNbVotes;

        $response["frictionData"]=[
            "friction"=>[
                "id"=>$frictionDataWithStatus["id"],
                "title"=>$frictionDataWithStatus["title"],
                "description"=>$frictionDataWithStatus["description"],
                "statusLabel"=>$frictionDataWithStatus["status_label"],
                "author"=>$authorUsername,
                "votes"=>$frictionVotes,
                "created_at"=>$frictionDataWithStatus["created_at"],
                "updated_at"=>$frictionDataWithStatus["updated_at"]
            ],
            "user"=>[
                "canVoteFriction"=>$canVoteFriction,
                "hasVotedFriction"=>$hasVotedFriction
            ]
        ];


        // RETRIEVE TREATMENTS DATA

        $treatmentsDataWithStatus = $this->treatmentModel->findLastsByFrictionWithStatus($frictionId, 5);

        if(!empty($treatmentsDataWithStatus)){

            $response["treatmentsData"] = [];

            foreach($treatmentsDataWithStatus as $treatment){

                //Retrieve Votes Data
                $treatmentVotes = $this->treatmentVotesModel->findVotesByTreatmentAndCycle($treatment["id"], $currentCycleId);
                $treatmentVotesCount = array_count_values($treatmentVotes);

                //Retrieve Pilot Username
                $pilotUsername = $this->treatmentModel->getPilotUsername($treatment["id"]);

                //Retrieve the member vote, if exists
                $memberDecision = $this->treatmentVotesModel->findBy(["vote"],["member_id"=>$memberId,"treatment_id"=>$treatment["id"]],"oneassoc");

                //Business logic for view
                $canVoteTreatment = $treatment["status_id"] == 3 && empty($memberDecision);
                $canUpdateSolution = $treatment["pilot_id"]==$memberId && $treatment["status_id"]==2;
                $hasApprovedSolution = !empty($memberDecision["vote"]) && $memberDecision["vote"]==true;

                $response["treatmentsData"][] = [
                    "treatment"=>[
                        "id"=>$treatment["id"],
                        "solution"=>$treatment["solution"],
                        "created_at"=>$treatment["created_at"],
                        "updated_at"=>$treatment["updated_at"],
                        "statusLabel"=>$treatment["label"],
                        "cycleId"=>$treatment["cycle_id"],
                        "pilot"=>$pilotUsername,
                        "pilotId"=>$treatment["pilot_id"],
                        "forVotes" => $treatmentVotesCount[1] ?? 0,
                        "againstVotes" => $treatmentVotesCount[0] ?? 0,
                    ],
                    "user"=>[
                        "canVoteTreatment"=>$canVoteTreatment,
                        "canUpdateSolution"=>$canUpdateSolution,
                        "hasApprovedSolution"=>$hasApprovedSolution
                    ]
                ];
            }
        }

        return $response;

    }

    /** createFriction()
     * Resolve the member id from session data, structure the friction data
     * & delegate friction creation to the model.
     * Return the newly created friction entry.
     * 
     * @param {Array} $createFrictionData : Array which contain friction creation data (title, description, userId, teamId)
     * @return array Array containing the newly created friction id in case of success, throw exception if not
     */
    public function createFriction($createFrictionData){

        echo "<br> FrictionService->createFriction : <br><br>";

        //Vérification de la longueur
        $memberId = $this->teamMemberModel->findMemberId($createFrictionData["userId"],$createFrictionData["teamId"]);

        $this->frictionModel->create([
            "created_at" => new DateTime()->format("Y-m-d H:i:s"),
            "title" => $createFrictionData["title"],
            "description"=>$createFrictionData["description"],
            "updated_at"=>null,
            "author_id"=>$memberId,
            "team_id"=>$createFrictionData["teamId"],
            "status_id"=>1
            ]
        );

        $frictionCreated = $this->frictionModel->getLastIdByAuthor($memberId);

        return $frictionCreated;

    }

    /** voteFriction()
     * Verify member membership, friction ownership & vote quota before registering
     * the current user's vote on a friction for the active cycle.
     * 
     * @param {int} $userId : Id of the current user
     * @param {int} $teamId : Id of the team the friction belongs to
     * @param {int} $frictionId : Id of the friction to vote on
     * @return string Success message in case of success, throw exception if not
     */
    public function voteFriction($userId,$teamId,$frictionId){

        echo "<br> FrictionService->voteFriction : <br><br>";

        // Vérifier que l'utilisaeur fait bien partie du groupe
        $memberId = $this->teamMemberModel->findMemberId($userId,$teamId);
        if(!$memberId) throw new RoleException("notMember","Vous ne faites pas partie de ce groupe !");

        $authorId = $this->frictionModel->findBy(["author_id"],["id"=>$frictionId],"onecolumn");

        // Vérifier que la friction fais partie de la team
        $isFrictionOwnByTeam = $this->frictionModel->isOwnByTeam($authorId,$teamId); //Vérification de la cohérence friction/team.
        if(!$isFrictionOwnByTeam) throw new Exception("Cette friction ne fait pas partie de ce groupe !");

        $cycle = $this->cycleModel->getLastByTeam($teamId);

        //Vérifier si le membre à atteind son quota de vote
        $memberNbVotes = $this->frictionVoteModel->getCounterByMemberAndTeam($cycle["id"],$memberId);

        if($memberNbVotes > 3) throw new Exception("Vous avez atteind le nombre de vote maximal");

        $isVoteExist = $this->frictionVoteModel->findBy(["id"],["cycle_id"=>$cycle["id"],"member_id"=>$memberId,"friction_id"=>$frictionId]);

        if(!empty($isVoteExist)) throw new Exception("Vous avez déjà voté pour cet irritant");

        $this->frictionVoteModel->create([
            "vote"=>1,
            "voted_at"=> new DateTime()->format("Y-m-d H:i:s"),
            "cycle_id"=> $cycle["id"],
            "member_id"=> $memberId,
            "friction_id"=> $frictionId
        ]);

        return $response["success"]="Vote envoyé !";
    }

    /** voteTreatment()
     * Verify member membership, friction ownership & vote uniqueness before registering
     * the current user's vote on a treatment.
     * 
     * @param {int} $userId : Id of the current user
     * @param {int} $teamId : Id of the team the treatment belongs to
     * @param {int} $treatmentId : Id of the treatment to vote on
     * @param {int} $voteResult : Vote value (0 or 1)
     * @return string Success message in case of success, throw exception if not
     */
    public function voteTreatment($userId,$teamId,$treatmentId,$voteResult){

        echo "<br> FrictionService->voteFriction : <br><br>";

        // Vérifier que l'utilisaeur fait bien partie du groupe
        $memberId = $this->teamMemberModel->findMemberId($userId,$teamId);
        if(!$memberId) throw new RoleException("notMember","Vous ne faites pas partie de ce groupe !");

        $frictionId = $this->treatmentModel->findBy(["friction_id"],["id"=>$treatmentId],"onecolumn");

        $authorId = $this->frictionModel->findBy(["author_id"],["id"=>$frictionId],"onecolumn");

        // Vérifier que la friction fais partie de la team
        $isFrictionOwnByTeam = $this->frictionModel->isOwnByTeam($authorId,$teamId); //Vérification de la cohérence friction/team.
        if(!$isFrictionOwnByTeam) throw new Exception("Cette friction ne fait pas partie de ce groupe !"); //404

        $isVoteExist = $this->treatmentVotesModel->findBy(["id"],["treatment_id"=>$treatmentId,"member_id"=>$memberId]);
    
        if(!empty($isVoteExist)) throw new Exception("Vous avez déjà voté pour cet irritant");

        !((int)$voteResult === 1 || (int)$voteResult=== 0) ?? throw new Exception("Le vote doit être un entier compris entre 0 et 1");

        $this->treatmentVotesModel->create([
            "vote"=>(int)$voteResult,
            "voted_at"=> (new DateTime())->format("Y-m-d H:i:s"),
            "member_id"=> $memberId,
            "treatment_id"=> $treatmentId
        ]);

        return $response["success"]="Vote envoyé !";
    }

    /** addSolution()
     * Update the solution field of a given treatment in the database.
     * 
     * @param {string} $solution : Solution text to attach to the treatment
     * @param {int} $treatmentId : Id of the treatment to update
     * @return void Solution updated in case of success, throw exception if not
     */
    public function addSolution($solution,$treatmentId){

        $this->treatmentModel->update($treatmentId,["solution"=>$solution]);

    }

}

?>