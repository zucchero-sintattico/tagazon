<?php

require "/tagazon/src/db/database.php";

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
        $db = Database::getInstance();
        $query = "SELECT * FROM tags";
        $result = $db->query($query);
        $tags = [];
        while($row = $result->fetch_assoc()){
            $tags[] = new Tag($row['id'], $row['name'], $row['description'], $row['categories']);
        }
        return $tags;
        
    }

    public static function find($id){
        $db = Database::getInstance();
        $query = "SELECT * FROM tags WHERE id = $id";
        $result = $db->query($query);
        $row = $result->fetch_assoc();
        return new Tag($row['id'], $row['name'], $row['description'], $row['categories']);
    }

    public static function delete($id){
        $db = Database::getInstance();
        $query = "DELETE FROM tags WHERE id = $id";
        $db->query($query);
    }

    public static function create($name, $description, $categories){
        $db = Database::getInstance();
        $query = "INSERT INTO tags (name, description, categories) VALUES ('$name', '$description', '$categories')";
        $db->query($query);
    }

    public static function update($id, $name, $description, $categories){
        $db = Database::getInstance();
        $query = "UPDATE tags SET name = '$name', description = '$description', categories = '$categories' WHERE id = $id";
        $db->query($query);
    }




}
?>