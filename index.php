<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once __DIR__ . "/libraries/path.php";
require_once __DIR__ . "/libraries/method.php";
require_once __DIR__ . "/libraries/response.php";
require_once __DIR__ . "/database/settings.php";

if (isPath("users")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/users/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/users/post.php";
        die();
    }
}

if (isPath("users/:user")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/users/delete.php";
        die();
    }

    if (isPatchMethod("users")) {
        require_once __DIR__ . "/routes/users/patch.php";
        die();
    }
}

if (isPath("orders")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/orders/get.php";
        die();
    }

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/orders/post.php";
        die();
    }
}

if (isPath("orders/:order")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/orders/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/orders/patch.php";
        die();
    }
}


if (isPath("authenticate")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/authenticate/get.php";
        die();
    }
}


echo jsonResponse(404, [], [
    "success" => false,
    "message" => "Route not found"
]);
