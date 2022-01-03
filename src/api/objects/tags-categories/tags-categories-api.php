<?php

require_once __DIR__ . "/../../require.php";

class TagsCategoriesApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->post(ApiAuth::SELLER)
            ->put(ApiAuth::SELLER)
            ->delete(ApiAuth::SELLER)
            ->build();
        parent::__construct(TagCategory::class, $auth);
    }

    public function canModify($element)
    {
        $tagId = $element["tag"];
        $tag = TagsApi::get(["id" => $tagId])->getData();
        return count($tag) == 1 && $tag[0]["seller"] == $_SESSION["user"]->id;
    }

    public function canDelete($element)
    {
        return $this->canModify($element);
    }
    
}

?>