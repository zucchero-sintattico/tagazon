<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = AuthAPI::builder(Buyer::class)
    ->get(AuthAPI::OPEN)
    ->post(AuthAPI::SERVER)
    ->patch(AuthAPI::BUYER)
    ->delete(AuthAPI::SERVER)
    ->build();

$api->handle();

?>