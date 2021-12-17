<?php

require_once __DIR__."/../entity-api.php";

class OrdersTagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(OrderTag::class, AuthApi::BUYER);
    }

    public function hasAccess($element)
    {
        $apiResponse = OrdersApi::get([
            'id' => $element->order_id
        ]);
        return $apiResponse["code"] == 200;
    }
}

?>