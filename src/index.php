<?php

class Pages {

    const pages = [
        'splash', 'login', 'register', 'error', 'home'
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
    Pages::get("splash");
} else {
    Pages::get($_GET["page"]);
}


?>