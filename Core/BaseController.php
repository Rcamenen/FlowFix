<?php
namespace Core;
use Exception;

abstract class BaseController {

    /** renderView()
     * Extract response data and load the requested view into the main layout
     * @param string $view
     * @param array|null $response
     * @return void
     */
    public function renderView($view,?array $data=null){

        if(!empty($data))extract($data);
        $contentPath = ROOT."/App/Views/".$view.".php";
        require(ROOT."/App/Views/Layout/layout.php");

    }

    /** renderPartial()
     * Render a view without the layout (for AJAX responses)
     */
    protected function renderPartial($view, $response = null) {
        if ($response) extract($response);
        require(ROOT . "/App/Views/" . $view . ".php");
    }

    /** isUserConnected()
     * Check if a user session ID is set to determine if the user is connected
     * Return true if connected, false otherwise
     * @param int|null $userIdSession
     * @return bool
     */
    protected function isUserConnected(?int $userIdSession=null):bool{

        if(isset($userIdSession)) return true;
        else return false;
        
    }

    /** isUserTeamMember()
     * Check if the current team ID is within the user's list of team IDs
     * Return true if the user is a member, false otherwise
     * @param array|null $userTeamsId
     * @param int|null $currentTeam
     * @return bool
     */
    protected function isUserTeamMember(?array $userTeamsId=null,?int $currentTeam=null):bool{

        if(isset($userTeamsId) && in_array($currentTeam,$userTeamsId)) return true;
        else return false;

    }

    /** checkAccess()
     * Verify that the user is connected and belongs to the requested team by using session and route parameters
     * Throw an exception if any access check fails
     * @param array $params
     * @return void
     */
    protected function checkAccess(array $params = []) {

        $userId = $_SESSION["userId"] ?? null;
        $userTeamsId = $_SESSION["teamsId"] ?? null;
        $currentTeamId = $params["teamId"] ?? null;
        
        if (!$this->isUserConnected($userId)) {
            throw new Exception("Vous devez être connecté pour accéder à cette page");
        }
        
        if ($currentTeamId !== null && !$this->isUserTeamMember($userTeamsId, $currentTeamId)) {
            throw new Exception("Vous ne faites pas partie de ce groupe");
        }

    }

    /** checkRole()
     * Check if the given role match with the current user by returning true of false
     * 
     * @param string : $role
     * @param int : $userId
     * @return bool;
     */
    public function checkRole(string $role,?int $teamId=null):bool{

        switch($role){

            case "admin":
                return !empty($_SESSION["adminId"]);
            case "user":
                return !empty($_SESSION["userId"]);
            case "member":
                return in_array($teamId,$_SESSION["teamsId"]);
            case "moderator":
                return in_array($teamId,$_SESSION["moderateTeamsId"]);
            default:
                return false;

        }

    }

    /** getPost()
     * 
     * get and trim $_POST variable according to the $postsName given
     * 
     * @param array : $postsName corresponding to $_POST[$postName] wanted
     * @return array : $posts that contains all the $_POST[$postName] like $$postname = $_POST[$postName]
     */
    protected function getPost(array $postsName) :array {

        $posts = [];
        foreach($postsName as $postName){

            $key = $postName;
            $value = htmlspecialchars(trim($_POST[$postName]));
            $posts[$key] = $value;

        }

        return $posts;

    }

}

?>