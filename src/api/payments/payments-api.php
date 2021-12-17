<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

class PaymentsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Payment::class);
    }

    public function hasAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }
}

?>