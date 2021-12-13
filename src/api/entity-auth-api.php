<?php

require_once "entity-api.php";

class EntityAuthApiBuilder{

    private $class;
    private $getAuth = EntityAuthApi::OPEN;
    private $postAuth = EntityAuthApi::OPEN;
    private $patchAuth = EntityAuthApi::OPEN;
    private $deleteAuth = EntityAuthApi::OPEN;

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
        return new EntityAuthApi($this->class, $this->getAuth, $this->postAuth, $this->patchAuth, $this->deleteAuth);
    }

}

class EntityAuthApi extends EntityApi
{
    const OPEN = 1;
    const BUYER = 2;
    const SELLER = 3;
    const SERVER = 4;
    

    private $getAuth;
    private $postAuth;
    private $patchAuth;
    private $deleteAuth;

    public function __construct($class, $getAuth=EntityAuthApi::BUYER, $postAuth=EntityAuthApi::BUYER, $patchAuth=EntityAuthApi::BUYER, $deleteAuth=EntityAuthApi::BUYER)
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
        return true;
    }


    private function checkServer(){
        return true;
        $whitelist = array('127.0.0.1', "::1");
        return in_array(get_client_ip(), $whitelist);
    }

    private function _checkAuth($auth){
        switch($auth){
            case EntityAuthApi::OPEN:
                return true;
            case EntityAuthApi::BUYER:
                return $this->checkBuyer() || $this->checkServer();
            case EntityAuthApi::SELLER:
                return $this->checkSeller() || $this->checkServer();
            case EntityAuthApi::SERVER:
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

    public function filterOnAuthentication($jsonElements){

        return $jsonElements;
    }

    public function handle(){
        
        if ($this->checkAuth()){
            $result = parent::handle();
            return $this->filterOnAuthentication($result);
        }else{
            http_response_code(401);
            return json_encode("Unauthorized");
        }

    }

    public static function builder($class){
        return new EntityAuthApiBuilder($class);
    }



}

?>