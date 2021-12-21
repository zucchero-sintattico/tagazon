class NotificationsService {

    static protocol = "ws";
    static server = "broker.emqx.io";
    static port = 8083;
    static topic = "tagazon-notifications";

    /**
     * Start listening for user notifications (if the user is logged in)
     */
    static start() {
        const options = {
            clean: true,
            connectTimeout: 30000,
            qos: 1
        }
        if (UserManager.user == null) {
            console.error("Cannot start listening for user notifications: user not logged in");
            return;
        }
        this.client = mqtt.connect(`${this.protocol}://${this.server}:${this.port}/mqtt`, options)
        this.client.on('message', this.onNotification);
        this.client.on('connect', function() {
            console.log('Notifications Service Connected')
            NotificationsService.client.subscribe(NotificationsService.topic + '/' + UserManager.user["id"], function(err) {
                if (err) {
                    console.error(err);
                } else {
                    console.log("Starting listening for user notifications");
                }
            })
        });


    }

    /**
     * Stop listening for user notifications
     */
    static stop() {
        if (this.client) {
            console.log("Stopping listening for user notifications");
            this.client.unsubscribe(NotificationsService.topic + '/' + UserManager.user["id"]);
            this.client.end();
        }
    }

    static setNotificationSeen(id) {
        $.ajax({
            url: "/tagazon/src/api/objects/notifications/",
            method: "PATCH",
            data: {
                id: id,
                seen: true
            },
            success: (data) => {
                console.log(data);
            },
            error: (err) => {
                console.error(err);
            }
        });
    }

    static async createNotification(notification) {
        Notification.requestPermission().then(function(permission) {
            var not = new Notification(notification.title, {
                icon: "http://localhost/tagazon/src/res/img/logo.png",
                body: notification.message,
                origin: "Tagazon",
                data: notification.timestamp
            });
            not.onclick = () => {
                window.focus();
            };
        });
    }

    static onNotification(topic, message) {
        console.log(`${topic.toString()} : ${message.toString()}`);
        let url = "/tagazon/src/api/objects/notifications/";
        $.ajax({
            url: url,
            type: "GET",
            success: (data) => {
                let notifications = data["data"];
                notifications.forEach(notification => {
                    NotificationsService.createNotification(notification);
                    NotificationsService.setNotificationSeen(notification["id"]);
                });
            },
            error: (err) => {
                console.error(err);
            }
        });
    }

}