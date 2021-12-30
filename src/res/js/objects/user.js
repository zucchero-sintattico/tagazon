class User {

    baseUrl = '/tagazon/src/api/objects/';

    constructor(id, email, type, onReady) {
        this.id = id;
        this.email = email;
        this.type = type;
        this.cart = null;
        this.orders = null;
        this.notifications = null;

        this.refreshCart(() => {
            this.refreshOrders(() => {
                this.refreshNotifications(() => {
                    onReady();
                });
            });
        });
    }

    refreshCart(onRefresh = () => {}) {
        let _this = this;
        $.ajax({
            url: this.baseUrl + "shoppingcart_tags/",
            type: "GET",
            success: (data) => {
                _this.cart = new Cart(data["data"], () => {
                    console.log("Cart loaded");
                    onRefresh();
                });
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    refreshOrders(onRefresh = () => {}) {
        let _this = this;
        $.ajax({
            url: this.baseUrl + "orders/",
            type: "GET",
            success: (data) => {
                _this.orders = data["data"].map((order) => new Order(order));
                console.log("Orders loaded");
                onRefresh();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    refreshNotifications(onRefresh = () => {}) {
        let _this = this;
        $.ajax({
            url: this.baseUrl + "notifications/",
            type: "GET",
            success: (data) => {
                _this.notifications = data["data"].map((notification) => new NotificationObject(notification));
                console.log("Notifications loaded");
                onRefresh();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    // Getters
    getId() {
        return this.id;
    }

    getEmail() {
        return this.email;
    }

    getType() {
        return this.type;
    }


    // Functionalities

    getCart() {
        return this.cart;
    }

    getOrders() {
        return this.orders;
    }

    getNotifications() {
        return this.notifications;
    }

}