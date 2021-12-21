<?php

require_once __DIR__ . "/../../require.php";

class NotificationsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Notification::class, Api::BUYER, Api::SERVER, Api::BUYER, Api::SERVER);
    }

    public function canAccess($element)
    {
        $order = (array)(OrdersApi::get(["id" => $element["order"]], true)["data"][0]);
        return $order["buyer"] == $_SESSION["user"]["id"];
    }

    public function canModify($element)
    {
        return $this->canAccess($element);
    }

}

?>