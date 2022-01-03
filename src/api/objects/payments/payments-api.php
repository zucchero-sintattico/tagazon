<?php

require_once __DIR__ . "/../../require.php";

class PaymentsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::BUYER)
            ->build();
        parent::__construct(Payment::class, $auth);
    }

    public function hasAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }
}

?>