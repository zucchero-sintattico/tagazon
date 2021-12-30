<?php

require_once __DIR__ . "/../../../require.php";

class TagCategoriesApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }

    // implement methods
    public function onGet($params){

        if (!isset($params["tag_id"])) {
            $this->setResponseCode(400);
            $this->setResponseMessage("Missing tag_id parameter");
            return;
        }

        $tag_id = $params["tag_id"]; 
        
        $tags_cat = TagsCategoriesApi::get(["tag" => $tag_id])["data"];

        $cats_ids = array_unique(array_map(function($tc){
            return $tc->category;
        }, $tags_cat));

        $cats = [];
        foreach($cats_ids as $cat_id){
            $cats[] = CategoriesApi::get(["id" => $cat_id])["data"][0];
        }

        // sort based on name
        usort($cats, function($a, $b){
            return strcmp($a->name, $b->name);
        });

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($cats);
    }
    
}

?>