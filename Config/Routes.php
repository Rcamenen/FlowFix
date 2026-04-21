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
            "/error"=>["controller"=>StaticPageController::class,"method"=>"showErrorPage"],
            "/notMember"=>["controller"=>StaticPageController::class,"method"=>"showNotMember"],
        // "/contact"=>["controller"=>StaticPageController::class,"method"=>"showContactPage"],
            "/register"=>["controller"=>StaticPageController::class,"method"=>"showRegisterPage"],
            "/login"=>["controller"=>StaticPageController::class,"method"=>"showLoginPage"],
            "/legal"=>["controller"=>StaticPageController::class,"method"=>"showLegalPage"],
            "/privacy"=>["controller"=>StaticPageController::class,"method"=>"showPrivacyPage"],

            "/teams"=>["controller"=>UserController::class,"method"=>"showTeamsPage"],
            "/account"=>["controller"=>UserController::class,"method"=>"showAccountPage"],

            //TEAM
            "/team/create"=>["controller"=>TeamController::class,"method"=>"showTeamCreationPage"],
            "/team/{teamId}" => ["controller" => TeamController::class, "method" => "showTeamDashboardPage"],

            //TEAM CYCLE
            "/team/{teamId}/cycle" => ["controller" => TeamController::class, "method" => "showCyclePage"],

            //TEAM MEMBER
            "/team/{teamId}/member/add" => ["controller"=>TeamController::class,"method"=> "showAddMemberPage"],
            "/team/{teamId}/members" => ["controller" => TeamController::class, "method" => "showTeamMembersPage"],

            //TEAM FRICTION
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"showFrictionCreationPage"],
            "/team/{teamId}/frictions" => ["controller"=>TeamController::class,"method"=> "showFrictionsPage"],
            "/team/{teamId}/friction/{frictionId}"=>["controller"=>FrictionController::class,"method"=>"showFrictionPage"],
            "/team/{teamId}/friction/{frictionId}/treatment/{treatmentId}/updatesolution"=>["controller"=>FrictionController::class,"method"=>"showAddingSolutionPage"],

            //ADMIN
            "/adminLogin" => ["controller"=>StaticPageController::class,"method"=> "showAdminLoginPage"],
            "/admin" => ["controller" => AdminController::class, "method" => "showAdminPanel"],
            "/admin/users" => ["controller" => AdminController::class, "method" => "showUsers"],
            "/admin/user/{userId}/delete" => ["controller" => AdminController::class, "method" => "showDeleteUser"],
            "/admin/teams"  => ["controller" => AdminController::class, "method" => "showTeams"],


        ],
        "POST"=>[

            "/register"=>["controller"=>UserController::class,"method"=>"createUser"],
            
            "/login"=>["controller"=>AuthController::class,"method"=>"connectUser"],
            "/logout"=>["controller"=>AuthController::class,"method"=>"disconnectUser"],

            "/team/create"=>["controller"=>TeamController::class,"method"=>"createTeam"],
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"createFriction"],
            "/team/{teamId}/friction/{frictionId}/treatment/{treatmentId}/updatesolution"=>["controller"=>FrictionController::class,"method"=>"addSolution"],
            "/team/{teamId}/friction/{frictionId}/vote"=>["controller"=>FrictionController::class,"method"=>"voteFriction"],

            "/team/{teamId}/friction/{frictionId}/treatment/{treatmentId}/vote/{voteResult}"=>["controller"=>FrictionController::class,"method"=>"voteTreatment"],
            // "/team/{teamId}/friction/{frictionId}/treatment/{treatmentId}/v"=>["controller"=>FrictionController::class,"method"=>"rejectTreatment"],
                        
            "/team/{teamId}/member/add" => ["controller" => TeamController::class, "method" => "addMember"],

            "/adminLogin"=>["controller"=>AuthController::class,"method"=>"connectAdmin"],
            "/admin/logout"=>["controller"=>AuthController::class,"method"=>"disconnectAdmin"],
            "/admin/user/{userId}/delete"   => ["controller" => AdminController::class, "method" => "deleteUser"]

        ]


    ];

?>