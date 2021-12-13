<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";


class AddToShoppingCartApi extends Api {

    // implement methods
    protected function onPost(){
        
    }
    
}


Api::run(new AddToShoppingCartApi());

?>