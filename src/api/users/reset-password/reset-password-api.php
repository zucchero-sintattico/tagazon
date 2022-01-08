<?php

require_once __DIR__ . "/../../require.php";

class ResetPasswordApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->post(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }

    // implement methods
    public function onPost($params){

        $email = $params["email"];

        $sellers = SellersApi::get(["email" => $email], true)->getData();
        $buyers = BuyersApi::get(["email" => $email], true)->getData();

        $password = generateRandomString(8);
        if (count($sellers) > 0) {
            $seller = $sellers[0];
            $seller["password"] = password_hash($password, PASSWORD_DEFAULT);
            $res = SellersApi::put($seller);
            $resMail = sendMail($seller["email"], "Password reset", "Your new password is: " . $password);
        } else if (count($buyers) > 0) {
            $buyer = $buyers[0];
            $buyer["password"] = password_hash($password, PASSWORD_DEFAULT);
            $res = BuyersApi::put($buyer);
            $resMail = sendMail($buyer["email"], "Password reset", "Your new password is: " . $password . "\n");
        } else {
            return Response::notFound("User not found");
        }
        
        
        if ($res->getCode() == 200 && $resMail) {
            return Response::ok($res->getData(), "Password reset $resMail");
        } else {
            return Response::badRequest("Error resetting password");
        }
        
    }
    
}

?>