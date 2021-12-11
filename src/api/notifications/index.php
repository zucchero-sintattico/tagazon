<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = AuthAPI::builder(Notification::class)
    ->get(AuthAPI::BUYER)
    ->post(AuthAPI::SERVER)
    ->patch(AuthAPI::SERVER)
    ->delete(AuthAPI::SERVER)
    ->build();

$api->handle();

?>