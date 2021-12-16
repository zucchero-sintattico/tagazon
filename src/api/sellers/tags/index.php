<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";
require_once "../../../db/entity.php";

class SellerTagApi extends Api {


    // implement methods
    public function onGet($params){

        if (!isset($params["seller"])) {
            $this->setResponseCode(400);
            $this->setResponseMessage("Bad Request");
            $this->setResponseData(["message" => "Missing parameter 'seller'"]);
            return;
        }

        $seller = $params["seller"];
        $results = Tag::find(["seller" => $seller]);

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($results);

    }
    
}


Api::run(new SellerTagApi());

?>