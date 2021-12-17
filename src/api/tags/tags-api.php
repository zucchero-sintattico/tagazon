<?php

require_once "../entity-api.php";
require_once "../../db/tables.php";

class TagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Tags::class, AuthApi::OPEN, AuthApi::SELLER, AuthApi::SELLER, AuthApi::SELLER);
    }

    public function canModify($element)
    {
        return $element["seller"] == $_SESSION["user"]->id;
    }

    public function canDelete($element)
    {
        return $element["seller"] == $_SESSION["user"]->id;
    }
}

?>