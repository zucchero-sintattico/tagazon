<?php

require_once __DIR__ . "/../../require.php";

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