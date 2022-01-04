import { Tag } from './tag.js';
export class CartItem {

    constructor(id, tagId, quantity, onCartItemChange, onReady) {
        this.id = id;
        this.quantity = parseInt(quantity, 10);
        this.onCartItemChange = onCartItemChange;
        const _this = this;
        $.ajax({
            url: `/tagazon/src/api/objects/tags/?id=${tagId}`,
            type: "GET",
            success: (response) => {
                let { code, message, data } = response;
                [data, ] = data;
                _this.tag = new Tag(data.id, data.name, data.description, data.price, data.sale_price, data.example, data.example_desc, onReady);
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

    setQuantity(quantity) {
        this.quantity = quantity;
        const _this = this;
        $.ajax({
            url: "/tagazon/src/api/objects/shoppingcart_tags/",
            type: "PUT",
            data: {
                "id": this.id,
                "quantity": this.quantity
            },
            success: () => {
                _this.onCartItemChange();
            }
        });
    }

    increaseQuantity() {
        this.setQuantity(this.getQuantity() + 1);
    }

    getTotalPrice() {
        return this.tag.getPrice() * this.quantity;
    }

}