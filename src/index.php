<?php

class Pages {

    const pages = [
        'home', 'login', 'register', 'error'
    ];

    static function get($page) {
        $page = strtolower($page);     
        require __DIR__ . "/pages/base.php";
    }

}

if (!isset($_GET["page"])){
    Pages::get("error");
}

Pages::get($_GET["page"]);

?>