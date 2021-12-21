<?php

require_once __DIR__ . "/../../../../require.php";

class CategoriesTagsSalesApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }


    // implement methods
    public function onGet($params){

        $tags = CategoriesTagsApi::get(["category_id" => $params["category_id"]])["data"];
        
        $response = array_filter($tags, function ($tag) {
            return !is_null($tag->sale_price);
        });

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($response);
    }
    
}

?>