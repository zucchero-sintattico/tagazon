<?php

require_once "../api.php";
require_once "../../db/tags/tag.php";

class TagsAPI extends API {

    protected function onGet(){
        echo Tag::all();
    }

    protected function onPost(){

    }
}

API::run(new TagsAPI());

?>