<?php

require_once __DIR__ . "/../../require.php";

class OrdersTagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(OrderTag::class, Api::BUYER);
    }

    public function hasAccess($element)
    {
        $orders = OrdersApi::get(['id' => $element->order_id])["data"];
        return count($orders) == 1;
    }
}

?>