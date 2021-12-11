<?php
abstract class Api {
	
	protected abstract function onGet();
	protected abstract function onPost();
	protected abstract function onPatch();
	protected abstract function onDelete();
	
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