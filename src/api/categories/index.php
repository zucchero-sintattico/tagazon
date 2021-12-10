<?php

require_once "../api.php";
require_once "../../db/categories/category.php";

class CategoriesAPI extends API {

    public function onGet(){
        if(isset($_GET['categoryId'])){
            $category = Category::find($_GET['id']);
        }else{
            $category = Category::all();
        }
        echo $category;
    }

    public function onPost(){

    }

}

API::run(new CategoriesAPI());

?>