class User {

    constructor(id, email, type, onReady) {
        this.id = id;
        this.email = email;
        this.type = type;
        onReady();
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