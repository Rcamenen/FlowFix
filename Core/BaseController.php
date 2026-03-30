<?php
namespace Core;

abstract class BaseController {

    protected function renderView($view,$response=null){

        if($response)extract($response);
        $contentPath = ROOT."/App/Views/".$view.".php";
        require(ROOT."/App/Views/Layout/layout.php");

    }

    protected function isUserConnected():bool{

        if(isset($_SESSION["userId"])){
            return true;
        }else{
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
            $value = trim($_POST[$postName]);
            $posts[$key] = $value;

        }

        return $posts;

    }

}

?>