<?php

require_once "../entity-auth-api.php";
require_once "../../db/tables.php";

$api = EntityAuthApi::builder(Tag::class)
    ->get(EntityAuthApi::OPEN)
    ->post(EntityAuthApi::OPEN)
    ->patch(EntityAuthApi::SELLER)
    ->delete(EntityAuthApi::SELLER)
    ->build();

Api::run($api);

?>