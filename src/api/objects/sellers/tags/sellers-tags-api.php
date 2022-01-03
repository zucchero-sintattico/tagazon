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

        if (!isset($params["seller"])) {
            return Response::badRequest("seller is required");
        }

        $seller = $params["seller"];
        $tags = TagsApi::get(["seller" => $seller])->getData();

        return Response::ok($tags);
    }
    
}


?>