class UserManager {

    static login(email, password, onSuccess = () => {}, onError = () => {}) {
        $.ajax({
            url: "/tagazon/src/api/users/login/",
            type: "POST",
            data: {
                email: email,
                password: password
            },
            success: onSuccess,
            error: onError
        });
    }

    static logout(onSuccess = () => {}, onError = () => {}) {
        $.ajax({
            url: "/tagazon/src/api/users/logout/",
            type: "POST",
            success: onSuccess,
            error: onError
        });
    }

    static registerBuyer(email, password, name, surname, onSuccess = () => {}, onError = () => {}) {
        $.ajax({
            url: "/tagazon/src/api/users/register/",
            type: "POST",
            data: {
                email: email,
                password: password,
                name: name,
                surname: surname
            },
            success: onSuccess,
            error: onError
        });
    }

    static registerSeller(email, password, rag_soc, piva, onSuccess = () => {}, onError = () => {}) {
        $.ajax({
            url: "/tagazon/src/api/users/register/",
            type: "POST",
            data: {
                email: email,
                password: password,
                rag_soc: rag_soc,
                piva: piva
            },
            success: onSuccess,
            error: onError
        });
    }

}