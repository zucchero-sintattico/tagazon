<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";
require_once "../../../db/entity.php";

class LoginApi extends Api {


    // implement methods
    public function onPost($params){

        $email = $params["email"];
        $password = $params["password"];

        if (!$email || !$password) {
            $this->setResponseCode(400);
            $this->setResponseMessage("Email and password are required");
            return;
        }

        $sellers = Seller::find(["email" => $email]);
        $buyers = Buyer::find(["email" => $email]);

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


Api::run(new LoginApi());

?>