<?php

require_once __DIR__ . "/require.php";

class Api {

	private ApiAuth $auth;

	public function __construct($auth=null) {
		$this->auth = is_null($auth) ? new ApiAuth() : $auth;
	}

	public function getAuth(): ApiAuth {
		return $this->auth;
	}
	
	/*
	Basic methods of API
	*/

	public function onGet($params) {
		return Response::methodNotAllowed();
	}
	public function onPost($params) {
		return Response::methodNotAllowed();
	}
	public function onPut($params) {
		return Response::methodNotAllowed();
	}
	public function onDelete($params) {
		return Response::methodNotAllowed();
	}



	private function _handle($method): Response {
		switch ($method) {
			case 'GET':
				return $this->onGet($_GET);
			case 'POST':
				return $this->onPost($_POST);
			case 'PUT':
				return $this->onPut(getRequestData());
			case 'DELETE':
				return $this->onDelete($_GET);
			default:
				return Response::methodNotAllowed();
		}
	}

    public function handle() {
        
		$method = $_SERVER['REQUEST_METHOD'];

		if (!$this->auth->checkAuth($method)) {
			$response = Response::unauthorized();
		} else {
			$response = $this->_handle($method);
		}

		$response->send();
    }

	// Main method for calling API
	public static function run($api){
        session_start();
		$api->handle();
	}



	/*
	STATIC FUNCTION FOR CALLING API
	*/

	private static function _execute($method, $api, $params, $server=false): Response {
		switch ($method){
			case 'GET':
				return $api->onGet($params, $server);
			case 'POST':
				return $api->onPost($params, $server);
			case 'PUT':
				return $api->onPut($params, $server);
			case 'DELETE':
				return $api->onDelete($params, $server);
			default:
				return Response::methodNotAllowed();
		}
	}

	public static function get($params, $server=false): Response {
		return self::_execute('GET', new static(), $params, $server);
	}

	public static function post($params, $server=false): Response {
		return self::_execute('POST', new static(), $params, $server);
	}

	public static function put($params, $server=false): Response {
		return self::_execute('PUT', new static(), $params, $server);
	}

	public static function delete($params, $server=false): Response{
		return self::_execute('DELETE', new static(), $params, $server);
	}
}
?>