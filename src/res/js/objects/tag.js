class Tag {

    constructor(id, name, description, price, sale_price, example, example_desc) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.price = parseFloat(price);
        this.sale_price = sale_price != null ? parseFloat(sale_price) : null;
        this.example = example;
        this.example_desc = example_desc;
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

    getExample() {
        return this.example;
    }

    getExampleDesc() {
        return this.example_desc;
    }

    isInSale() {
        return this.sale_price != null;
    }

    getPrice() {
        if (this.sale_price == null) {
            return this.price;
        } else {
            return this.sale_price;
        }
    }

    getPriceWithoutSale() {
        return this.price;
    }




}