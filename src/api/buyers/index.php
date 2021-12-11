<?php

require_once "../entity-auth-api.php";
require_once "../../db/tables.php";

$api = EntityAuthApi::builder(Buyer::class)
    ->get(EntityAuthApi::OPEN)
    ->post(EntityAuthApi::SERVER)
    ->patch(EntityAuthApi::BUYER)
    ->delete(EntityAuthApi::SERVER)
    ->build();

Api::run($api);


?>