class Page {

    static fromName(page) {
        switch (page) {
            case "error":
                return new ErrorPage();
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
        }
    }

    onPageLoad() {

    }

    onUserLoad(user) {

    }

    onCartChange(cart) {

    }

    onNotificationsChange(notifications) {

    }

}