<?php

require_once __DIR__ . "/../../require.php";

class LoginApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->post(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }

    public function onPost($params){

        $email = $params["email"];
        $password = $params["password"];

        if (!$email || !$password) {
            return Response::badRequest("Missing email or password");
        }

        $sellers = SellersApi::get(["email" => $email], true)->getData();
        $buyers = BuyersApi::get(["email" => $email], true)->getData();

        $user = null;
        if (count($sellers) > 0) {
            $user = $sellers[0];
            $user["type"] = "seller";
        } else if (count($buyers) > 0) {
            $user = $buyers[0];
            $user["type"] = "buyer";
        } else {
            return Response::notFound("User not found");
        }

        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user;
            return Response::ok($user, "User logged in");
        } else {
            return Response::badRequest("Wrong password");
        }
        
    }
    
}

?>