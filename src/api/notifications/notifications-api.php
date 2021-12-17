<?php

require_once __DIR__."/../entity-api.php";

class NotificationsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Notification::class, AuthApi::BUYER);
    }

    public function hasAccess($element)
    {
        return $element["buyer"] == $_SESSION["user"]->id;
    }
}

?>