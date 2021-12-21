<?php

class Pages {

    const pages = [
        'home', 'login', 'register', 'error'
    ];

    static function get($page) {
        $page = strtolower($page);
        if (!in_array($page, self::pages)) {
            $page = 'error';
        }
        require __DIR__ . "/pages/base.php";
    }

}

if (!isset($_GET["page"])){
    Pages::get("home");
} else {
    Pages::get($_GET["page"]);
}


?>