<?php

require_once "../entity-auth-api.php";
require_once "../../db/tables.php";

$api = EntityAuthApi::builder(Tag::class)
    ->get(EntityAuthApi::OPEN)
    ->post(EntityAuthApi::OPEN)
    ->patch(EntityAuthApi::SERVER)
    ->delete(EntityAuthApi::SERVER)
    ->build();

Api::run($api);

?>