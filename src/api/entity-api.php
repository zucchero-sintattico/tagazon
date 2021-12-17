<?php

require_once(__DIR__ . "/../db/entity.php");
require_once(__DIR__ . "/auth-api.php");
require_once(__DIR__ . "/utils.php");

class EntityApiBuilder extends AuthApiBuilder {

	private $entity;

    public function __construct($class, $entity){
        parent::__construct($class);
		$this->entity = $entity;
    }

    public function build(){
        return new $this->class($this->entity, $this->getAuth, $this->postAuth, $this->patchAuth, $this->deleteAuth);
    }
}

class EntityApi extends AuthApi
{

	private $entity;

	public function __construct($entity, $getAuth, $postAuth, $patchAuth, $deleteAuth){
		parent::__construct($getAuth, $postAuth, $patchAuth, $deleteAuth);
		$this->entity = $entity;
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

	public function filterOnAuthentication($jsonElements){
        return $jsonElements;
    }


	/**
	 * Get the elements.
	 * Possible find on specified id.
	 */
	public function onGet($params)
	{
		$params = $this->filterParams($params);
		$res = $this->entity::find($params);
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

		$params = $this->filterParams($params);
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
		$res = $this->entity::delete($params['id']);
		$this->setResponseCode($res ? 200 : 404);
		$this->setResponseMessage($res ? "Deleted" : "Not found");
	}

	public static function builder($class=null){
		return new EntityApiBuilder(static::class, $class);
	}


}
