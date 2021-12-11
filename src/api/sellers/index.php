<?php

require_once "../entity-auth-api.php";
require_once "../../db/tables.php";

$api = EntityAuthApi::builder(Seller::class)
    ->get(EntityAuthApi::OPEN)
    ->post(EntityAuthApi::SERVER)
    ->patch(EntityAuthApi::SELLER)
    ->delete(EntityAuthApi::SERVER)
    ->build();

Api::run($api);

?>