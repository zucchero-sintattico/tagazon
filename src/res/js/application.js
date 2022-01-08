import { AuthManager } from './auth-manager.js';
import { NotificationsService } from './notifications-service.js';
import { Buyer, Seller } from './objects/user.js';
import { Cart } from './objects/cart.js';
import { NotificationObject } from './objects/notification.js';
import { Order } from './objects/order.js';


export class Application {

    static baseUrl = "/tagazon/src/api/objects/";

    static page = null;

    static user = null;
    static cart = null;
    static orders = [];
    static notifications = [];

    static authManager = new AuthManager();
    static notificationsService = new NotificationsService();

    static startedUserLoading = false;

    static pageReady = false;
    static userReady = false;
    static cartReady = false;
    static ordersReady = false;
    static notificationsReady = false;

    static cartListen = false;
    static notificationsListen = false;

    static start(page) {

        Application.page = page;
        let methods = new Set()
        let currentObj = Object.getPrototypeOf(page)
        do {
            console.log();
            Object.getOwnPropertyNames(currentObj)
                .map(item => methods.add(item))
        }
        while ((currentObj = Object.getPrototypeOf(currentObj)) && currentObj.constructor.name !== "Page");

        methods.forEach((method) => {
            switch (method) {
                case "onUserLoad":
                    Application.whenUserReady(() => Application.page.onUserLoad());
                    break;
                case "onPageLoad":
                    Application.whenPageReady(() => Application.page.onPageLoad());
                    break;
                case "onCartChange":
                    Application.onCartChange(() => Application.page.onCartChange());
                    break;
                case "onNotificationsChange":
                    Application.onNotificationsChange(() => Application.page.onNotificationsChange());
                    break;
                case "onOrdersReady":
                    Application.whenOrdersReady(() => Application.page.onOrdersReady());
                    break;
            }
        });


    }

    static loadUser() {
        Application.userReady = false;
        Application.authManager.start(
            (user) => {
                if (user.type == "buyer") {
                    Application.user = new Buyer(user.id, user.email, user.name, user.surname);
                } else if (user.type == "seller") {
                    Application.user = new Seller(user.id, user.email, user.rag_soc, user.piva, user.balance);
                }

                Application.userReady = true;
                Application.notificationsService.start(user.id, (notification) => {
                    Application.addNotification(notification);
                }, () => {
                    Application.notifyNotificationChange();
                });
            }
        );
    }

    static loadCart() {
        if (!Application.userReady) {
            setTimeout(() => Application.loadCart(), 100);
            return;
        }
        $.ajax({
            url: Application.baseUrl + "shoppingcart_tags/",
            type: "GET",
            success: (data) => {
                Application.cart = new Cart(data.data, () => {
                    Application.cartReady = true;
                }, () => {
                    Application.notifyCartChange();
                });
            },
            error: (data) => {
                console.error(data);
            }
        });
    }
    static loadOrders() {
        if (!Application.userReady) {
            setTimeout(() => Application.loadOrders(), 100);
            return;
        }
        $.ajax({
            url: Application.baseUrl + "orders/",
            type: "GET",
            success: (response) => {
                Application.orders = response.data;
                Application.ordersReady = true;
                /*
                Application._buildOrders(response.data, 0, () => {
                    Application.ordersReady = true;
                });
                */
            },
            error: (data) => {
                console.error(data);
            }
        });
    }
    static _buildOrders(orders, index = 0, onReady) {
        if (index < orders.length) {
            const order = orders[index];
            const orderItem = new Order(order, () => {
                Application.orders.push(orderItem);
                Application._buildOrders(orders, index + 1, onReady);
            });
        } else {
            onReady();
        }
    }
    static loadNotifications() {
        if (!Application.userReady) {
            setTimeout(() => Application.loadNotifications(), 100);
            return;
        }
        $.ajax({
            url: Application.baseUrl + "notifications/",
            type: "GET",
            success: (data) => {
                Application.notifications = data.data.map((notification) => new NotificationObject(notification.id, notification.order, notification.timestamp, notification.title, notification.message, notification.seen, () => {
                    Application.notifyNotificationChange();
                }));
                Application.notificationsReady = true;
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
        Application.whenUserReady(() => {
            Application.loadCart();
            Application._whenReady("cart", callback);
        });
    }
    static onNotificationsChange(callback) {
        Application.loadNotifications();
        return Application._whenReady("notifications", callback);
    }




    static whenOrdersReady(callback) {
        Application.whenUserReady(() => {
            Application.loadOrders();
            Application._whenReady("orders", callback);
        });
    }

    static whenUserReady(callback) {
        if (!Application.startedUserLoading) {
            Application.startedUserLoading = true;
            Application.loadUser();
        }
        return Application._whenReady("user", callback);
    }

    static whenPageReady(callback) {
        Application._whenReady("page", callback);
    }

}

$(() => {
    Application.pageReady = true;
});