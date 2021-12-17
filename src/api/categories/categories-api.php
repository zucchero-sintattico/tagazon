<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

class CategoriesApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Category::class, AuthApi::OPEN);
    }

    public function hasAccess($element)
    {
        return true;
    }
}

?>