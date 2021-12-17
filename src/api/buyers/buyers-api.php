<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

class BuyersApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Buyer::class, AuthApi::BUYER);
    }

    public function hasAccess($element)
    {
        return $element["id"] == $_SESSION["user"]->id;
    }
}

?>