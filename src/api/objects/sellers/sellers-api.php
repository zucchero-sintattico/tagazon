<?php

require_once __DIR__ . "/../../require.php";

class SellersApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct(Seller::class, $auth);
    }

}

?>