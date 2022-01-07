import { NotificationObject } from "./objects/notification.js";
export class NotificationsService {

    protocol = "wss";
    server = "broker.emqx.io";
    port = 8084;
    topic = "tagazon-notifications";

    start(userId, onNewNotification) {
        this.userId = userId;
        this.onNewNotification = onNewNotification;
        const options = {
            clean: true,
            connectTimeout: 30000,
            qos: 1
        }
        this.client = mqtt.connect(`${this.protocol}://${this.server}:${this.port}/mqtt`, options)
        let service = this;
        this.client.on('message', (topic, message) => {
            this.onNotification(service);
        });
        let _this = this;
        this.client.on('connect', function() {
            _this.client.subscribe(`${_this.topic}/${userId}`, function(err) {
                if (err) {
                    console.error(err);
                } else {
                    console.log('Subscribed to notifications');
                }
            })
        });
    }

    stop() {
        if (this.client) {
            this.client.unsubscribe(`${this.topic}/${this.userId}`);
            this.client.end();
            console.log("Unsubscribed from notifications");
        }
    }

    createNotification(notification) {

        Notification.requestPermission(function(result) {
            if (result === 'granted') {
                navigator.serviceWorker.register("/tagazon/src/res/js/service.js").then(function(registration) {
                        registration.showNotification(notification.title, {
                            body: notification.message,
                            icon: "/tagazon/src/res/img/logo.png",
                            data: notification.timestamp,
                            origin: "Tagazon",
                        });
                    },
                    function(err) {
                        console.error(err);
                    });
            }
        });

    }

    onNotification(service) {
        const _this = this;
        const url = "/tagazon/src/api/objects/notifications/?received=false";
        $.ajax({
            url: url,
            type: "GET",
            success: (data) => {
                let notifications = data.data;
                notifications.forEach((notification) => {
                    let not = new NotificationObject(notification.id, notification.order, notification.timestamp, notification.title, notification.message, notification.seen, () => {});
                    _this.onNewNotification(not);
                    not.setReceived();
                    service.createNotification(notification);
                });
            },
            error: (err) => {
                console.error(err);
            }
        });
    }

}