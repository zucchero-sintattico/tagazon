<?php

require_once __DIR__ . "/require.php";


class Response {

	private $code;
	private $message;
	private $data;

	public function __construct($code=200, $message=null, $data=[]) {
		$this->code = $code;
		$this->message = $message;
		$this->data = $data;
	}
	
	public function setCode($code) {
		$this->code = $code;
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	public function setData($data, $json = false){
		$this->data = $json ? json_encode($data) : $data;
	}

	public function getCode() {
		return $this->code;
	}

	public function getMessage() {
		return $this->message;
	}

	public function getData() {
		return $this->data;
	}

	public function send() {
		header("Content-Type: application/json");
        http_response_code($this->code);
		echo json_encode([
            "code" => $this->code,
            "message" => $this->message,
            "data" => $this->data
        ]);
	}


	/*
	Default responses
	*/


	public static function methodNotAllowed() {
		return new Response(405, "Method Not Allowed");
	}

	public static function unauthorized($message="Unauthorized") {
		return new Response(401, $message);
	}

	public static function forbidden($message="Forbidden"){
		return new Response(403, $message);
	}

	public static function notFound($message="Not Found"){
		return new Response(404, $message);
	}

	public static function badRequest($message="Bad Request"){
		return new Response(400, $message);
	}

	public static function ok($data=[], $message="OK"){
		return new Response(200, $message, $data);
	}

    public static function updated($data=[], $message="Updated"){
        return new Response(200, $message, $data);
    }

    public static function created($data, $message="Created"){
        return new Response(201, $message, $data);
    }

    public static function deleted($message="Deleted"){
        return new Response(200, $message);
    }

}


?>