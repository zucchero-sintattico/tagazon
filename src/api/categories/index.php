<?php

require_once "../entity-auth-api.php";
require_once "../../db/tables.php";


$api = EntityAuthApi::builder(Category::class)
    ->get(EntityAuthApi::OPEN)
    ->post(EntityAuthApi::SERVER)
    ->patch(EntityAuthApi::SERVER)
    ->delete(EntityAuthApi::SERVER)
    ->build();

Api::run($api);

?>