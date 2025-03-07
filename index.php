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

if (isPath("/orders")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/orders/get.php";
        exit;
    }
}

if (isPath("/authenticate") && isPostMethod()) {
    require_once __DIR__ . "/routes/authenticate/get.php";  
    exit;
}

if (isPath("/register") && isPostMethod()) {
    require_once __DIR__ . "/routes/auth/register.php";
    exit;
}


echo jsonResponse(404, [], ["success" => false, "message" => "Route not found"]);
