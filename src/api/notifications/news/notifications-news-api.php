<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/../../utils.php";
require_once __DIR__."/../../../db/tables.php";
require_once __DIR__."/../../../db/entity.php";
require_once __DIR__."/../../buyers/buyers-api.php";
require_once __DIR__."/../notifications-api.php";
require_once __DIR__."/../../orders/orders-api.php";

class NotificationsNewsApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }


    public function onGet($params){
        $news = NotificationsApi::get(["seen" => false], true)["data"];
        $orders_id = array_unique(array_map(function($notification){
            return $notification->order;
        }, $news));
        $buyers = array_unique(array_map(function($order_id){
            return OrdersApi::get(["id" => $order_id], true)["data"][0]->buyer;
        }, $orders_id));
        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData(["buyers" => $buyers]);
    }
    
}
?>