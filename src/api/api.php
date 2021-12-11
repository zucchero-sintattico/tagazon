<?php
class Api {
	
	private function _methodNotAllowed(){
		http_response_code(405);
		return "Method Not Allowed";
	}
	
	protected function onGet(){
		return $this->_methodNotAllowed();
	}
	protected function onPost(){
		return $this->_methodNotAllowed();
	}
	protected function onPatch(){
		return $this->_methodNotAllowed();
	}
	protected function onDelete(){
		return $this->_methodNotAllowed();
	}
	
	public function handle()
	{
		header('Content-Type: application/json');

		$response = null;
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				$response = $this->onGet();
				break;
			case 'POST':
				$response = $this->onPost();
				break;
			case 'PATCH':
				$response = $this->onPost();
				break;
			case 'DELETE':
				$response = $this->onDelete();
				break;
			default:
				http_response_code(405);
				$response = "Method Not Allowed";
				break;
		}

		return json_encode($response);
	}

	public static function run($api){
		echo $api->handle();
	}
}
?>