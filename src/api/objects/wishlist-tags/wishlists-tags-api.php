<?php

require_once __DIR__ . "/../../require.php";

class WishlistsTagsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::BUYER)
            ->build();
        parent::__construct(WishlistTag::class, $auth);
    }

    public function canAccess($element)
    {
        $apiResult = WishlistsApi::get(["id" => $element["wishlist"]])->getData();
        return count($apiResult) > 0;
    }

}

?>