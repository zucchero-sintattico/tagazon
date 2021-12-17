<?php

require_once(__DIR__ . "/auth-api-builder.php");

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

?>
