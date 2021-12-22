<?php

require_once __DIR__ . "/../../require.php";

class OrdersApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Order::class, Api::BUYER);
    }

    public function canAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }
}

?>