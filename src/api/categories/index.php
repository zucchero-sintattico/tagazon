<?php

require_once "../api.php";
require_once "../../db/tables.php";


$api = AuthAPI::builder(Category::class)
    ->get(AuthAPI::OPEN)
    ->post(AuthAPI::SERVER)
    ->patch(AuthAPI::SERVER)
    ->delete(AuthAPI::SERVER)
    ->build();

$api->handle();

?>