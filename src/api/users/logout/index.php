<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";


class LogoutApi extends Api {

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


Api::run(new LogoutApi());

?>