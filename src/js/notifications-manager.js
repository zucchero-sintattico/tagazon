class NotificationsManager {

    static protocol = "ws";
    static server = "broker.emqx.io";
    static port = 8083
    static topic = "tagazon-notifications"
    static clientId;


    static setNotificationSeen(id) {
        $.ajax({
            url: "/tagazon/src/api/notifications/",
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

    static onNotification(topic, message) {
        console.log(`${topic.toString()} : ${message.toString()}`);
        let url = "/tagazon/src/api/notifications/";
        $.ajax({
            url: url,
            type: "GET",
            success: (data) => {
                let notifications = data["data"];
                notifications.forEach(notification => {

                    Notification.requestPermission().then(function(permission) {
                        var not = new Notification("Il tuo ordine è stato consegnato", {
                            icon: "http://localhost/tagazon/src/res/logo.png",
                            body: "Il tuo ordine è stato consegnato in via Paolo Paolo alle ore 12:00",
                            origin: "Tagazon",
                            data: notification.timestamp,
                            tag: "TAG"
                        });

                    });
                    NotificationsManager.setNotificationSeen(notification["id"]);
                });
            },
            error: (err) => {
                console.error(err);
            }
        });
    }

    static start(clientId) {
        const options = {
            clean: true,
            connectTimeout: 30000,
            qos: 1
        }
        this.clientId = clientId
        this.client = mqtt.connect(`${this.protocol}://${this.server}:${this.port}/mqtt`, options)
        this.client.on('message', this.onNotification);
        this.client.on('connect', function() {
            console.log('Notifications Service Connected')
            NotificationsManager.client.subscribe(NotificationsManager.topic + '/' + NotificationsManager.clientId, function(err) {
                if (err) {
                    console.error(err);
                } else {
                    console.log("Starting listening for user notifications");
                }
            })
        });


    }

    static stop() {
        if (this.client) {
            console.log("Stopping listening for user notifications");
            this.client.unsubscribe(NotificationsManager.topic + '/' + this.clientId);
            this.client.end();
        }
    }

}