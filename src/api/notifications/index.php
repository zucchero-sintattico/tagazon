<?php

require_once "../entity-auth-api.php";
require_once "../../db/tables.php";

$api = EntityAuthApi::builder(Notification::class)
    ->get(EntityAuthApi::BUYER)
    ->post(EntityAuthApi::SERVER)
    ->patch(EntityAuthApi::SERVER)
    ->delete(EntityAuthApi::SERVER)
    ->build();

Api::run($api);

?>