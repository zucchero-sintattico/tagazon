<?php

require_once __DIR__ . "/../../require.php";

class LoginApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::DENIED, Api::OPEN, Api::DENIED, Api::DENIED);
    }


    // implement methods
    public function onPost($params){

        $email = $params["email"];
        $password = $params["password"];

        if (!$email || !$password) {
            $this->setResponseCode(400);
            $this->setResponseMessage("Email and password are required");
            return;
        }

        $sellers = SellersApi::get(["email" => $email], true)["data"];
        $buyers = BuyersApi::get(["email" => $email], true)["data"];

        $user = null;
        if (count($sellers) > 0) {
            $user = (array) $sellers[0];
            $user["type"] = "seller";
        } else if (count($buyers) > 0) {
            $user = (array) $buyers[0];
            $user["type"] = "buyer";
        } else {
            $this->setResponseCode(404);
            $this->setResponseMessage("User not found");
            return;
        }

        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user;
            $this->setResponseCode(200);
            $this->setResponseMessage("Login successful");
        } else {
            $this->setResponseCode(401);
            $this->setResponseMessage("Wrong password");
        }
        
    }
    
}

?>