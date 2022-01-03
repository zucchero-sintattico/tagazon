<?php

require_once __DIR__ . "/../../require.php";

class LogoutApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->post(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }

    // implement methods
    public function onPost($params){
        if (isset($_SESSION["user"])){
            unset($_SESSION["user"]);
            return Response::ok([], "User logged out");
        } else {
            return Response::badRequest("User not logged in");
        }
    }
    
}


?>