<?php

require_once __DIR__."/../api.php";
require_once __DIR__."/../utils.php";
require_once __DIR__."/../../db/tables.php";
require_once __DIR__."/../../db/entity.php";
require_once __DIR__."/../tags/tags-api.php";

class TagsCategoriesApi extends EntityApi {

    public function __construct()
    {
        parent::__construct(TagCategory::class, Api::OPEN, Api::SELLER, Api::SELLER, Api::SELLER);
    }

    public function canModify($element)
    {
        $tagId = $element["tag"];
        $tag = TagsApi::get(["id" => $tagId])["data"];
        return count($tag) == 1 && $tag[0]["seller"] == $_SESSION["user"]->id;
    }

    public function canDelete($element)
    {
        return $this->canModify($element);
    }
    
}

?>