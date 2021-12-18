<?php

require_once(__DIR__ . "/../db/entity.php");
require_once(__DIR__ . "/api.php");
require_once(__DIR__ . "/utils.php");
require_once(__DIR__ . "/../db/tables.php");
abstract class EntityApi extends Api
{

	private $entity;

	public function __construct($entity, $getAuth=Api::OPEN, $postAuth=Api::SERVER, $patchAuth=Api::SERVER, $deleteAuth=Api::SERVER){
		parent::__construct($getAuth, $postAuth, $patchAuth, $deleteAuth);
		$this->entity = $entity;
	}

	protected function canAccess($element){
		return true;
	}
	protected function canModify($element){
		return true;
	}
	protected function canDelete($element){
		return true;
	}

	private function filterParams($params)
	{
		$filtered = [];
		foreach ($params as $key => $value) {
			if (isset($this->entity::fields[$key]) || $key == 'id') {
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
		$params = $this->filterParams($params);
		$res = $this->entity::find($params);

		// filters in order to get only the elements that the user has access to
		if ($this->getAuth != Api::OPEN && !$this->checkServer()){
			$res = array_filter($res, function($element) {
				return $this->canAccess($element);
			});
		}

		$this->setResponseCode(count($res) == 0 && count(array_keys($params)) > 0 ? 404 : 200);
		$this->setResponseMessage(count($res) == 0 && count(array_keys($params)) > 0 ? "Not found" : "OK");
		$this->setResponseData($res);
	}

	/**
	 * Create a new element.
	 */
	public function onPost($params)
	{
		$params = $this->filterParams($params);
		$res = $this->entity::create($params);
		$this->setResponseCode($res > 0 ? 201 : 400);
		$this->setResponseMessage($res > 0 ? "Created" : "Bad request");
		$this->setResponseData($res > 0 ? ["id" => $res] : []);
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

		$params = $this->filterParams($params);
		$element = $this->entity::find(["id" => $params['id']]);

		if ($this->patchAuth != Api::OPEN && !$this->checkServer() && !$this->canModify($element)) {
			$this->setResponseCode(403);
			$this->setResponseMessage("Forbidden");
			return;
		}

		$res = $this->entity::update($params);
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

		$params = $this->filterParams($params);
		$element = $this->entity::find(["id" => $params['id']]);
		if ($this->deleteAuth != Api::OPEN && !$this->checkServer() && !$this->canDelete($element) ) {
			$this->setResponseCode(403);
			$this->setResponseMessage("Forbidden");
			return;
		}
		$res = $this->entity::delete($params['id']);
		$this->setResponseCode($res ? 200 : 404);
		$this->setResponseMessage($res ? "Deleted" : "Not found");
	}

}
