<?php

require_once __DIR__ . "/../../require.php";

class BuyersApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Buyer::class, Api::BUYER);
    }

    public function canAccess($element)
    {
        return $element["id"] == $_SESSION["user"]["id"];
    }
}

?>