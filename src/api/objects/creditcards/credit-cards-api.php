<?php

require_once __DIR__ . "/../../require.php";

class CreditCardsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(CreditCard::class, Api::BUYER);
    }

    public function canAccess($element)
    {
        return $element["owner"] == $_SESSION["user"]->id;
    }
}

?>