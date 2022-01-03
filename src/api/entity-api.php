<?php

require_once __DIR__ . "/require.php";
abstract class EntityApi extends Api
{

	protected $entity;

	public function __construct($entity, ApiAuth $auth = null){
		parent::__construct($auth);
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


	public function onGet($params, $server=false)
	{
		$res = $this->entity::find($params);

		// filters in order to get only the elements that the user has access to
		$results = $res;
		if ($this->getAuth()->getAuth() != ApiAuth::OPEN && !$server && !isPythonBot()) {
			$results = array_filter($res, function($element) {
				return $this->canAccess($element);
			});
		}

		return count($results) == 0 && count(array_keys($params)) > 0 ? Response::notFound() : Response::ok($results);

	}

	/**
	 * Create a new element.
	 */
	public function onPost($params, $server=false)
	{
		if ($this->getAuth()->postAuth() != ApiAuth::OPEN && !$server && !isPythonBot() && !$this->canCreate($params)) {
			return Response::forbidden();
		}

		$res = $this->entity::create($params);
		return $res ? Response::created($res) : Response::badRequest();
	}

	/**
	 * Update an element.
	 */
	public function onPut($params, $server=false)
	{
		if (!isset($params['id'])) {
			return Response::badRequest("Missing id");
		}

		$element = $this->entity::find(["id" => $params['id']])[0];

		if ($this->getAuth()->putAuth() != ApiAuth::OPEN && !$server && !$this->canModify($element) && !isPythonBot()) {
			return Response::forbidden();
		}

		$res = $this->entity::update($params);
		return $res ? Response::updated() : Response::badRequest();
	}

	/**
	 * Delete an element.
	 */
	public function onDelete($params, $server=false)
	{
		if (!isset($params['id'])) {
			return Response::badRequest("Missing id");
		}

		$element = $this->entity::find(["id" => $params['id']])[0];
		if ($this->getAuth()->deleteAuth() != ApiAuth::OPEN && !$server && !$this->canDelete($element) && !isPythonBot()) {
			return Response::forbidden();
		}

		$res = $this->entity::delete($params['id']);
		return $res ? Response::deleted() : Response::badRequest();
	}

}
