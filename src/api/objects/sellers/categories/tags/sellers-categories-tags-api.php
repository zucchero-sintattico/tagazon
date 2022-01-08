<?php

require_once __DIR__ . "/../../../../require.php";

class SellersCategoriesTagsApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }

    // implement methods
    public function onGet($params){

        if (!isset($params["seller_id"])) {
            return Response::badRequest("seller_id is required");
        }

        if (!isset($params["category_id"])) {
            return Response::badRequest("category_id is required");
        }

        $seller_id = $params["seller_id"];
        $category_id = $params["category_id"];

        $tags = SellersTagsApi::get(["seller_id" => $seller_id])->getData();
        $cattags = TagsCategoriesApi::get(["category" => $category_id])->getData();

        $tags_categories = [];
        foreach ($tags as $tag) {
            foreach ($cattags as $cattag) {
                if ($tag["id"] == $cattag["tag"]) {
                    if (!in_array($tag, $tags_categories)) {
                        array_push($tags_categories, $tag);
                    }
                }
            }
        }

        return Response::ok($tags_categories);
    }
    
}


?>