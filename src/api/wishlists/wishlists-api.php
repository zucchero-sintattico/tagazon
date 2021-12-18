<?php

require_once __DIR__."/../entity-api.php";
require_once __DIR__."/../../db/tables.php";

class WishlistsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Wishlist::class, Api::BUYER);
    }

    public function canAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }

}

?>