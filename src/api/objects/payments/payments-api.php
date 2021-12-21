<?php

require_once __DIR__ . "/../../require.php";

class PaymentsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Payment::class, Api::BUYER);
    }

    public function hasAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }
}

?>