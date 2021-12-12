<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";


class LogoutApi extends Api {

    // implement methods
    protected function onPost(){
        if (isset($_SESSION["email"])){
            unset($_SESSION["email"]);
            if ($_SESSION["type"] == "buyer"){
                unset($_SESSION["name"]);
                unset($_SESSION["surname"]);
            } else {
                unset($_SESSION["rag_soc"]);
                unset($_SESSION["piva"]);
            }
            unset($_SESSION["type"]);
            return true;
        }
        return false;
    }
    
}


Api::run(new LogoutApi());

?>