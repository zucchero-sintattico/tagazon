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

        $sellers = Entity::find(Seller::class, ["email" => $email]);
        $buyers = Entity::find(Buyer::class, ["email" => $email]);

        $user = null;
        $type = null;
        if (count($sellers) > 0) {
            $user = $sellers[0];
            $type = "seller";
        } else if (count($buyers) > 0) {
            $user = $buyers[0];
            $type = "buyer";
        } else {
            $this->setResponseCode(404);
            $this->setResponseMessage("User not found");
            return;
        }
        $user = (object) $user;

        if (password_verify($password, $user->password)) {
            $_SESSION["email"] = $user->email;
            $_SESSION["type"] = $type;
            if ($type == "buyer"){
                $_SESSION["name"] = $user->name;
                $_SESSION["surname"] = $user->surname;
            } else {
                $_SESSION["rag_soc"] = $user->rag_soc;
                $_SESSION["piva"] = $user->piva;
            }
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