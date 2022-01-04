import { Category } from './category.js';
export class Tag {

    constructor(id, name, description, price, sale_price, example, example_desc, onReady = () => {}) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.price = parseFloat(price);
        this.sale_price = sale_price !== null ? parseFloat(sale_price) : null;
        this.example = example;
        this.example_desc = example_desc;
        const _this = this;
        $.ajax({
            url: `/tagazon/src/api/objects/tags/categories/?tag_id=${id}`,
            type: "GET",
            success: (data) => {
                data = data.data;
                _this.categories = data.map(element => new Category(element.id, element.name, element.description));
                onReady();
            }
        });
    }

    getId() {
        return this.id;
    }

    getName() {
        return this.name;
    }

    getDescription() {
        return this.description;
    }

    getCategories() {
        return this.categories;
    }

    getExample() {
        return this.example;
    }

    getExampleDesc() {
        return this.example_desc;
    }

    isInSale() {
        return this.sale_price !== null;
    }

    getPrice() {
        return this.isInSale() ? this.sale_price : this.price;
    }

    getPriceWithoutSale() {
        return this.price;
    }




}