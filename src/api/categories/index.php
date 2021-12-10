<?php

require_once "../api.php";
require_once "../../db/categories/category.php";

class CategoriesAPI extends API {

    protected function onGet(){
        if (isset($_GET['id'])) {
            echo json_encode(Category::find($_GET['id']));
        } else {
            echo json_encode(Category::all());
        }
    }

    protected function onPost(){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $res = Category::create($name, $description);
        echo $res;
    }

    protected function onPatch(){
        $_PATCH = $this->getPatchData();
        $id = $_GET['id'];
        $name = $_PATCH['name'];
        $description = $_PATCH['description'];
        Category::update($id, $name, $description);
    }

    protected function onDelete(){
        if (isset($_GET['id'])) {
            $res = Category::delete($_GET['id']);
            http_response_code($res ? 200 : 400);
            echo json_encode($res);
        }
    }

}

API::run(new CategoriesAPI());

?>