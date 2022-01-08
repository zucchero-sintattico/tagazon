<?php

class Page {

    public $name;
    public $authRequired;
    public $navbar;
    public $seller;

    public function __construct($name, $authRequired, $navbar, $seller=false) {
        $this->name = $name;
        $this->authRequired = $authRequired;
        $this->navbar = $navbar;
        $this->seller = $seller;
    }

    public function getName(){
        return $this->name;
    }

    public function getFormatName() {
        return str_replace('-', '', ucwords($this->name, '-'));
    }

    public function isAuthRequired() {
        return $this->authRequired;
    }

    public function isNavbarPresent() {
        return $this->navbar;
    }

    public function isSeller() {
        return $this->seller;
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
        'payment' => ['payment', true, false],
        'order-completed' => ['order-completed', true, false],
        'order-list' => ['order-list', true, true],


        /**
         * Admin pages
         */
        'seller-home' => ['seller-home', false, false, true],
        'seller-profile' => ['seller-profile', false, false, true],
        'seller-add-product' => ['seller-add-product', false, false, true],
        'seller-notifications' => ['seller-notifications', false, false, true],
    );

    const userNotLoggedDefaultPage = "splash";
    const defaultBuyerPage = "home";
    const defaultSellerPage = "seller-home";
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

        if (self::isSellerPage($page)) {
            if (self::isSeller()) {
                return self::renderPage($page);
            } else if (self::isBuyer()) {
                header("Location: ./?page=" . self::defaultBuyerPage);
                die();
            } else {
                header("Location: ./?page=" . self::userNotLoggedDefaultPage);
                die();
            }
        }

        if (self::isAuthRequiredForPage($page)) {
            if (self::isBuyer()) {
                return self::renderPage($page);
            } else if (self::isSeller()){
                header("Location: ./?page=" . self::defaultSellerPage);
                die();
            } else {
                header("Location: ./?page=" . self::userNotLoggedDefaultPage);
                die();
            }
        } else {
            if (self::isSeller()) {
                header("Location: ./?page=" . self::defaultSellerPage);
                die();
            } else if (self::isBuyer()) {
                header("Location: ./?page=" . self::defaultBuyerPage);
                die();
            } else {
                return self::renderPage($page);
            }
        }
        
    }

    static function isAuthRequiredForPage($page) {
        return self::pages[$page][1];
    }

    static function isSellerPage($page) {
        return (new Page(...self::pages[$page]))->isSeller();
    }

    static function isBuyer() {
        return isset($_SESSION["user"]) && $_SESSION["user"]["type"] == "buyer";
    }

    static function isSeller() {
        return isset($_SESSION["user"]) && $_SESSION["user"]["type"] == "seller";;
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