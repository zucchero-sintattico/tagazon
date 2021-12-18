<?php

require_once __DIR__."/../entity-api.php";
require_once __DIR__."/../../db/tables.php";
require_once __DIR__."/../wishlists/wishlists-api.php";

class WishlistsTagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(WishlistTag::class, Api::BUYER);
    }

    public function canAccess($element)
    {
        $apiResult = WishlistsApi::get(["id" => $element["wishlist"]])["data"];
        return count($apiResult) > 0;
    }

}

?>