export { NotificationObject }
class NotificationObject {

    constructor(id, order, timestamp, title, message, seen, onNotificationChange) {
        this.id = id;
        this.order = order;
        this.timestamp = timestamp;
        this.title = title;
        this.message = message;
        this.seen = seen == "1";
        this.onNotificationChange = onNotificationChange;
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
        const _this = this;
        $.ajax({
            url: `${Application.baseUrl}notifications/?id=${this.id}`,
            type: "PUT",
            data: {
                "id": this.id,
                "seen": true
            },
            success: (data) => {
                _this.onNotificationChange();
                onSuccess();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    setReceived(onSuccess = () => {}) {
        const _this = this;
        $.ajax({
            url: `${Application.baseUrl}notifications/?id=${this.id}`,
            type: "PUT",
            data: {
                "id": this.id,
                "received": true
            },
            success: (data) => {
                _this.onNotificationChange();
                onSuccess();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }


}