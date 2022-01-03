<?php

require_once __DIR__ . "/../../../require.php";

class TagCategoriesApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }

    // implement methods
    public function onGet($params){

        if (!isset($params["tag_id"])) {
            return Response::badRequest("tag_id is required");
        }

        $tag_id = $params["tag_id"]; 
        
        $tags_cat = TagsCategoriesApi::get(["tag" => $tag_id])->getData();

        $cats_ids = array_unique(array_map(function($tc){
            return $tc["category"];
        }, $tags_cat));

        $cats = [];
        foreach($cats_ids as $cat_id){
            $cats[] = CategoriesApi::get(["id" => $cat_id])->getData()[0];
        }

        // sort based on name
        usort($cats, function($a, $b){
            return strcmp($a["name"], $b["name"]);
        });

        return Response::ok($cats);
    }
    
}

?>