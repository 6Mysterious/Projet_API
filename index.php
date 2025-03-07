<?php

require_once __DIR__ . "/libraries/path.php";
require_once __DIR__ . "/libraries/method.php";
require_once __DIR__ . "/libraries/response.php";
require_once __DIR__ . "/database/settings.php";

if (isPath("/users")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/users/get.php";
        exit;
    }
}

if (isPath("/users") && isPostMethod()) {
    require_once __DIR__ . "/routes/users/post.php";
    exit;
}


if (isPath("/users/:id")) {    
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/users/delete.php";
        die();
    }
    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/users/patch.php";
        die();
    }
}

if (isPath("/orders")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/orders/get.php";
        exit;
    }
}

if (isPath("/authenticate") && isPostMethod()) {
    require_once __DIR__ . "/routes/auth/get.php";  
    exit;
}

if (isPath("/register") && isPostMethod()) {
    require_once __DIR__ . "/routes/auth/register.php";
    exit;
}


echo jsonResponse(404, [], ["success" => false, "message" => "Route not found"]);
