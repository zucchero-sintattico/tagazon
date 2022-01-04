import { CartItem } from './cart-item.js';

export class Cart {

    constructor(items, onReady, onCartChange) {
        this.items = [];
        this.onCartChange = onCartChange;
        this._buildItems(items, 0, onReady);

    }

    _buildItems(items, index = 0, onReady) {
        if (index < items.length) {
            const item = items[index];
            const _this = this;
            const it = new CartItem(item.id, item.tag, item.quantity, () => {
                this.onCartChange();
            }, () => {
                _this.items.push(it);
                _this._buildItems(items, index + 1, onReady);
            });
        } else {
            onReady();
        }
    }


    getItem(tagId) {
        let item = null;
        this.items.forEach(element => {
            if (element.getTag().getId() == tagId) {
                item = element;
            }
        });
        return item;
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

    _addNewItem(tagId) {
        const _this = this;
        $.ajax({
            url: "/tagazon/src/api/objects/shoppingcart_tags/",
            type: "POST",
            data: {
                "tag": tagId
            },
            success: (response) => {
                const { code, message, data } = response;
                _this.items.push(new CartItem(data.id, data.tag, data.quantity, () => {
                    _this.onCartChange();
                }, () => {
                    _this.onCartChange();
                }));
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    addItem(tagId) {
        const item = this.getItem(tagId);
        if (item === null) {
            this._addNewItem(tagId);
        } else {
            item.increaseQuantity();
        }
    }

    decreaseItemQuantity(tagId) {
        const item = this.getItem(tagId);
        if (item !== null) {
            if (item.getQuantity() > 1) {
                item.setQuantity(item.getQuantity() - 1);
            } else {
                this.removeItem(tagId);
            }
        }
    }

    removeItem(tagId) {
        const item = this.getItem(tagId);
        const _this = this;
        if (item !== null) {
            $.ajax({
                url: `/tagazon/src/api/objects/shoppingcart_tags/?id=${item.getId()}`,
                type: "DELETE",
                success: () => {
                    _this.items.splice(_this.items.indexOf(item), 1);
                    _this.onCartChange();
                },
                error: (data) => {
                    console.error(data);
                }
            });
        }
    }

}