<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = new API(OrderTag::class);

$api = AuthAPI::builder(OrderTag::class)
    ->get(AuthAPI::BUYER)
    ->post(AuthAPI::SERVER)
    ->patch(AuthAPI::SERVER)
    ->delete(AuthAPI::SERVER)
    ->build();
    
$api->handle();

?>