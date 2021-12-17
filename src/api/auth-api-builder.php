<?php

require_once(__DIR__ . "/auth-api.php");

class AuthApiBuilder{

    protected $class;
    protected $getAuth = AuthApi::DENIED;
    protected $postAuth = AuthApi::DENIED;
    protected $patchAuth = AuthApi::DENIED;
    protected $deleteAuth = AuthApi::DENIED;

    public function __construct($class){
        $this->class = $class;
    }

    public function get($auth){
        $this->getAuth = $auth;
        return $this;
    }

    public function post($auth){
        $this->postAuth = $auth;
        return $this;
    }

    public function patch($auth){
        $this->patchAuth = $auth;
        return $this;
    }

    public function delete($auth){
        $this->deleteAuth = $auth;
        return $this;
    }

    public function build(){
        return new $this->class($this->getAuth, $this->postAuth, $this->patchAuth, $this->deleteAuth);
    }

}

?>