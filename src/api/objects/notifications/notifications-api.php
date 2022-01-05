<?php

require_once __DIR__ . "/../../require.php";

class NotificationsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::BUYER)
            ->build();
        parent::__construct(Notification::class, $auth);
    }

    public function canAccess($element)
    {
        $order = OrdersApi::get(["id" => $element["order"]], true)->getData()[0];
        $res = ($order["buyer"] == $_SESSION["user"]["id"]);
        return $res;
    }

    public function canModify($element)
    {
        return $this->canAccess($element);
    }

}

?>