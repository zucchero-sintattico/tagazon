<?php

require_once "../api.php";
require_once "../../db/tags/tag.php";

$api = new API(Tag::class);
$api->handle();

?>