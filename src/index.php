<?php

class Pages {

    const userNotLoggedDefaultPage = "splash";
    const defaultPage = "home";
    const errorPage = "error";

    const pages = [

        /**
         * Pages without authentication
         */
        'splash' => false,
        'login' => false,
        'register' => false,
        'error' => false,
        'restore-password' => false,
        'restore-password-success' => false,
        
        /**
         * Pages with authentication
         */
        'home' => true,
        'info_tag' => true,
        'cart' => true,
    ];

    static function get($page) {
        $page = strtolower($page);
        if ($page == self::errorPage) {
            self::renderPage($page);
            die();
        }
        if (!in_array($page, array_keys(self::pages))) {
            header("Location: ./?page=" . self::errorPage);
            die();
        }        
        if (self::isAuthRequiredForPage($page) && !self::isUserLoggedIn()) {
            header("Location: ./?page=" . self::userNotLoggedDefaultPage);
            die();
        } else if (!self::isAuthRequiredForPage($page) && self::isUserLoggedIn()) {
            header("Location: ./?page=" . self::defaultPage);
            die();
        }
        self::renderPage($page);
    }

    static function isAuthRequiredForPage($page) {
        return self::pages[$page];
    }

    static function isUserLoggedIn() {
        return isset($_SESSION["user"]);
    }

    /**
     * Renders the page
     * @param $page -- the page to render [REQUIRED BECAUSE IT HAS TO BE PASSED TO base.php]
     */
    static function renderPage($page) {
        require __DIR__ . "/pages/base.php";
    }

}

session_start();
if (!isset($_GET["page"])){
    Pages::get(Pages::userNotLoggedDefaultPage);
} else {
    Pages::get($_GET["page"]);
}


?>