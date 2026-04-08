<?php
namespace App\Controllers;

use Core\BaseController;

class StaticPageController extends BaseController{

    /** renderHome()
     * Render the home page view
     * @param {*}
     * @return void
     */
    public function renderHome(){
        
        $this->renderView("home",$response ?? null);

    }

    /** renderPageNotFound()
     * Render the 404 not found page view
     * @param {*}
     * @return void
     */
    public function renderPageNotFound(){
        
        $this->renderView("404",$response ?? null);

    }
}

?>