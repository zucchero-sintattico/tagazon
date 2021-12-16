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

	private function filterParams($class, $params)
	{
		$filtered = [];
		foreach ($params as $key => $value) {
			if (isset($class::fields[$key]) || $key == 'id') {
				$filtered[$key] = $value;
			}
		}
		return $filtered;
	}


	/**
	 * Get the elements.
	 * Possible find on specified id.
	 */
	public function onGet($params)
	{
		$params = $this->filterParams($this->class, $params);
		$res = $this->class::find($params);
		$this->setResponseCode(count($res) == 0 && count(array_keys($params)) > 0 ? 404 : 200);
		$this->setResponseMessage(count($res) == 0 && count(array_keys($params)) > 0 ? "Not found" : "OK");
		$this->setResponseData($res);
	}

	/**
	 * Create a new element.
	 */
	public function onPost($params)
	{
		$params = $this->filterParams($this->class, $params);
		$res = $this->class::create($params);
		$this->setResponseCode($res > 0 ? 201 : 400);
		$this->setResponseMessage($res > 0 ? "Created" : "Bad request");
		$this->setResponseData([
			"id" => $res
		]);
	}

	/**
	 * Update an element.
	 */
	public function onPatch($params)
	{
		if (!isset($params['id'])) {
			$this->setResponseCode(400);
			$this->setResponseMessage("Missing id");
			return;
		}

		$params = $this->filterParams($this->class, $params);
		$res = $this->class::update($params);
		$this->setResponseCode($res ? 200 : 400);
		$this->setResponseMessage($res ? "Updated" : "Bad request");
	}

	/**
	 * Delete an element.
	 */
	public function onDelete($params)
	{
		if (!isset($params['id'])) {
			$this->setResponseCode(400);
			$this->setResponseMessage("Missing id");
			return;
		}

		$res = $this->class::delete($params['id']);
		$this->setResponseCode($res ? 200 : 404);
		$this->setResponseMessage($res ? "Deleted" : "Not found");
	}


}
