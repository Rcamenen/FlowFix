<?php
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Controllers\HomeController;
use App\Controllers\TeamController;
use App\Controllers\FrictionController;
use App\Controllers\ErrorController;

    return[

        "GET"=>[

            "/"=>["controller"=>HomeController::class,"method"=>"render"],
            "/register"=>["controller"=>RegisterController::class,"method"=>"render"],
            "/login"=>["controller"=>LoginController::class,"method"=>"render"],
            "/teams"=>["controller"=>UserController::class,"method"=>"showGroupsPanel"],
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"renderCreationForm"],
            "/team/{teamId}/friction/{frictionId}"=>["controller"=>FrictionController::class,"method"=>"getFrictionView"],
            "/404"=>["controller"=>ErrorController::class,"method"=>"pageNotFound"],
            "/team/{teamId}"=>["controller"=>TeamController::class,"method"=>"showDashboard"],
            "/disconnect"=>["controller"=>LoginController::class,"method"=>"disconnectUser"]

        ],
        "POST"=>[
            "/register"=>["controller"=>RegisterController::class,"method"=>"createUser"],
            "/login"=>["controller"=>LoginController::class,"method"=>"connectUser"],
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"createFriction"]
        ]


    ];

?>