<?php

require_once "../api.php";
require_once "../../db/tags_categories/tags_categories.php";

$api = new API(TagsCategories::class);
$api->handle();

?>