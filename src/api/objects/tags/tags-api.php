<?php

require_once __DIR__ . "/../../require.php";

class TagsApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->post(ApiAuth::SELLER)
            ->put(ApiAuth::SELLER)
            ->delete(ApiAuth::SELLER)
            ->build();
        parent::__construct(Tag::class, $auth);
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