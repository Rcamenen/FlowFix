<?php
namespace App\Services;
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
     * Retrieve and aggregate all friction-related data including votes, author, and latest treatment details from the models
     * Return a structured response array containing friction and treatment data
     * @param int $frictionId
     * @param int $teamId
     * @return array
     */
    public function getFrictionData(int $frictionId,int $teamId, int $userId):array{

        // RETRIEVE FRICTION DATA

        $currentCycleId = $this->cycleModel->getCurrentCycleId($teamId);

        $frictionDataWithStatus = $this->frictionModel->getByIdWithStatus($frictionId);

        if(!$frictionDataWithStatus) throw new Exception("La page demandée n'existe pas"); //404

        $isFrictionOwnByTeam = $this->frictionModel->isOwnByTeam($frictionDataWithStatus['author_id'],$teamId); //Vérification de la cohérence friction/team.
        if(!$isFrictionOwnByTeam) throw new Exception("Cette friction ne fait pas partie de ce groupe !"); //404

        $memberId = $this->teamMemberModel->findMemberId($userId,$teamId);

        $response=[];
        $response["cycleId"]=$currentCycleId;
        $response["memberId"]=$memberId;
        
        $frictionVotes =  $this->frictionVoteModel->getVotesCounter($currentCycleId,$frictionId);
        $authorUsername = $this->frictionModel->getAuthorUsername($frictionId);
        $hasVotedFriction = $this->frictionVoteModel->findBy(["id"],["cycle_id"=>$currentCycleId,"member_id"=>$memberId,"friction_id"=>$frictionId]);

        $canVoteFriction = (empty($hasVotedFriction) && $frictionDataWithStatus["status_label"] == "Non traité");

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
     * Retrieve the team member ID and send structured friction data to the model to handle the creation
     * Return the newly created friction entry
     * @param array $createFrictionData
     * @return array
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

    public function voteFriction($userId,$teamId,$frictionId){

        echo "<br> FrictionService->voteFriction : <br><br>";

        // Vérifier que l'utilisaeur fait bien partie du groupe
        $memberId = $this->teamMemberModel->findMemberId($userId,$teamId);
        if(!$memberId) throw new Exception("Vous ne faites pas partie de ce groupe !");

        $authorId = $this->frictionModel->findBy(["author_id"],["id"=>$frictionId],"onecolumn");

        // Vérifier que la friction fais partie de la team
        $isFrictionOwnByTeam = $this->frictionModel->isOwnByTeam($authorId,$teamId); //Vérification de la cohérence friction/team.
        if(!$isFrictionOwnByTeam) throw new Exception("Cette friction ne fait pas partie de ce groupe !"); //404

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

    public function voteTreatment($userId,$teamId,$treatmentId,$voteResult){

        echo "<br> FrictionService->voteFriction : <br><br>";

        // Vérifier que l'utilisaeur fait bien partie du groupe
        $memberId = $this->teamMemberModel->findMemberId($userId,$teamId);
        if(!$memberId) throw new Exception("Vous ne faites pas partie de ce groupe !");

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

    public function addSolution($solution,$treatmentId){

        $this->treatmentModel->update($treatmentId,["solution"=>$solution]);

    }

}

?>