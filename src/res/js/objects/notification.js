class NotificationObject {

    constructor(id, order, timestamp, title, message, seen) {
        this.id = id;
        this.order = order;
        this.timestamp = timestamp;
        this.title = title;
        this.message = message;
        this.seen = seen == "1";
    }

    getOrder() {
        return this.order;
    }

    getTimestamp() {
        return this.timestamp;
    }

    getTitle() {
        return this.title;
    }

    getMessage() {
        return this.message;
    }

    getSeen() {
        return this.seen;
    }

    setSeen(onSuccess = () => {}) {
        this.seen = true;
        $.ajax({
            url: Application.baseUrl + "notifications/?id=" + this.id,
            type: "PATCH",
            data: {
                "id": this.id,
                "seen": true
            },
            success: (data) => {
                onSuccess();
                Application.notifyNotificationChange();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    setReceived(onSuccess = () => {}) {
        $.ajax({
            url: Application.baseUrl + "notifications/?id=" + this.id,
            type: "PATCH",
            data: {
                "id": this.id,
                "received": true
            },
            success: (data) => {
                onSuccess();
                Application.notifyNotificationChange();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }


}