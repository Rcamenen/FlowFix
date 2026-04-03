<?php
namespace Core;

abstract class BaseController {

    protected function renderView($view,$response=null){

        if($response)extract($response);
        $contentPath = ROOT."/App/Views/".$view.".php";
        require(ROOT."/App/Views/Layout/layout.php");

    }

    protected function isUserConnected(?int $userIdSession=null):bool{

        if(isset($userIdSession)) return true;
        else return false;
        

    }

    protected function isUserTeamMember(?array $userTeamsId=null,?int $currentTeam=null):bool{

        if(isset($userTeamsId) && in_array($currentTeam,$userTeamsId)) return true;
        else return false;

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
            $value = trim($_POST[$postName]);
            $posts[$key] = $value;

        }

        return $posts;

    }

}

?>