<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

class OrdersApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Order::class, AuthApi::BUYER);
    }

    public function hasAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }
}

?>