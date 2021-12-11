<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = AuthAPI::builder(Seller::class)
    ->get(AuthAPI::OPEN)
    ->post(AuthAPI::SERVER)
    ->patch(AuthAPI::SELLER)
    ->delete(AuthAPI::SERVER)
    ->build();

$api->handle();

?>