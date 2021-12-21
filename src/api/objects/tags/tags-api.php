<?php

require_once __DIR__ . "/../../require.php";

class TagsApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(Tag::class, Api::OPEN, Api::SELLER, Api::SELLER, Api::SELLER);
    }

    public function canModify($element)
    {
        return $element["seller"] == $_SESSION["user"]->id;
    }

    public function canDelete($element)
    {
        return $this->canModify($element);
    }
}

?>