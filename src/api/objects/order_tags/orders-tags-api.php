<?php

require_once __DIR__ . "/../../require.php";

class OrdersTagsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct(OrderTag::class, $auth);
    }

    public function hasAccess($element)
    {
        $orders = OrdersApi::get(['id' => $element->order_id])->getData();
        return count($orders) == 1;
    }
}

?>