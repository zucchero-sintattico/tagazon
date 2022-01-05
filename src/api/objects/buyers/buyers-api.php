<?php

require_once __DIR__ . "/../../require.php";

class BuyersApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();

        parent::__construct(Buyer::class, $auth);
    }

    public function canAccess($element)
    {
        return $element["id"] == $_SESSION["user"]["id"];
    }
}

?>