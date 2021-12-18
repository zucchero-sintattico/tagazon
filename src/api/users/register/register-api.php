<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/../../utils.php";
require_once __DIR__."/../../../db/tables.php";
require_once __DIR__."/../../../db/entity.php";
require_once __DIR__."/../../sellers/sellers-api.php";
require_once __DIR__."/../../buyers/buyers-api.php";
require_once __DIR__."/../../shopping-carts/shopping-carts-api.php";

class RegisterApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::DENIED, Api::OPEN, Api::DENIED, Api::DENIED);
    }

    // implement methods
    public function onPost($params){

        $email = $params["email"];
        $password = $params["password"];


        $sellers = SellersApi::get(["email" => $email])["data"];
        $buyers = BuyersApi::get(["email" => $email])["data"];

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
            $res = SellersApi::post($user);
        } else {
            $res = BuyersApi::post($user);
        }
        if($res["code"] == 201){
            
            $res2 = ShoppingCartsApi::post(['user' => $res["data"]["id"]]);

            if($res2["code"] == 201){            
                $this->setResponseCode(200);
                $this->setResponseMessage("User created");
                $this->setResponseData($res["data"]);
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


?>