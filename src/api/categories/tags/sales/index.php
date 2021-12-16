<?php

require_once "../../../api.php";
require_once "../../../utils.php";
require_once "../../../../db/tables.php";
require_once "../../../../db/entity.php";
require_once "../categories-tag-api.php";

class CategoriesSalesTagApi extends Api {


    // implement methods
    public function onGet($params){

        $tags = CategoriesTagApi::get([
            "category_id" => $params["category_id"],
        ]);
        
        $response = array_filter($tags, function ($tag) {
            return !is_null($tag->sale_price);
        });

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($response);

    }
    
}


Api::run(new CategoriesSalesTagApi());

?>