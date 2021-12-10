<?php

require_once "../api.php";
require_once "../../db/categories/category.php";

class CategoriesAPI extends API {

    protected function onGet(){
        if (isset($_GET['id'])) {
            echo json_encode(Entity::find(Category::class, $_GET['id']));
        } else {
            echo json_encode(Entity::all(Category::class));
        }
    }

    protected function onPost(){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $res = Entity::create(Category::class, null, $name, $description);
        echo $res;
    }

    protected function onPatch(){
        $_PATCH = $this->getPatchData();
        $id = $_GET['id'];
        $name = $_PATCH['name'];
        $description = $_PATCH['description'];
        Entity::update(Category::class, $id, $name, $description);
    }

    protected function onDelete(){
        if (isset($_GET['id'])) {
            $res = Entity::delete(Category::class, $_GET['id']);
            http_response_code($res ? 200 : 400);
            echo json_encode($res);
        }
    }

}

API::run(new CategoriesAPI());

?>