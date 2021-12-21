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

        $sellers = SellersApi::get(["email" => $email], true)["data"];
        $buyers = BuyersApi::get(["email" => $email], true)["data"];

        $password = generateRandomString(8);
        if (count($sellers) > 0) {
            $seller = (array)$sellers[0];
            $seller["password"] = password_hash($password, PASSWORD_DEFAULT);
            $res = SellersApi::patch($seller);
            sendMail($seller["email"], "Password reset", "Your new password is: " . $password);
        } else if (count($buyers) > 0) {
            $buyer = (array)$buyers[0];
            $buyer["password"] = password_hash($password, PASSWORD_DEFAULT);
            $res = BuyersApi::patch($buyer);
            sendMail($buyer["email"], "Password reset", "Your new password is: " . $password);
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