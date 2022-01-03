<?php

require_once __DIR__ . "/require.php";

class Api {
	
	private $responseCode;
	private $responseMessage = "";
	private $responseData = [];

    const OPEN = 1;
    const BUYER = 2;
    const SELLER = 3;
    const SERVER = 4;
    const DENIED = 5;
    
    protected $getAuth;
    protected $postAuth;
    protected $patchAuth;
    protected $deleteAuth;

    public function __construct($getAuth=Api::OPEN, $postAuth=Api::SERVER, $patchAuth=Api::SERVER, $deleteAuth=Api::SERVER){
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

	protected function isPythonBot(){
		return isset($_GET["python-bot"]);
	}

    private function _checkAuth($auth){
        switch($auth){
            case Api::OPEN:
                return true;
            case Api::BUYER:
                return $this->isBuyer() || $this->isPythonBot();
            case Api::SELLER:
                return $this->isSeller()|| $this->isPythonBot();
            case Api::SERVER:
                return $this->isPythonBot();
            case Api::DENIED:
                return false;
            }
    }

	/**
	 * Get the Request data (for Patch request).
	 */
	private function getRequestData()
	{
		$data = [];
		parse_raw_http_request($data);
		return $data;
	}

    public function handle($sendResponse=true){
        
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				if ($this->_checkAuth($this->getAuth)){
					$this->onGet($_GET);
				} else {
					$this->_unauthorized();
				}
				break;
			case 'POST':
				if ($this->_checkAuth($this->postAuth)){
					$this->onPost($_POST);
				} else {
					$this->_unauthorized();
				}
				break;
			case 'PATCH':
				if ($this->_checkAuth($this->patchAuth)){
					$this->onPatch($this->getRequestData());
				} else {
					$this->_unauthorized();
				}
				break;
			case 'DELETE':
				if ($this->_checkAuth($this->deleteAuth)){
					$this->onDelete($_GET);
				} else {
					$this->_unauthorized();
				}
				break;
			default:
				$this->_methodNotAllowed();
				break;
		}

        if ($sendResponse){
            $this->sendResponse();
        }
    }

	private function _unauthorized(){
		$this->setResponseCode(401);
		$this->setResponseMessage("Unauthorized");
	}

	private function _methodNotAllowed(){
		$this->setResponseCode(405);
		$this->setResponseMessage('Method Not Allowed');
	}
	
	/*
	Basic methods of API
	*/

	public function onGet($params){
		$this->_methodNotAllowed();
	}
	public function onPost($params){
		$this->_methodNotAllowed();
	}
	public function onPatch($params){
		$this->_methodNotAllowed();
	}
	public function onDelete($params){
		$this->_methodNotAllowed();
	}


	/*
	Response management
	*/

	public function setResponseCode($code){
		$this->responseCode = $code;
	}

	public function setResponseMessage($message){
		$this->responseMessage = $message;
	}

	public function setResponseData($data, $json = false){
		$this->responseData = $json ? json_encode($data) : $data;
	}

	public function sendResponse(){
		header('Content-Type: application/json');
		http_response_code($this->responseCode);
		echo json_encode([
			"code" => $this->responseCode,
			"message" => $this->responseMessage,
			"data" => $this->responseData
		]);
	}

	/*
	STATIC FUNCTION FOR CALLING API
	*/

	// Main method for calling API
	public static function run($api){
        session_start();
		$api->handle();
	}

	public static function get($params, $server=false){
		ob_start();
		$api = new static();
		$api->onGet($params, $server);
		$api->sendResponse();
		$response = ob_get_clean();
		return (array)json_decode($response);
	}

	public static function post($params, $server=false){
		ob_start();
		$api = new static();
		$api->onPost($params, $server);
		$api->sendResponse();
		$response = ob_get_clean();
		return (array)json_decode($response);
	}

	public static function patch($params, $server=false){
		ob_start();
		$api = new static();
		$api->onPatch($params, $server);
		$api->sendResponse();
		$response = ob_get_clean();
		return (array)json_decode($response);
	}

	public static function delete($params, $server=false){
		ob_start();
		$api = new static();
		$api->onDelete($params, $server);
		$api->sendResponse();
		$response = ob_get_clean();
		return (array)json_decode($response);
	}
}
?>