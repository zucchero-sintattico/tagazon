<?php

class Category {
    
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
        $db = Database::getInstance();
        $query = "SELECT * FROM categories";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);  
    }

    public static function find($id){
        $db = Database::getInstance();
        $query = "SELECT * FROM categories WHERE id = $id";
        $result = $db->query($query);
        $row = $result->fetch_assoc();
        return $row;
    }

    public static function delete($id){
        $db = Database::getInstance();
        $query = "DELETE FROM categories WHERE id = $id";
        return $db->query($query);
    }

    public static function create($name, $description){
        $db = Database::getInstance();
        $query = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
        $db->query($query);
        return $db->insert_id;
    }

    public static function update($id, $name, $description){
        $db = Database::getInstance();
        $query = "UPDATE categories SET name = '$name', description = '$description' WHERE id = $id";
        return $db->query($query);
    }

}
?>