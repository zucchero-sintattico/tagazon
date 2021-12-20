class NotificationsManager {

    static protocol = "ws";
    static server = "broker.emqx.io";
    static port = 8083
    static topic = "tagazon-notifications"
    static clientId;

    static start() {
        const options = {
            clean: true,
            connectTimeout: 30000
        }
        this.client = mqtt.connect(`${this.protocol}://${this.server}:${this.port}/mqtt`, options)
        this.client.on('connect', function() {
            console.log('Notifications Service Connected')
        });
    }

    static startListeningForUserNotifications(clientId, onMessage = (topic, message) => console.log(`${topic.toString()} : ${message.toString()}`)) {
        console.log("Starting listening for user notifications");
        this.clientId = clientId
        this.client.on('message', onMessage);
        this.client.subscribe(NotificationsManager.topic + '/' + this.clientId, function(err) {
            if (err) {
                console.error(err);
            }
        })
    }

    static stopListeningForUserNotifications() {
        console.log("Stopping listening for user notifications");
        this.client.unsubscribe(NotificationsManager.topic + '/' + this.clientId);
    }

    static stop() {
        this.client.end();
    }

}

$(() => {
    NotificationsManager.start()
})