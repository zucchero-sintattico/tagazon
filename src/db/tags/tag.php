<?php


class Tag {

    const tableName = 'tags';
    const primary_keys = ['id' => 'i'];
    const fields = ['name' => 's', 'description' => 's'];

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

    public function toJson(){
        return json_encode($this);
    }

    public function fromJson($json){
        $data = json_decode($json);
        $this->id = $data->id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->categories = $data->categories;
    }

    /**
     * ORM mapping
     */

    public static function all(){
        $db = Database::getInstance();
        $query = "SELECT * FROM tags";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);   
    }

    public static function find($id){
        $db = Database::getInstance();
        $query = "SELECT * FROM tags WHERE id = $id";
        $result = $db->query($query);
        $row = $result->fetch_assoc();
        return $row;
    }

    public static function delete($id){
        $db = Database::getInstance();
        $query = "DELETE FROM tags WHERE id = $id";
        return $db->query($query);
    }

    public static function create($name, $description){
        $db = Database::getInstance();
        $query = "INSERT INTO tags (name, description) VALUES ('$name', '$description')";
        $db->query($query);
        return $db->insert_id;
    }

    public static function update($id, $name, $description){
        $db = Database::getInstance();
        $query = "UPDATE tags SET name = '$name', description = '$description' WHERE id = $id";
        return $db->query($query);
    }




}
?>