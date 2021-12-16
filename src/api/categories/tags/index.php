<?php

require_once "../../api.php";
require_once __DIR__."/categories-tag-api.php";

Api::run(new CategoriesTagApi());

?>