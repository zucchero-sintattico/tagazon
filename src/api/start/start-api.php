<?php

require_once __DIR__ . "/../require.php";

class StartApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }


    public function onGet($params){
        session_start();
        $this->setResponseCode(200);
        $this->setResponseMessage("OK");
    }
    
}

?>