<?php

class Category implements Entity{
    
    private $id;
    private $name;
    private $description;

    public function __construct($id, $name, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
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