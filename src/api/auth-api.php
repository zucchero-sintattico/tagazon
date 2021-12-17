<?php

require_once(__DIR__ . "/../db/entity.php");
require_once(__DIR__ . "/api.php");
require_once(__DIR__ . "/utils.php");

class AuthApiBuilder{

    protected $class;
    protected $getAuth = AuthApi::DENIED;
    protected $postAuth = AuthApi::DENIED;
    protected $patchAuth = AuthApi::DENIED;
    protected $deleteAuth = AuthApi::DENIED;

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
        return new $this->class($this->getAuth, $this->postAuth, $this->patchAuth, $this->deleteAuth);
    }

}

abstract class AuthApi extends Api
{
    const OPEN = 1;
    const BUYER = 2;
    const SELLER = 3;
    const SERVER = 4;
	const DENIED = 5;
    

    private $getAuth;
    private $postAuth;
    private $patchAuth;
    private $deleteAuth;

    public function __construct($getAuth=AuthApi::DENIED, $postAuth=AuthApi::DENIED, $patchAuth=AuthApi::DENIED, $deleteAuth=AuthApi::DENIED){
		$this->getAuth = $getAuth;
		$this->postAuth = $postAuth;
		$this->patchAuth = $patchAuth;
		$this->deleteAuth = $deleteAuth;
	}

    public function filterOnAuthentication($jsonElements){
        return $jsonElements;
    }


    private function checkBuyer(){
        return isset($_SESSION["type"]) && $_SESSION["type"] == "buyer";
    }

    private function checkSeller(){
        return isset($_SESSION["type"]) && $_SESSION["type"] == "seller";
    }


    private function checkServer(){
        return false;
        $whitelist = array('127.0.0.1', "::1");
        return in_array(get_client_ip(), $whitelist);
    }

    private function _checkAuth($auth){
        switch($auth){
            case AuthApi::OPEN:
                return true;
            case AuthApi::BUYER:
                return $this->checkBuyer() || $this->checkServer();
            case AuthApi::SELLER:
                return $this->checkSeller() || $this->checkServer();
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
            $result = parent::handle(false);
            if (!$this->checkServer()){
                $this->setResponseData($this->filterOnAuthentication($this->getResponseData()));
            }
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