<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";


class ResetPasswordApi extends Api {

    // implement methods
    protected function onPost(){

        $email = $_POST["email"];

        $sellers = json_decode(doGet("http://localhost/tagazon/src/api/sellers/?email=$email"));
        $buyers = json_decode(doGet("http://localhost/tagazon/src/api/buyers/?email=$email"));

        if (count($sellers) > 0) {
            $seller = $sellers[0];
            $password = generateRandomString(8);
            $seller->password = password_hash($password, PASSWORD_DEFAULT);
            doPatch("http://localhost/tagazon/src/api/sellers/?id=" . $seller->id, $seller);
            mail($seller->email, "Password reset", "Your new password is: " . $seller->password);
            http_response_code(200);
            return true;
        } else if (count($buyers) > 0) {
            $buyer = $buyers[0];
            $password = generateRandomString(8);
            $buyer->password = password_hash($password, PASSWORD_DEFAULT);
            $res = json_decode(doPatch("http://localhost/tagazon/src/api/buyers/?id=" . $buyer->id, $buyer));
            //mail($buyer->email, "Password reset", "Your new password is: " . $buyer->password);
            http_response_code(200);
            return $res;
        } else {
            http_response_code(404);
            return "No user found with that email";
        }

        
    }
    
}

Api::run(new ResetPasswordApi());

?>