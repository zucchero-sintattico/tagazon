<?php

require_once __DIR__ . "/../../../require.php";

class CategoriesTagsApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();

        parent::__construct($auth);
    }

    // implement methods
    public function onGet($params){

        if (!isset($params["category_id"])) {
            return Response::badRequest("category_id is required");
        }

        $category_id = $params["category_id"];
        $tags_cat = TagsCategoriesApi::get(["category" => $category_id])->getData();

        $tags_id = array_map(function($tc){
            return $tc["tag"];
        }, $tags_cat);        

        $tags = [];
        foreach($tags_id as $tag_id){
            array_push($tags, TagsApi::get(["id" => $tag_id])->getData()[0]);
        }

        // sort based on name
        usort($tags, function($a, $b){
            return strcmp($a["name"], $b["name"]);
        });

        return Response::ok($tags);
    }
    
}

?>