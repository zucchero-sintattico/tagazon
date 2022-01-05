<?php

require_once __DIR__ . "/../../../require.php";

class SellersTagsApi extends Api {

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
            return Response::badRequest("seller is required");
        }

        $seller_id = $params["seller_id"];
        $tags = TagsApi::get(["seller" => $seller_id])->getData();

        return Response::ok($tags);
    }
    
}


?>