import { Tag } from "./tag.js";
class OrderItem {

    constructor(item, onReady) {
        this.id = item.id;
        this.quantity = item.quantity;
        const _this = this;
        $.ajax({
            url: `/tagazon/src/api/objects/tags/?id=${this.id}`,
            type: "GET",
            success: (response) => {
                let { data } = response;
                [data, ] = data;
                _this.tag = new Tag(data.id, data.name, data.description, data.price, data.sale_price, data.example, data.example_desc, () => {
                    onReady();
                });
            }
        });
    }

    getId() {
        return this.id;
    }

    getTag() {
        return this.tag;
    }

    getQuantity() {
        return this.quantity;
    }

    getTotalPrice() {
        return this.tag.getPrice() * this.quantity;
    }

}
export class Order {

    constructor(order, onReady) {
        this.id = order.id;
        this.timestamp = order.timestamp;
        this.status = order.status;
        this.items = [];
        const _this = this;
        $.ajax({
            url: `/tagazon/src/api/objects/order_tags/?order=${this.id}`,
            type: "GET",
            success: (response) => {
                const items = response.data;
                _this._buildItems(items, 0, onReady);
            }
        });
    }

    _buildItems(items, index = 0, onReady) {
        if (index < items.length) {
            const item = items[index];
            const _this = this;
            const it = new OrderItem(item, () => {
                _this.items.push(it);
                _this._buildItems(items, index + 1, onReady);
            });
        } else {
            onReady();
        }
    }

    getId() {
        return this.id;
    }

    getTimestamp() {
        return this.timestamp;
    }

    getStatus() {
        return this.status;
    }

    getTotalPrice() {
        let total = 0;
        this.items.forEach(element => {
            total += element.getTotalPrice();
        });
        return total;
    }


}