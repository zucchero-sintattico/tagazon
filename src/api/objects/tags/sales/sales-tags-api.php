<?php

require_once __DIR__ . "/../../../require.php";

class SalesTagsApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }


    // implement methods
    public function onGet($params){

        $tags = TagsApi::get([])->getData();
        $results = array_filter($tags, function($tag){
            return !is_null($tag["sale_price"]);
        });

        return Response::ok($results);

    }

    
}

?>