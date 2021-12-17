<?php

require_once(__DIR__ . "/../db/entity.php");
require_once(__DIR__ . "/api.php");
require_once(__DIR__ . "/utils.php");
require_once(__DIR__ . "/auth-api-builder.php");

abstract class AuthApi extends Api
{
    const OPEN = 1;
    const BUYER = 2;
    const SELLER = 3;
    const SERVER = 4;
    

    protected $getAuth;
    protected $postAuth;
    protected $patchAuth;
    protected $deleteAuth;

    public function __construct($getAuth=AuthApi::OPEN, $postAuth=AuthApi::SERVER, $patchAuth=AuthApi::SERVER, $deleteAuth=AuthApi::SERVER){
		$this->getAuth = $getAuth;
		$this->postAuth = $postAuth;
		$this->patchAuth = $patchAuth;
		$this->deleteAuth = $deleteAuth;
	}


    protected function isBuyer(){
        return isset($_SESSION["user"]) && $_SESSION["user"]["type"] == "buyer";
    }

    protected function isSeller(){
        return isset($_SESSION["user"]) && $_SESSION["user"]["type"] == "seller";
    }

    protected function checkServer(){
        return false;
        $whitelist = array('127.0.0.1', "::1");
        return in_array(get_client_ip(), $whitelist);
    }

    private function _checkAuth($auth){
        switch($auth){
            case AuthApi::OPEN:
                return true;
            case AuthApi::BUYER:
                return $this->isBuyer() || $this->checkServer();
            case AuthApi::SELLER:
                return $this->isSeller() || $this->checkServer();
            case AuthApi::SERVER:
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

    public function handle($sendResponse=true){
        
        if ($this->checkAuth()){
            parent::handle(false);
        }else{
            $this->setResponseCode(401);
            $this->setResponseMessage("Unauthorized");
        }

        if ($sendResponse){
            $this->sendResponse();
        }
    }

    public static function builder(){
        return new AuthApiBuilder(static::class);
    }

}
?>