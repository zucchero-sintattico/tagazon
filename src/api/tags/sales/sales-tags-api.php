<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/../../utils.php";
require_once __DIR__."/../../../db/tables.php";
require_once __DIR__."/../../../db/entity.php";
require_once __DIR__."/../tags-api.php";

class SalesTagsApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }


    // implement methods
    public function onGet($params){

        $tags = TagsApi::get([])["data"];
        $results = array_filter($tags, function($tag){
            return !is_null($tag["sale_price"]);
        });

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($results);

    }

    
}

?>