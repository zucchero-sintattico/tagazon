<?php

class Users {
    
    private $id;
    private $email;
    private $password;
    private $name;
    private $surname;

    public function __construct($id, $email, $password, $name, $surname) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
    }

    // Getters
    
    public function getId() {
        return $this->id;
    }
 
    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    // Setters

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }



    /**
     * ORM mapping
     */

    public static function all(){
        throw new NotImplementedException();
    }

    public static function find($id){
        throw new NotImplementedException();
    }

    public static function delete($id){
        throw new NotImplementedException();
    }

    public static function create($name, $description){
        throw new NotImplementedException();
    }

    public static function update($id, $name, $description){
        throw new NotImplementedException();
    }

}
?>