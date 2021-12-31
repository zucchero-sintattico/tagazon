class Application {

    static baseUrl = "/tagazon/src/api/objects/";

    static user = null;
    static cart = null;
    static orders = null;
    static notifications = null;

    static authManager = new AuthManager();
    static notificationsService = new NotificationsService();

    static userReady = false;
    static cartReady = false;
    static ordersReady = false;
    static notificationsReady = false;

    static cartListeners = [];
    static notificationListeners = [];

    static start() {
        Application.refreshUser(() => {
            Application.notificationsService.start();
        });
    }

    static refreshUser(onRefresh = () => {}) {
        Application.userReady = false;
        Application.authManager.start(
            (user) => {
                Application.user = new User(user["id"], user["email"], user["type"], () => {
                    Application.userReady = true;
                    onRefresh();
                });
            }
        );
    }


    static refreshCart(onRefresh = () => {}) {
        $.ajax({
            url: Application.baseUrl + "shoppingcart_tags/",
            type: "GET",
            success: (data) => {
                Application.cart = new Cart(data["data"], () => {
                    Application.cartReady = true;
                    onRefresh();
                });
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    static refreshOrders(onRefresh = () => {}) {
        $.ajax({
            url: Application.baseUrl + "orders/",
            type: "GET",
            success: (data) => {
                Application.orders = data["data"].map((order) => new Order(order));
                Application.ordersReady = true;
                onRefresh();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    static refreshNotifications(onRefresh = () => {}) {
        $.ajax({
            url: Application.baseUrl + "notifications/",
            type: "GET",
            success: (data) => {
                Application.notifications = data["data"].map((notification) => new NotificationObject(notification["id"], notification["order"], notification["timestamp"], notification["title"], notification["message"], notification["seen"]));
                Application.notificationsReady = true;
                onRefresh();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }



    static async notifyCartChange() {
        Application.cartListeners.forEach((listener) => listener());
    }

    static onCartChange(callback) {
        Application.cartListeners.push(callback);
        Application.whenCartReady(() => callback());
    }

    static async notifyNotificationChange() {
        Application.notificationListeners.forEach((listener) => listener());
    }

    static onNotificationChange(callback) {
        Application.notificationListeners.push(callback);
        Application.whenNotificationsReady(() => callback());
    }

    static addNotification(notification, onSuccess = () => {}) {
        Application.notifications.push(notification);
        Application.notifyNotificationChange();
    }

    // WHEN READY FUNCTIONS

    static _whenReady(type, callback) {

        let ready = type == "user" ? Application.userReady :
            type == "cart" ? Application.cartReady :
            type == "orders" ? Application.ordersReady :
            type == "notifications" ? Application.notificationsReady : null;

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

    static whenCartReady(callback) {
        Application.refreshCart();
        return Application._whenReady("cart", callback);
    }

    static whenOrdersReady(callback) {
        Application.refreshOrders();
        return Application._whenReady("orders", callback);
    }

    static whenNotificationsReady(callback) {
        Application.refreshNotifications();
        return Application._whenReady("notifications", callback);
    }

    static whenUserReady(callback) {
        return Application._whenReady("user", callback);
    }

}

Application.start();