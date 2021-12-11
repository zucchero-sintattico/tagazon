<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = AuthAPI::builder(Tag::class)
    ->post(AuthAPI::ADMIN)
    ->patch(AuthAPI::ADMIN)
    ->delete(AuthAPI::ADMIN)
    ->build();

$api->handle();

?>