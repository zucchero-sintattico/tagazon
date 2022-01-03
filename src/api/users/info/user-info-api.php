<?php

require_once __DIR__ . "/../../require.php";

class UserInfoApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->get(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }


    public function onGet($params){
        
        if (!isset($_SESSION["user"])){
            return Response::notFound("User not logged in");
        }

        $user = $_SESSION["user"];
        unset($user["password"]);

        return Response::ok($user, "User info");
    }
    
}

?>