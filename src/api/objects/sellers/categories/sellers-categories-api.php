<?php

require_once __DIR__ . "/../../../require.php";

class SellersCategoriesApi extends Api {

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

        $seller_id = $params["seller_id"];
        $tags = TagsApi::get(["seller" => $seller_id])->getData();

        $categories = [];
        foreach ($tags as $tag) {
            $cgs = TagsCategoriesApi::get(["tag" => $tag["id"]])->getData();
            foreach ($cgs as $cg) {
                if (!in_array($cg["category"], $categories)) {
                    array_push($categories, $cg["category"]);
                }
            }
        }

        $categories_data = [];
        foreach ($categories as $category) {
            array_push($categories_data, CategoriesApi::get(["id" => $category])->getData()[0]);
        }

        return Response::ok($categories_data);
    }
    
}


?>