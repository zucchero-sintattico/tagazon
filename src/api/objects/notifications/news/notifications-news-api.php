<?php

require_once __DIR__ . "/../../../require.php";

class NotificationsNewsApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }


    public function onGet($params){
        $news = NotificationsApi::get(["received" => false], true)->getData();
        $orders_id = array_unique(array_map(function($notification){
            return $notification["order"];
        }, $news));
        $buyers = array_unique(array_map(function($order_id){
            return OrdersApi::get(["id" => $order_id], true)->getData()[0]->buyer;
        }, $orders_id));

        return Response::ok($buyers);
    }
    
}
?>