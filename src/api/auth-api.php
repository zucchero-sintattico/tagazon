<?php

require_once "api.php";

abstract class AuthAPI extends Api
{

    private function checkAuth(){
        return false;
    }

    public function handle()
    {
        if ($this->checkAuth()) {
            return parent::handle();
        } else {
            echo "Not authenticated";
        }
    }

}

?>