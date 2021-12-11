<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = new API(ShoppingCartTag::class);
$api->handle();

?>