export { Cart }
import { CartItem } from './cart-item.js';

class Cart {

    constructor(items, onReady, onCartChange) {
        this.items = [];
        this.onCartChange = onCartChange;
        this._buildItems(items, 0, onReady);

    }

    _buildItems(items, index = 0, onReady = () => {}) {
        if (index < items.length) {
            let item = items[index];
            let _this = this;
            let it = new CartItem(item.id, item.tag, item.quantity, () => {
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

    _addNewItem(tagId, onSuccess = () => {}) {
        const _this = this;
        $.ajax({
            url: "/tagazon/src/api/objects/shoppingcart_tags/",
            type: "POST",
            data: {
                "tag": tagId
            },
            success: (data) => {
                data = data["data"];
                _this.items.push(new CartItem(data.id, data.tag, data.quantity, () => {
                    _this.onCartChange();
                }));
                _this.onCartChange();
                onSuccess();
            },
            error: (data) => {
                console.error(data);
            }
        });
    }

    addItem(tagId, onSuccess = () => {}) {
        let item = this.getItem(tagId);
        if (item == null) {
            this._addNewItem(tagId, onSuccess);
        } else {
            item.increaseQuantity(onSuccess);
        }
    }

    decreaseItemQuantity(tagId, onSuccess = () => {}) {
        let item = this.getItem(tagId);
        if (item != null) {
            if (item.getQuantity() > 1) {
                item.setQuantity(item.getQuantity() - 1, onSuccess);
            } else {
                this.removeItem(tagId, onSuccess);
            }
        }
    }

    removeItem(tagId, onSuccess = () => {}) {
        let item = this.getItem(tagId);
        let _this = this;
        if (item != null) {
            $.ajax({
                url: `/tagazon/src/api/objects/shoppingcart_tags/?id=${item.getId()}`,
                type: "DELETE",
                success: (data) => {
                    _this.items.splice(_this.items.indexOf(item), 1);
                    _this.onCartChange();
                    onSuccess();
                },
                error: (data) => {
                    console.error(data);
                }
            });
        }
    }

}