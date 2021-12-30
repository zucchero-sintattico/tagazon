class NotificationsService {

    protocol = "wss";
    server = "broker.emqx.io";
    port = 8084;
    topic = "tagazon-notifications";

    /**
     * Start listening for user notifications (if the user is logged in)
     */
    start() {
        const options = {
            clean: true,
            connectTimeout: 30000,
            qos: 1
        }
        this.client = mqtt.connect(`${this.protocol}://${this.server}:${this.port}/mqtt`, options)
        let service = this;
        this.client.on('message', (topic, message) => {
            this.onNotification(topic, message, service);
        });
        let _this = this;
        this.client.on('connect', function() {
            console.log('Notifications Service Connected')
            _this.client.subscribe(_this.topic + '/' + Application.user.getId(), function(err) {
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
    stop() {
        if (this.client) {
            console.log("Stopping listening for user notifications");
            this.client.unsubscribe(this.topic + '/' + Application.user.getId());
            this.client.end();
        }
    }

    setNotificationSeen(id) {
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

    createNotification(notification) {
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

    onNotification(topic, message, service) {
        let url = "/tagazon/src/api/objects/notifications/?received=false";
        let _this = this;
        $.ajax({
            url: url,
            type: "GET",
            success: (data) => {
                let notifications = data["data"];
                notifications.forEach((notification) => {
                    let not = new NotificationObject(notification["id"], notification["order"], notification["timestamp"], notification["title"], notification["message"], notification["seen"]);
                    Application.addNotification(not);
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