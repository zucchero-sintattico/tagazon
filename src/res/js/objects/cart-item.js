class CartItem {

    constructor(id, tagId, quantity, onReady = () => {}) {
        this.id = id;
        this.quantity = parseInt(quantity);
        const _this = this;
        $.ajax({
            url: `/tagazon/src/api/objects/tags/?id=${tagId}`,
            type: "GET",
            success: (data) => {
                data = data["data"][0];
                _this.tag = new Tag(data["id"], data["name"], data["description"], data["price"], data["sale_price"], data["example"], data["example_desc"], onReady);
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

    setQuantity(quantity, onSuccess = () => {}) {
        this.quantity = quantity;
        $.ajax({
            url: "/tagazon/src/api/objects/shoppingcart_tags/",
            type: "PUT",
            data: {
                "id": this.id,
                "quantity": this.quantity
            },
            success: (data) => {
                onSuccess();
            }
        });
    }

    increaseQuantity(onSuccess = () => {}) {
        this.setQuantity(this.getQuantity() + 1, onSuccess);
    }

    getTotalPrice() {
        return this.tag.getPrice() * this.quantity;
    }

}