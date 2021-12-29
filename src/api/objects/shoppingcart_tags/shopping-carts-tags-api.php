<?php

require_once __DIR__ . "/../../require.php";

class ShoppingCartsTagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(ShoppingCartTag::class, Api::BUYER, Api::BUYER, Api::BUYER, Api::BUYER);
    }

    public function canAccess($element)
    {
        $buyer = $element["buyer"];
        $buyer = BuyersApi::get(["id" => $buyer])["data"];
        return count($buyer) == 1;
    }

    public function canCreate($params)
    {
        return $this->canAccess($params);
    }

    public function canModify($element)
    {
        return $this->canAccess($element);
    }

    public function canDelete($element)
    {
        return $this->canAccess($element);
    }

}

?>