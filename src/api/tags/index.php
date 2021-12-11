<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = AuthAPI::builder(Tag::class)
    ->get(AuthAPI::OPEN)
    ->post(AuthAPI::OPEN)
    ->patch(AuthAPI::SELLER)
    ->delete(AuthAPI::SELLER)
    ->build();

Api::run($api);

?>