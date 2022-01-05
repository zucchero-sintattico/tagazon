<?php

require_once __DIR__ . "/../../require.php";

class CategoriesApi extends EntityApi {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();

        parent::__construct(Category::class, $auth);
    }

}

?>