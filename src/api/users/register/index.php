<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";
require_once "../../../db/entity.php";

class RegisterApi extends Api {

    // implement methods
    public function onPost($params){

        $email = $params["email"];
        $password = $params["password"];
        $sellers = Entity::find(Seller::class, ['email' => $email]);
        $buyers = Entity::find(Buyer::class, ['email' => $email]);

        if(count($sellers) > 0 || count($buyers) > 0){
            $this->setResponseCode(400);
            $this->setResponseMessage("User already exists");
            return;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user = ['email' => $email, 'password' => $hashed_password];

        $type = null;
        if (isset($params["piva"])){
            $user["rag_soc"] = $params["rag_soc"];
            $user["piva"] = $params["piva"];
            $type = "seller";
        } else if (isset($params["name"])) {
            $user["name"] = $params["name"];
            $user["surname"] = $params["surname"];
            $type = "buyer";
        } else {
            $this->setResponseCode(400);
            $this->setResponseMessage("Invalid parameters");
            return;
        }

        $res = Entity::create($type == "seller" ? Seller::class : Buyer::class, $user);
        $this->setResponseCode($res > 0 ? 201 : 400);
        $this->setResponseMessage($res > 0 ? "User created" : "Error creating user");
        $this->setResponseData([
            "id" => $res
        ]);
    }
    
}


Api::run(new RegisterApi());

?>