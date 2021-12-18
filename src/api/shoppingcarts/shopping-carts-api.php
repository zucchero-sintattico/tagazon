<?php

require_once __DIR__."/../entity-api.php";
require_once __DIR__."/../../db/tables.php";

class ShoppingCartsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(ShoppingCart::class, Api::BUYER);
    }

    public function canAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }

}

?>