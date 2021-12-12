<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";


class LoginApi extends Api {

    // implement methods
    protected function onPost(){

        $email = $_POST["email"];
        $password = $_POST["password"];

        $sellers = json_decode(doGet("http://localhost/tagazon/src/api/sellers/?email=$email"));
        $buyers = json_decode(doGet("http://localhost/tagazon/src/api/buyers/?email=$email"));

        echo "SELLERS = " . json_encode($sellers) . " ";
        echo "BUYERS = " . json_encode($buyers) . " ";

        $user = null;
        $type = null;
        if (count($sellers) > 0) {
            $user = $sellers[0];
            $type = "seller";
        } else if (count($buyers) > 0) {
            $user = $buyers[0];
            $type = "buyer";
        } else {
            http_response_code(404);
            return "No user found with email $email";
        }

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
            http_response_code(200);
            return true;
        } else {
            http_response_code(401);
            return "Wrong password";
        }
        
    }
    
}

Api::run(new LoginApi());

?>