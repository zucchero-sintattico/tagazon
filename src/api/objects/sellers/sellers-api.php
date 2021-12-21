<?php

require_once __DIR__ . "/../../require.php";

class SellersApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Seller::class);
    }

}

?>