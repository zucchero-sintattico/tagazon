<?php

require_once __DIR__ . "/../../require.php";

class Database{

    public static function getInstance(){
        static $instance = null;
        if(null === $instance){
            $instance = new mysqli("localhost", "root", "", "my_tagazon", 3306);
        }
        return $instance;
    }

}


?>
