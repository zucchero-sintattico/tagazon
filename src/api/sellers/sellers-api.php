<?php

require_once __DIR__."/../entity-api.php";
require_once __DIR__."/../../db/tables.php";

class SellersApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Seller::class);
    }

}

?>