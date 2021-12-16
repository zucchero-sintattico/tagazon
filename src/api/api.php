<?php
class Api {
	
	private $responseCode;
	private $responseMessage = "";
	private $responseData = [];

	private function _methodNotAllowed(){
		$this->setResponseCode(405);
		$this->setResponseMessage('Method Not Allowed');
		$this->setResponseData(null);
	}
	
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

	public function setResponseCode($code){
		$this->responseCode = $code;
	}

	public function setResponseMessage($message){
		$this->responseMessage = $message;
	}

	public function setResponseData($data, $json = false){
		$this->responseData = $json ? json_encode($data) : $data;
	}
	

	/**
	 * Get the PATCH request data.
	 */
	private function getRequestData()
	{
		$data = [];
		parse_str(file_get_contents('php://input'), $data);
		parse_raw_http_request($data);
		return $data;
	}

	public function sendResponse(){
		header('Content-Type: application/json');
		http_response_code($this->responseCode);
		echo json_encode(array(
			"code" => $this->responseCode,
			"message" => $this->responseMessage,
			"data" => $this->responseData
		));
	}
	
	public function handle()
	{
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				$this->onGet($_GET);
				break;
			case 'POST':
				$this->onPost($_POST);
				break;
			case 'PATCH':
				$this->onPatch($this->getRequestData());
				break;
			case 'DELETE':
				$this->onDelete($_GET);
				break;
			default:
				$this->_methodNotAllowed();
				break;
		}

		$this->sendResponse();
	}

	public static function run($api){
        session_start();
		$api->handle();
	}

	public static function get($params){
		ob_start();
		$api = new static();
		$api->onGet($params);
		$api->sendResponse();
		$response = ob_get_clean();
		return json_decode($response)->data;
	}
}
?>