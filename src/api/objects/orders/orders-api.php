<?php

require_once __DIR__ . "/../../require.php";

class OrdersApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::BUYER)
            ->build();
        parent::__construct(Order::class, $auth);
    }

    public function canAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]["id"];
    }
}

?>