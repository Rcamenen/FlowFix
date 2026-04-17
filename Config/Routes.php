<?php
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Controllers\TeamController;
use App\Controllers\FrictionController;
use App\Controllers\StaticPageController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;

    return[

        "GET"=>[

            "/"=>["controller"=>StaticPageController::class,"method"=>"showHomePage"],
            "/404"=>["controller"=>StaticPageController::class,"method"=>"showPageNotFound"],
            "/about"=>["controller"=>StaticPageController::class,"method"=>"showAboutPage"],
            "/contact"=>["controller"=>StaticPageController::class,"method"=>"showContactPage"],

            "/register"=>["controller"=>StaticPageController::class,"method"=>"showRegisterPage"],
            "/login"=>["controller"=>StaticPageController::class,"method"=>"showLoginPage"],

            "/teams"=>["controller"=>UserController::class,"method"=>"showTeamsPage"],
            "/account"=>["controller"=>UserController::class,"method"=>"showAccountPage"],

            "/team/{teamId}"=>["controller"=>TeamController::class,"method"=>"showTeamPage"],
            "/team/{teamId}/friction/{frictionId}"=>["controller"=>FrictionController::class,"method"=>"showFrictionPage"],
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"showFrictionCreationPage"],
            "/team/{teamId}/member/add" => ["controller"=>TeamController::class,"method"=> "showAddMember"],

            "/team/{teamId}/frictions" => ["controller"=>TeamController::class,"method"=> "showFrictions"],

            "/admin/login" => ["controller"=>StaticPageController::class,"method"=> "showAdminLoginPage"],
            "/adminPanel" => ["controller"=>AdminController::class,"method"=> "showAdminPanel"],
            "/admin/users" => ["controller"=>AdminController::class,"method"=> "showUsersPage"],
            "/admin/teams" => ["controller"=>AdminController::class,"method"=> "showTeamsPage"]

        ],
        "POST"=>[

            "/register"=>["controller"=>UserController::class,"method"=>"createUser"],
            
            "/login"=>["controller"=>AuthController::class,"method"=>"connectUser"],
            "/logout"=>["controller"=>AuthController::class,"method"=>"disconnectUser"],

            "/team/create"=>["controller"=>TeamController::class,"method"=>"createTeam"],
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"createFriction"],
            "/team/{teamId}/friction/{frictionId}/vote"=>["controller"=>FrictionController::class,"method"=>"voteFriction"],
            "/team/{teamId}/member/add"=>["controller"=>TeamController::class,"method"=>"addMember"],

            "/admin/login"=>["controller"=>AuthController::class,"method"=>"connectAdmin"],
            "/admin/logout"=>["controller"=>AuthController::class,"method"=>"disconnectAdmin"],
            "/admin/user/{userId}/delete" => ["controller"=>UserController::class,"method"=> "deleteUser"]
            
        ]


    ];

?>