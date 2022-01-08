<?php

require_once __DIR__ . "/../../require.php";

class ChangePasswordApi extends Api {

    public function __construct()
    {
        $auth = ApiAuth::builder()
            ->post(ApiAuth::OPEN)
            ->build();
        parent::__construct($auth);
    }

    // implement methods
    public function onPost($params){

        $oldPassword = $params['oldPassword'];
        $newPassword = $params['newPassword'];

        if ($_SESSION['user']["type"] == "buyer") {
            $user = BuyersApi::get(["id" => $_SESSION['user']["id"]], true)->getData()[0];
        } else {
            $user = SellersApi::get(["id" => $_SESSION['user']["id"]], true)->getData()[0];
        }

        if (password_verify($oldPassword, $user["password"])) {
            $user["password"] = password_hash($newPassword, PASSWORD_DEFAULT);

            if ($_SESSION['user']["type"] == "buyer") {
                $res = BuyersApi::put($user, true);
            } else {
                $res = SellersApi::put($user, true);
            }

            if ($res->getCode() == 200) {
                return Response::updated("Password updated successfully");
            } else {
                return Response::badRequest("Error updating password");
            }

        } else {
            return Response::badRequest("Wrong password");
        }

    }
    
}

?>