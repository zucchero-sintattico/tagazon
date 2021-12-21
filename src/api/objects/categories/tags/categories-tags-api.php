<?php

require_once __DIR__ . "/../../../require.php";

class CategoriesTagsApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }

    // implement methods
    public function onGet($params){

        if (!isset($params["category_id"])) {
            $this->setResponseCode(400);
            $this->setResponseMessage("Missing category_id parameter");
            return;
        }

        $category_id = $params["category_id"]; 
        
        $tags_cat = TagsCategoriesApi::get(["category" => $category_id])["data"];

        $tags_id = array_map(function($tc){
            return $tc->tag;
        }, $tags_cat);
        

        $tags = [];
        foreach($tags_id as $tag_id){
            array_push($tags, TagsApi::get(["id" => $tag_id])["data"][0]);
        }

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($tags);
    }
    
}

?>