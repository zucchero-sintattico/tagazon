<?php

class Page {

    public $name;
    public $authRequired;
    public $navbar;

    public function __construct($name, $authRequired, $navbar) {
        $this->name = $name;
        $this->authRequired = $authRequired;
        $this->navbar = $navbar;
    }

    public function getName(){
        return $this->name;
    }

    public function getFormatName() {
        return str_replace('_', '', ucwords($this->name, '_'));
    }

    public function isAuthRequired() {
        return $this->authRequired;
    }

    public function isNavbarPresent() {
        return $this->navbar;
    }

    public function getHtml() {
        return "./pages/$this->name/$this->name.html";
    }

    public function getCss() {
        return "./pages/$this->name/$this->name.css";
    }

    public function getJs() {
        return "./pages/$this->name/$this->name.js";
    }

}

class Pages {
    
    const pages = array(

        /**
         * Pages without authentication
         */
        'splash' => ['splash', false, false],
        'login' => ['login', false, false],
        'register' => ['register', false, false],
        'error' => ['error', false, false],
        'restore-password' => ['restore-password', false, false],
        'restore-password-success' => ['restore-password-success', false, false],
        
        /**
         * Pages with authentication
         */
        'home' => ['home', true, true],
        'info-tag' => ['info-tag', true, true],
        'cart' => ['cart', true, true],
        'notifications' => ['notifications', true, true],
        'profile' => ['profile', true, true],
    );

    const userNotLoggedDefaultPage = "splash";
    const defaultPage = "home";
    const errorPage = "error";

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
        return self::pages[$page][1];
    }

    static function isUserLoggedIn() {
        return isset($_SESSION["user"]);
    }

    /**
     * Renders the page
     * @param $page -- the page to render [REQUIRED BECAUSE IT HAS TO BE PASSED TO base.php]
     */
    static function renderPage($page) {
        $page = new Page(...self::pages[$page]);
        require __DIR__ . "/pages/base.php";
    }

}

session_start();
if (!isset($_GET["page"])){
    header("Location: ./?page=" . Pages::userNotLoggedDefaultPage);
} else {
    Pages::get($_GET["page"]);
}


?>