<?php

require_once __DIR__ . "/require.php";
abstract class EntityApi extends Api
{

	protected $entity;

	public function __construct($entity, $getAuth=Api::OPEN, $postAuth=Api::SERVER, $patchAuth=Api::SERVER, $deleteAuth=Api::SERVER){
		parent::__construct($getAuth, $postAuth, $patchAuth, $deleteAuth);
		$this->entity = $entity;
	}

	protected function canAccess($element){
		return false;
	}
	protected function canCreate($request){
		return false;
	}
	protected function canModify($element){
		return false;
	}
	protected function canDelete($element){
		return false;
	}


	/**
	 * Get the elements.
	 * Possible find on specified id.
	 */
	public function onGet($params, $server=false)
	{
		$res = $this->entity::find($params);

		// filters in order to get only the elements that the user has access to
		$results = [];
		if ($this->getAuth != Api::OPEN && !$server && !$this->isPythonBot()) {
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
		if ($this->postAuth != Api::OPEN && !$this->canCreate($params) && !$this->isPythonBot()) {
			$this->setResponseCode(403);
			$this->setResponseMessage("Forbidden");
			return;
		}
		$res = $this->entity::create($params);
		$this->setResponseCode(!is_null($res) ? 201 : 400);
		$this->setResponseMessage(!is_null($res) ? "Created" : "Bad request");
		$this->setResponseData(!is_null($res) ? $res : []);
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

		$element = $this->entity::find(["id" => $params['id']])[0];

		if ($this->patchAuth != Api::OPEN && !$server && !$this->canModify($element) && !$this->isPythonBot()) {
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

		$element = $this->entity::find(["id" => $params['id']]);
		if ($this->deleteAuth != Api::OPEN && !$server && !$this->canDelete($element) && !$this->isPythonBot()) {
			$this->setResponseCode(403);
			$this->setResponseMessage("Forbidden");
			return;
		}
		$res = $this->entity::delete($params['id']);
		$this->setResponseCode($res ? 200 : 404);
		$this->setResponseMessage($res ? "Deleted" : "Not found");
	}

}
