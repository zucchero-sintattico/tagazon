<?php

require_once __DIR__."/../entity-api.php";

class CategoriesApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Category::class, Api::OPEN, Api::SERVER, Api::OPEN);
    }

}

?>