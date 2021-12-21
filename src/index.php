<?php

class Pages {

    const pages = [
        'home', 'login', 'register'
    ];

    static function get($page) {
        $page = strtolower($page);
        if (!in_array($page, self::pages)) {
            echo "404 - Not Found";
            return;
        }        
        require __DIR__ . "/pages/base.php";
    }

}

if (!isset($_GET["page"])){
    Pages::get("home");
}

Pages::get($_GET["page"]);

?>