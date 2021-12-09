<?php

class Tag {
    
    private $id;
    private $name;
    private $description;
    private $categories;

    public function __construct($id, $name, $description, $categories) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->categories = $categories;
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

    public function getCategories() {
        return $this->categories;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCategories($categories) {
        $this->categories = $categories;
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

    public static function create($name, $description, $categories){
        throw new NotImplementedException();
    }

    public static function update($id, $name, $description, $categories){
        throw new NotImplementedException();
    }




}
?>