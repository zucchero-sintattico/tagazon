<?php

require_once "../api.php";
require_once "../../db/categories/category.php";
require_once "../../db/entity.php";

$api = new API(Category::class);
$api->handle();

?>