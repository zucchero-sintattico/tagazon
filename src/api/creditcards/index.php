<?php

require_once "../entity-auth-api.php";
require_once "../../db/tables.php";

$api = EntityAuthApi::builder(CreditCard::class)
    ->get(EntityAuthApi::BUYER)
    ->post(EntityAuthApi::BUYER)
    ->patch(EntityAuthApi::BUYER)
    ->delete(EntityAuthApi::BUYER)
    ->build();

Api::run($api);

?>