<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

class WishlistsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Wishlist::class, AuthApi::BUYER);
    }

    public function canAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }

}

?>