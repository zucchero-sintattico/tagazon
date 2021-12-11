<?php

require_once "api.php";

class AuthAPIBuilder{

    private $class;
    private $getAuth = AuthAPI::UNAUTHENTICATED;
    private $postAuth = AuthAPI::UNAUTHENTICATED;
    private $patchAuth = AuthAPI::UNAUTHENTICATED;
    private $deleteAuth = AuthAPI::UNAUTHENTICATED;

    public function __construct($class){
        $this->class = $class;
    }

    public function get($auth){
        $this->getAuth = $auth;
        return $this;
    }

    public function post($auth){
        $this->postAuth = $auth;
        return $this;
    }

    public function patch($auth){
        $this->patchAuth = $auth;
        return $this;
    }

    public function delete($auth){
        $this->deleteAuth = $auth;
        return $this;
    }

    public function build(){
        return new AuthAPI($this->class, $this->getAuth, $this->postAuth, $this->patchAuth, $this->deleteAuth);
    }

}
class AuthAPI extends Api
{
    const OPEN = 1;
    const BUYER = 2;
    const SELLER = 3;
    const SERVER = 4;
    

    private $getAuth;
    private $postAuth;
    private $patchAuth;
    private $deleteAuth;

    public function __construct($class, $getAuth=AuthAPI::BUYER, $postAuth=AuthAPI::BUYER, $patchAuth=AuthAPI::BUYER, $deleteAuth=AuthAPI::BUYER)
    {
        parent::__construct($class);
        $this->getAuth = $getAuth;
        $this->postAuth = $postAuth;
        $this->patchAuth = $patchAuth;
        $this->deleteAuth = $deleteAuth;
    }

    private function checkBuyer(){
        return true;
    }

    private function checkSeller(){
        return false;
    }

    private function checkServer(){
        return false;
    }

    private function _checkAuth($auth){
        switch($auth){
            case AuthAPI::OPEN:
                return true;
            case AuthAPI::BUYER:
                return $this->checkBuyer() || $this->checkServer();
            case AuthAPI::SELLER:
                return $this->checkSeller() || $this->checkServer();
            case AuthAPI::SERVER:
                return $this->checkServer();
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



    public static function builder($class){
        return new AuthAPIBuilder($class);
    }



}

?>