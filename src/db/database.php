<?php

class Database{

    public static function getInstance(){
        static $instance = null;
        if(null === $instance){
            $instance = new mysqli("localhost", "root", "", "tagazon", 3306);
        }
        return $instance;
    }

}


?>
