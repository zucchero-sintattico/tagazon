<?php

require_once "api.php";
require_once "authenticated-api.php";
 
class IndexAPI extends AuthenticatedApi {
     
    protected function onGet(){
        echo "Benvenuti nelle API di Tagazon";
    }

    protected function onPost(){

    }
}

$api = new IndexAPI();
$api->handle();

?>