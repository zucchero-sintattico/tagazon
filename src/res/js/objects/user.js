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
}

export class Buyer extends User {

    constructor(id, email, name, surname) {
        super(id, email, Buyer);
        this.name = name;
        this.surname = surname;
    }

    getName() {
        return this.name;
    }

    getSurname() {
        return this.surname;
    }

}