<?php

require_once "../../api.php";
require_once __DIR__."/categories-tags-api.php";

Api::run(new CategoriesTagsApi());

?>