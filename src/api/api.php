<?php

abstract class Api {

  
    protected abstract function onGet();
    protected abstract function onPost(); 

    public function handle(){
        if( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
            $this->onGet();
        } else if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $this->onPost();
        }
    }

    public static function run($api){
        $api->handle();
    }


}

?>