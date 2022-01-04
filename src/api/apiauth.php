<?php

require_once __DIR__ . "/require.php";

class ApiAuth {

	const OPEN = 1;
	const BUYER = 2;
	const SELLER = 3;
	const SERVER = 4;

	private $getAuth = ApiAuth::SERVER;
	private $postAuth = ApiAuth::SERVER;
	private $putAuth = ApiAuth::SERVER;
	private $deleteAuth = ApiAuth::SERVER;

	public function __construct($getAuth=ApiAuth::SERVER, $postAuth=ApiAuth::SERVER, $putAuth=ApiAuth::SERVER, $deleteAuth=ApiAuth::SERVER) {
		$this->getAuth = $getAuth;
		$this->postAuth = $postAuth;
		$this->putAuth = $putAuth;
		$this->deleteAuth = $deleteAuth;
	}

	public function getAuth() {
		return $this->getAuth;
	}

	public function postAuth() {
		return $this->postAuth;
	}

	public function putAuth() {
		return $this->putAuth;
	}

	public function deleteAuth() {
		return $this->deleteAuth;
	}

	private function isBuyer(){
        return isset($_SESSION["user"]) && $_SESSION["user"]["type"] == "buyer";
    }

    private function isSeller(){
        return isset($_SESSION["user"]) && $_SESSION["user"]["type"] == "seller";
    }

	private function _checkAuth($auth){
		if(isPythonBot()) return true;
		if($auth == ApiAuth::OPEN) return true;
		if($auth == ApiAuth::BUYER && $this->isBuyer()) return true;
		if($auth == ApiAuth::SELLER && $this->isSeller()) return true;
		return false;
	}

	public function checkAuth($method){
		switch ($method) {
			case 'GET':
				return $this->_checkAuth($this->getAuth);
			case 'POST':
				return $this->_checkAuth($this->postAuth);
			case 'PUT':
				return $this->_checkAuth($this->putAuth);
			case 'DELETE':
				return $this->_checkAuth($this->deleteAuth);
			default:
				return false;
		}
	}

    public static function builder(){
        return new ApiAuthBuilder();
    }

}

class ApiAuthBuilder {

	private $getAuth;
	private $postAuth;
	private $putAuth;
	private $deleteAuth;

	public function __construct() {
		$this->getAuth = ApiAuth::OPEN;
		$this->postAuth = ApiAuth::OPEN;
		$this->putAuth = ApiAuth::OPEN;
		$this->deleteAuth = ApiAuth::OPEN;
	}

	public function get($auth) {
		$this->getAuth = $auth;
		return $this;
	}

	public function post($auth) {
		$this->postAuth = $auth;
		return $this;
	}

	public function put($auth) {
		$this->putAuth = $auth;
		return $this;
	}

	public function delete($auth) {
		$this->deleteAuth = $auth;
		return $this;
	}

	public function build() {
		return new ApiAuth($this->getAuth, $this->postAuth, $this->putAuth, $this->deleteAuth);
	}


}

?>