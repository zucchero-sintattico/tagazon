<?php

require_once(__DIR__ . "/../db/entity.php");
require_once(__DIR__ . "/api.php");
require_once(__DIR__ . "/utils.php");

class EntityApi extends Api
{

	private $class;

	public function __construct($class)
	{
		$this->class = $class;
	}

	/**
	 * Get the elements.
	 * Possible find on specified id.
	 */
	protected function onGet()
	{
		$res = Entity::find($this->class, $_GET);
		http_response_code(count($res) == 0 && count(array_keys($_GET)) > 0 ? 404 : 200);
		return $res;
	}

	/**
	 * Create a new element.
	 */
	protected function onPost()
	{
		$params = [];
		foreach ($this->class::fields as $key => $value) {
			if (isset($_POST[$key])) {
				array_push($params, $_POST[$key]);
			}
		}

		$res = Entity::create($this->class, ...$params);
		http_response_code($res != 0 ? 201 : 500);
		return $res;
	}

	/**
	 * Update an element.
	 */
	protected function onPatch()
	{
		if (isset($_GET['id'])) {
			$_PATCH = $this->getPatchData();
			$params = [];
			foreach ($this->class::fields as $key => $value) {
				if (isset($_PATCH[$key])) {
					array_push($params, $_PATCH[$key]);
				}
			}
			$res = Entity::update($this->class, $_GET['id'], ...$params);
			http_response_code($res ? 200 : 500);
			return $res;
		}
	}

	/**
	 * Delete an element.
	 */
	protected function onDelete()
	{
		if (isset($_GET['id'])) {
			foreach ($this->class::fields as $key => $value) {
				if (isset($_POST[$key])) {
					array_push($params, $_POST[$key]);
				}
			}
			$res = Entity::delete($this->class, $_GET['id']);
			http_response_code($res ? 200 : 500);
			return $res;
		}
	}

	/**
	 * Get the PATCH request data.
	 */
	protected function getPatchData()
	{
		$_PATCH = [];
		parse_str(file_get_contents('php://input'), $_PATCH);
		parse_raw_http_request($_PATCH);
		return $_PATCH;
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

}
