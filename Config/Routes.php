<?php
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Controllers\HomeController;
use App\Controllers\GroupController;
use App\Controllers\ErrorController;

    return[

        "GET"=>[

            "/"=>["controller"=>HomeController::class,"method"=>"render"],
            "/register"=>["controller"=>RegisterController::class,"method"=>"render"],
            "/login"=>["controller"=>LoginController::class,"method"=>"render"],
            "/teams"=>["controller"=>UserController::class,"method"=>"showGroupsPanel"],
            "/team/{teamId}"=>["controller"=>GroupController::class,"method"=>"home"],
            "/team/{teamId}/friction/{frictionId}"=>["controller"=>GroupController::class,"method"=>"home"],
            "/404"=>["controller"=>ErrorController::class,"method"=>"pageNotFound"],
            "/disconnect"=>["controller"=>LoginController::class,"method"=>"disconnectUser"]

        ],
        "POST"=>[
            "/register"=>["controller"=>RegisterController::class,"method"=>"createUser"],
            "/login"=>["controller"=>LoginController::class,"method"=>"connectUser"],
        ]


    ];

?>