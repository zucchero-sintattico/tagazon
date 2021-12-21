<?php

require_once __DIR__ . "/../../../require.php";

class SellersTagsApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }

    // implement methods
    public function onGet($params){

        if (!isset($params["seller"])) {
            $this->setResponseCode(400);
            $this->setResponseMessage("Bad Request");
            $this->setResponseData(["message" => "Missing parameter 'seller'"]);
            return;
        }

        $seller = $params["seller"];
        $tags = TagsApi::get(["seller" => $seller])["data"];

        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
        $this->setResponseData($tags);

    }
    
}


?>