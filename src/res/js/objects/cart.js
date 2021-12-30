class Cart {

    constructor(items, onReady) {
        this.items = [];
        this.buildItems(items, 0, () => {
            console.log("Cart Items loaded");
            onReady();
        });
    }

    buildItems(items, index = 0, onReady = () => {}) {
        if (index < items.length) {
            let item = items[index];
            let _this = this;
            new CartItem(item["id"], item["tag"], item["quantity"], () => {
                _this.buildItems(items, index + 1, () => { this.buildItems(items, index + 1, onReady); });
            });
        } else {
            onReady();
        }
    }

    getItems() {
        return this.items;
    }

    getItemsCount() {
        return this.items.length;
    }

    getTotalPrice() {
        let total = 0;
        this.items.forEach(element => {
            total += element.getTotalPrice();
        });
        return total;
    }

    getTotalQuantity() {
        let total = 0;
        this.items.forEach(element => {
            total += element.getQuantity();
        });
        return total;
    }

    // Functionalities

    addItem(tagId, onSuccess) {
        let _this = this;
        $.ajax({
            url: "/tagazon/src/api/objects/shoppingcart_tags/",
            type: "POST",
            data: {
                "tag": tagId,
                "quantity": quantity
            },
            success: (data) => {
                _this.items.push(new CartItem(data["id"], data["tag"], data["quantity"]));
                onSuccess();
            }
        });
    }

}