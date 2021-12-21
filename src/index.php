<?php

class Pages {

    const pages = [
        'home', 'login', 'register'
    ];

    static function get($page) {
        $page = strtolower($page);
        if (!in_array($page, self::pages)) {
            http_response_code(404);
            $page = "error";
        }        
        require __DIR__ . "/pages/base.php";
    }

}

if (!isset($_GET["page"])){
    Pages::get("home");
}

Pages::get($_GET["page"]);

?>