<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";
require_once "../../../db/entity.php";

class SalesTagApi extends Api {


    // implement methods
    public function onGet($params){

        $tags = Tag::all();
        $results = array_filter($tags, function($tag){
            return !is_null($tag["sale_price"]);
        });

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($results);

    }
    
}


Api::run(new SalesTagApi());

?>