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

        $results = array_filter($tags, function($tag) use ($category_id){
            return $tag["category"] == $category_id;
        });

        return Response::ok($tags);
    }
    
}


?>