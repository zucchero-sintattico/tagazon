<?php

require_once __DIR__ . "/../../require.php";

class RegisterApi extends Api {

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


        $sellers = SellersApi::get(["email" => $email], true)->getData();
        $buyers = BuyersApi::get(["email" => $email], true)->getData();

        if(count($sellers) > 0 || count($buyers) > 0){
            return Response::badRequest("Email already exists");
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
            return Response::badRequest("Missing parameters");
        }

        $res = null;
        if ($type == "seller"){
            $res = SellersApi::post($user, true);
        } else {
            $res = BuyersApi::post($user, true);
        }
        
        if($res->getCode() == 201){
            return Response::ok($res->getData(), "User created");    
        } else {
            return Response::badRequest("Error creating user");
        }
        
    }
    
}


?>