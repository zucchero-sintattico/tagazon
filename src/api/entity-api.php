<?php

require_once __DIR__ . "/require.php";
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
	public function onGet($params, $server=false)
	{
		$params = $this->filterParams($params);
		$res = $this->entity::find($params);

		// filters in order to get only the elements that the user has access to
		$results = [];
		if ($this->getAuth != Api::OPEN && !$server) {
			foreach ($res as $elem) {
				if ($this->canAccess($elem)) {
					$results[] = $elem;
				}
			}
		} else {
			$results = $res;
		}		

		$this->setResponseCode(count($results) == 0 && count(array_keys($params)) > 0 ? 404 : 200);
		$this->setResponseMessage(count($results) == 0 && count(array_keys($params)) > 0 ? "Not found" : "OK");
		$this->setResponseData($results);
	}

	/**
	 * Create a new element.
	 */
	public function onPost($params, $server=false)
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
	public function onPatch($params, $server=false)
	{
		if (!isset($params['id'])) {
			$this->setResponseCode(400);
			$this->setResponseMessage("Missing id");
			return;
		}

		$params = $this->filterParams($params);
		$element = $this->entity::find(["id" => $params['id']])[0];

		if ($this->patchAuth != Api::OPEN && !$server && !$this->canModify($element)) {
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
	public function onDelete($params, $server=false)
	{
		if (!isset($params['id'])) {
			$this->setResponseCode(400);
			$this->setResponseMessage("Missing id");
			return;
		}

		$params = $this->filterParams($params);
		$element = $this->entity::find(["id" => $params['id']]);
		if ($this->deleteAuth != Api::OPEN && !$server && !$this->canDelete($element) ) {
			$this->setResponseCode(403);
			$this->setResponseMessage("Forbidden");
			return;
		}
		$res = $this->entity::delete($params['id']);
		$this->setResponseCode($res ? 200 : 404);
		$this->setResponseMessage($res ? "Deleted" : "Not found");
	}

}
