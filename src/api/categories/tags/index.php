<?php

require_once "../../api.php";
require_once "../../../db/tables.php";

class CategoriesTag extends Api {

    // implement methods
    protected function onGet(){
        $category_id = $_GET["category_id"];

        $tag_cat = json_decode(file_get_contents("http://localhost/tagazon/src/api/tag_categories/?category=$category_id"));
        $tags_id = array_map(function($tc){
            return $tc->tag;
        }, $tag_cat);
        
        $tags = array_map(function($tag_id){
            return json_decode(file_get_contents("http://localhost/tagazon/src/api/tags/?id=$tag_id"))[0];
        }, $tags_id);
        return $tags;
    }
    
}


Api::run(new CategoriesTag());

?>