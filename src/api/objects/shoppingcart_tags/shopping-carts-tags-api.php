<?php

require_once __DIR__ . "/../../require.php";

class ShoppingCartsTagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(ShoppingCartTag::class, Api::BUYER);
    }

    public function canAccess($element)
    {
        $shoppingCartId = $element["shopping_cart"];
        $shoppingCarts = ShoppingCartsApi::get(["id" => $shoppingCartId])["data"];
        return count($shoppingCarts) == 1;
    }

}

?>