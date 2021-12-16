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
        $sellers = Seller::find(['email' => $email]);
        $buyers = Buyer::find(['email' => $email]);

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

        $res = null;
        if ($type == "seller"){
            $res = Seller::create($user);
        } else {
            $res = Buyer::create($user);
        }
        if($res > 0){
            $res2 = ShoppingCart::create([
                "buyer" => $res
            ]);
            if($res2 > 0){            
                $this->setResponseCode(200);
                $this->setResponseMessage("User created");
                $this->setResponseData([
                    "id" => $res
                ]);
            } else {
                $this->setResponseCode(400);
                $this->setResponseMessage("Error creating shopping cart");
            }
        } else {
            $this->setResponseCode(400);
            $this->setResponseMessage("Error creating user");
        }
        
    }
    
}


Api::run(new RegisterApi());

?>