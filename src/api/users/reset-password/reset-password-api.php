<?php

require_once __DIR__."/../../api.php";
require_once __DIR__."/../../utils.php";
require_once __DIR__."/../../../db/tables.php";
require_once __DIR__."/../../buyers/buyers-api.php";
require_once __DIR__."/../../sellers/sellers-api.php";

class ResetPasswordApi extends Api {

    public function __construct()
    {
        parent::__construct(Api::DENIED, Api::OPEN, Api::DENIED, Api::DENIED);
    }

    // implement methods
    public function onPost($params){

        $email = $params["email"];

        $sellers = SellersApi::get(["email" => $email])["data"];
        $buyers = BuyersApi::get(["email" => $email])["data"];

        if (count($sellers) > 0) {
            $seller = $sellers[0];
            $password = generateRandomString(8);
            $seller->password = password_hash($password, PASSWORD_DEFAULT);
            $res = SellersApi::patch($seller);
            mail($seller->email, "Password reset", "Your new password is: " . $seller->password);
        } else if (count($buyers) > 0) {
            $buyer = $buyers[0];
            $password = generateRandomString(8);
            $buyer->password = password_hash($password, PASSWORD_DEFAULT);
            $res = BuyersApi::patch($buyer);
            mail($buyer->email, "Password reset", "Your new password is: " . $buyer->password);
        } else {
            $this->setResponseCode(400);
            $this->setResponseMessage("User not found");
            return;
        }

        $this->setResponseCode(200);
        $this->setResponseMessage("Password Reset");

        
    }
    
}

?>