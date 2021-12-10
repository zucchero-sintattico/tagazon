<?php

require_once "../api.php";
require_once "../../db/tags/tag.php";

class TagsAPI extends API {

    protected function onGet(){
        // check if parameter id is set
        if (isset($_GET['id'])) {
            echo json_encode(Tag::find($_GET['id']));
        } else {
            echo json_encode(Tag::all());
        }
    }

    protected function onPost(){
        
    }

    protected function onPatch(){

    }

    protected function onDelete(){
        if (isset($_GET['tagId'])) {
            echo (Tag::delete($_GET['tagId']));
        }
    }
}

API::run(new TagsAPI());

?>