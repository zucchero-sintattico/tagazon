class Application {

    static baseUrl = "/tagazon/src/api/objects/";

    static page = null;

    static user = null;
    static cart = null;
    static orders = null;
    static notifications = null;

    static authManager = new AuthManager();
    static notificationsService = new NotificationsService();

    static pageReady = false;
    static userReady = false;
    static cartReady = false;
    static ordersReady = false;
    static notificationsReady = false;

    static cartListen = false;
    static notificationsListen = false;

    static start(page) {
        Application.page = page;
        const properties = Object.getOwnPropertyNames(Object.getPrototypeOf(page));
        const methods = properties.filter(item => typeof page[item] === 'function')

        methods.forEach((method) => {
            switch (method) {
                case "onPageLoad":
                    Application.whenPageReady(() => Application.page.onPageLoad());
                    break;
                case "onUserLoad":
                    Application.whenUserReady(() => Application.page.onUserLoad(Application.user));
                    break;
                case "onCartChange":
                    Application.onCartChange(() => Application.page.onCartChange(Application.cart));
                    break;
                case "onNotificationsChange":
                    Application.onNotificationsChange(() => Application.page.onNotificationsChange(Application.notifications));
                    break;
            }
        });

    }

    static loadUser(onLoad = () => {}) {
        Application.userReady = false;
        Application.authManager.start(
            (user) => {
                Application.user = new User(user["id"], user["email"], user["type"], () => {
                    Application.userReady = true;
                    Application.notificationsService.start();
                    onLoad();
                });
            }
        );
    }

    static loadCart(onLoad = () => {}) {
        $.ajax({
            url: Application.baseUrl + "shoppingcart_tags/",
            type: "GET",
            success: (data) => {
                Application.cart = new Cart(data["data"], () => {
                    Application.cartReady = true;
                    onLoad();
                });
            },
            error: (data) => {
                console.error(data);
            }
        });
    }
    static loadOrders(onLoad = () => {}) {
        $.ajax({
            url: Application.baseUrl + "orders/",
            type: "GET",
            success: (data) => {
                Application.orders = data["data"].map((order) => new Order(order));
                Application.ordersReady = true;
                onLoad();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }
    static loadNotifications(onLoad = () => {}) {
        $.ajax({
            url: Application.baseUrl + "notifications/",
            type: "GET",
            success: (data) => {
                Application.notifications = data["data"].map((notification) => new NotificationObject(notification["id"], notification["order"], notification["timestamp"], notification["title"], notification["message"], notification["seen"]));
                Application.notificationsReady = true;
                onLoad();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }


    static async notifyCartChange() {
        Application.page.onCartChange();
    }

    static async notifyNotificationChange() {
        Application.page.onNotificationsChange();
    }

    static addNotification(notification, onSuccess = () => {}) {
        Application.notifications.push(notification);
        Application.notifyNotificationChange();
    }

    static _whenReady(type, callback) {

        let ready = type == "user" ? Application.userReady :
            type == "cart" ? Application.cartReady :
            type == "orders" ? Application.ordersReady :
            type == "notifications" ? Application.notificationsReady :
            type == "page" ? Application.pageReady : null;

        if (ready == null) {
            console.error("Invalid type");
            return;
        }

        if (ready) {
            callback();
        } else {
            setTimeout(() => {
                Application._whenReady(type, callback);
            }, 30);
        }

    }

    static onCartChange(callback) {
        Application.loadCart();
        return Application._whenReady("cart", callback);
    }
    static onNotificationsChange(callback) {
        Application.loadNotifications();
        return Application._whenReady("notifications", callback);
    }


    static whenOrdersReady(callback) {
        Application.loadOrders();
        return Application._whenReady("orders", callback);
    }
    static whenUserReady(callback) {
        Application.loadUser();
        return Application._whenReady("user", callback);
    }

    static whenPageReady(callback) {
        return Application._whenReady("page", callback);
    }

}

let page = new URLSearchParams(document.location.search).get("page");
Application.start(Page.fromName(page));

$(() => {
    Application.pageReady = true;
});