<?php

require_once "api.php";
require_once "auth-api.php";
 
class IndexAPI extends AuthAPI {
     
    protected function onGet(){
        echo "Benvenuti nelle API di Tagazon";
    }

    protected function onPost(){

    }
}

$api = new IndexAPI();
$api->handle();

?>