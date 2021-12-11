<?php

require_once "api.php";

class AuthAPI extends Api
{
    const UNAUTHENTICATED = 1;
    const AUTHENTICATED = 2;
    const ADMIN = 3;

    private $getAuth;
    private $postAuth;
    private $patchAuth;
    private $deleteAuth;

    public function __construct($class, $getAuth=AuthAPI::AUTHENTICATED, $postAuth=AuthAPI::AUTHENTICATED, $patchAuth=AuthAPI::AUTHENTICATED, $deleteAuth=AuthAPI::AUTHENTICATED)
    {
        parent::__construct($class);
        $this->getAuth = $getAuth;
        $this->postAuth = $postAuth;
        $this->patchAuth = $patchAuth;
        $this->deleteAuth = $deleteAuth;
    }

    private function checkAuthenticated(){

    }
    private function checkAdmin(){

    }

    private function _checkAuth($auth){
        switch($auth){
            case AuthAPI::UNAUTHENTICATED:
                return true;
            case AuthAPI::AUTHENTICATED:
                return $this->checkAuthenticated();
            case AuthAPI::ADMIN:
                return $this->checkAdmin();
            }

    }

    private function checkAuth(){
        // switch on request method
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return $this->_checkAuth($this->getAuth);
            case 'POST':
                return $this->_checkAuth($this->postAuth);
            case 'PATCH':
                return $this->_checkAuth($this->patchAuth);
            case 'DELETE':
                return $this->_checkAuth($this->deleteAuth);
            default:
                return false;
        }
    }

    public function handle(){
        if ($this->checkAuth()){
            parent::handle();
        }else{
            echo "Unauthorized";
        }
    }



}

?>