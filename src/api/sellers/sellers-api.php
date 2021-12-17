<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

class SellersApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Sellers::class);
    }

    public function hasAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }
}

?>