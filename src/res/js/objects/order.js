export { Order }
class Order {

    constructor(order) {
        this.id = order["id"];
        this.timestamp = order["timestamp"];
        this.status = order["status"];
        //this.items = order["items"].map((item) => new OrderItem(item));
    }

    getTotalPrice() {
        let total = 0;
        this.items.forEach(element => {
            total += element.getTotalPrice();
        });
        return total;
    }


}