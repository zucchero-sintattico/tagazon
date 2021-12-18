<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/../../utils.php";
require_once __DIR__."/../../../db/tables.php";


class LogoutApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::DENIED, Api::OPEN, Api::DENIED, Api::DENIED);
    }

    // implement methods
    public function onPost($params){
        if (isset($_SESSION["user"])){
            unset($_SESSION["user"]);
            $this->setResponseCode(200);
            $this->setResponseMessage("Logout effettuato con successo");
        } else {
            $this->setResponseCode(400);
            $this->setResponseMessage("Non sei loggato");
        }
    }
    
}


?>