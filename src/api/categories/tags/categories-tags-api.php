<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/../../../db/tables.php";
require_once __DIR__."/../categories-api.php";

class CategoriesTagsApi extends AuthApi {

    // implement methods
    public function onGet($params){

        if (!isset($params["category_id"])) {
            $this->setResponseCode(400);
            $this->setResponseMessage("Missing category_id parameter");
            return;
        }

        $category_id = $params["category_id"]; 
        $tags_cat = TagCategory::find([
            "category" => $category_id, 
        ]);

        $tags_id = array_map(function($tc){
            return $tc["tag"];
        }, $tags_cat);
        

        $tags = [];
        foreach($tags_id as $tag_id){
            array_push($tags, Tag::find(["id" => $tag_id])[0]);
        }

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($tags);
    }
    
}

?>