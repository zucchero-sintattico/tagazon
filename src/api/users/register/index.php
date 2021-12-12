<?php

require_once "../../api.php";
require_once "../../utils.php";
require_once "../../../db/tables.php";


class RegisterApi extends Api {

    // implement methods
    protected function onPost(){

        $email = $_POST["email"];
        $password = $_POST["password"];
        $sellers = json_decode(doGet("http://localhost/tagazon/src/api/sellers/?email=$email"));
        $buyers = json_decode(doGet("http://localhost/tagazon/src/api/buyers/?email=$email"));

        if(count($sellers) > 0 || count($buyers) > 0){
            http_response_code(400);
            return "Email already exists";
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        
        if (isset($_POST["piva"])){
            $rag_soc = $_POST["rag_soc"];
            $piva = $_POST["piva"];
            $res = doPost("http://localhost/tagazon/src/api/sellers/", array("email" => $email, "password" => $password, "rag_soc" => $rag_soc, "piva" => $piva));
            http_response_code($res > 0 ? 201 : 400);
            return $res > 0;
        } else {
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $res = doPost("http://localhost/tagazon/src/api/buyers/", array("email" => $email, "password" => $password, "name" => $name, "surname" => $surname));
            http_response_code($res > 0 ? 201 : 400);
            return $res > 0;
        }
        
    }
    
}


Api::run(new RegisterApi());

?>