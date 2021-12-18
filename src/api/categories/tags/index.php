<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/categories-tags-api.php";

Api::run(new CategoriesTagsApi());

?>