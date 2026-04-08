<?php
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Controllers\TeamController;
use App\Controllers\FrictionController;
use App\Controllers\StaticPageController;

    return[

        "GET"=>[

            "/"=>["controller"=>StaticPageController::class,"method"=>"renderHome"],
            "/404"=>["controller"=>StaticPageController::class,"method"=>"renderPageNotFound"],
            "/about"=>["controller"=>StaticPageController::class,"method"=>"renderAbout"],
            "/contact"=>["controller"=>StaticPageController::class,"method"=>"renderContact"],

            "/register"=>["controller"=>RegisterController::class,"method"=>"render"],
            "/login"=>["controller"=>LoginController::class,"method"=>"render"],
            "/disconnect"=>["controller"=>LoginController::class,"method"=>"disconnectUser"],

            "/teams"=>["controller"=>UserController::class,"method"=>"showGroupsPanel"],
            "/account"=>["controller"=>UserController::class,"method"=>"showAccount"],
            "/account/delete"=>["controller"=>UserController::class,"method"=>"deleteAccount"],

            "/team/{teamId}"=>["controller"=>TeamController::class,"method"=>"showDashboard"],
            "/team/{teamId}/friction/{frictionId}"=>["controller"=>FrictionController::class,"method"=>"getFrictionView"],
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"renderCreationForm"]

        ],
        "POST"=>[

            "/team/create"=>["controller"=>TeamController::class,"method"=>"create"],
            "/register"=>["controller"=>RegisterController::class,"method"=>"createUser"],
            "/login"=>["controller"=>LoginController::class,"method"=>"connectUser"],
            "/team/{teamId}/friction/create"=>["controller"=>FrictionController::class,"method"=>"createFriction"]
            
        ]


    ];

?>