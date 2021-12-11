<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = AuthAPI::builder(Wishlist::class)
    ->get(AuthAPI::BUYER)
    ->post(AuthAPI::BUYER)
    ->patch(AuthAPI::BUYER)
    ->delete(AuthAPI::BUYER)
    ->build();

$api->handle();

?>