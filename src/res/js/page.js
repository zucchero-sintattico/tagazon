class Page {

    static fromName(page) {
        switch (page) {
            case "splash":
                return new SplashPage();
            case "login":
                return new LoginPage();
            case "register":
                return new RegisterPage();
            case "restore-password":
                return new RestorePasswordPage();
            case "restore-password-success":
                return new RestorePasswordSuccessPage();
            case "home":
                return new HomePage();
            case "cart":
                return new CartPage();

            default:
                return new ErrorPage();
        }
    }

    onPageLoad() {

    }

    onUserLoad() {

    }

    onCartChange() {

    }

    onNotificationsChange() {

    }

}