<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";


class LogoutApi extends Api {

    // implement methods
    protected function onPost(){
        if (isset($_SESSION["email"])){
            unset($_SESSION["email"]);
            unset($_SESSION["type"]);
            return true;
        }
        return false;
    }
    
}


Api::run(new LogoutApi());

?>