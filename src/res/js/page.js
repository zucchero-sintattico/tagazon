class Page {

    static fromName(page) {
        switch (page) {
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