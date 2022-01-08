<?php

require_once __DIR__ . "/../../require.php";

class OrdersTagsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->post(ApiAuth::SERVER)
            ->build();
        parent::__construct(OrderTag::class, $auth);
    }

    public function canAccess($element)
    {
        $orders = OrdersApi::get(['id' => $element["order"]])->getData();
        return count($orders) == 1;
    }
}

?>