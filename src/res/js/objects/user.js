class User {

    constructor(id, email, type) {
        this.id = id;
        this.email = email;
        this.type = type;
    }


    // Getters
    getId() {
        return this.id;
    }

    getEmail() {
        return this.email;
    }

    getType() {
        return this.type;
    }

    getAlias() {
        return this.email.split("@")[0];
    }

}

export class Seller extends User {
    constructor(id, email, rag_soc, piva) {
        super(id, email, Seller);
        this.rag_soc = rag_soc;
        this.piva = piva;
    }

    getRagSoc() {
        return this.rag_soc;
    }

    getPiva() {
        return this.piva;
    }

    getAlias() {
        return this.rag_soc;
    }
}

export class Buyer extends User {

    constructor(id, email, name, surname) {
        super(id, email, Buyer);
        this.name = name;
        this.surname = surname;
    }

    getAlias() {
        return `${this.name} ${this.surname}`;
    }

    getName() {
        return this.name;
    }

    getSurname() {
        return this.surname;
    }

}