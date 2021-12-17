<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

$api = EntityApi::builder(Buyer::class)
    ->get(AuthApi::OPEN)
    ->build();

Api::run($api);


?>