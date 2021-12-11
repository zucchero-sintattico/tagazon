<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = AuthAPI::builder(TagCategory::class)
    ->get(AuthAPI::OPEN)
    ->post(AuthAPI::SELLER)
    ->patch(AuthAPI::SELLER)
    ->delete(AuthAPI::SELLER)
    ->build();

Api::run($api);
?>