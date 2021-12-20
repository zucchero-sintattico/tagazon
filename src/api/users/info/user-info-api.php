<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/../../utils.php";
require_once __DIR__."/../../../db/tables.php";
require_once __DIR__."/../../../db/entity.php";


class UserInfoApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::OPEN, Api::DENIED, Api::DENIED, Api::DENIED);
    }


    public function onGet($params){
        if (!isset($_SESSION["user"])){
            $this->setResponseCode(404);
            $this->setResponseMessage("User not logged in");
            return;
        }

        $user = $_SESSION["user"];
        unset($user["password"]);

        $this->setResponseCode(200);
        $this->setResponseMessage("User info");
        $this->setResponseData($user);
    }
    
}

?>