<?php

require_once __DIR__."/../entity-api.php";

class CreditCardsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(CreditCard::class, AuthApi::BUYER);
    }

    public function canAccess($element)
    {
        return $element["owner"] == $_SESSION["user"]->id;
    }
}

?>