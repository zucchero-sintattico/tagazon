<?php

require_once "../api.php";
require_once "../../db/tables.php";

$api = new API(Tag::class);
$api->handle();

?>