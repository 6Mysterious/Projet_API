<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/orders/get-orders.php";

try {
    $orders = getOrders(); 

    echo jsonResponse(200, [], ["success" => true, "users" => $orders]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], ["success" => false, "error" => $exception->getMessage()]);
}