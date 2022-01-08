/**
 * Manager for interact with user-access Api
 */
export class AuthManager {

    baseUrl = '/tagazon/src/api/users/';

    start(onReady) {
        this.updateInfo(onReady);
    }

    updateInfo(onSuccess = () => {}, onError = () => {}) {
        $.ajax({
            url: `${this.baseUrl}info/`,
            type: 'GET',
            success: (data) => {
                onSuccess(data.data);
            },
            error: onError
        });
    }

    /**
     * Login user
     * @param {string} email the user's email
     * @param {string} password the user's password
     * @param {function} onSuccess the function to call when the request is successful 
     * @param {function} onError the function to call when the request is not successful
     */
    login(email, password, onSuccess = () => window.location.reload(), onError = (err) => console.error(err)) {
        $.ajax({
            url: `${this.baseUrl}login/`,
            type: "POST",
            data: {
                email: email,
                password: password
            },
            success: onSuccess,
            error: onError
        });
    }

    /**
     * Logout the current user if any
     * @param {function} onSuccess the function to call when the request is successful 
     * @param {function} onError the function to call when the request is not successful
     */
    logout(onSuccess = () => window.location.reload(), onError = (err) => console.error(err)) {
        $.ajax({
            url: `${this.baseUrl}logout/`,
            type: "POST",
            success: onSuccess,
            error: onError
        });
    }

    /**
     * Register a buyer
     * @param {string} email the user's email
     * @param {string} password the user's password
     * @param {string} name the user's name
     * @param {string} surname the user's surname
     * @param {function} onSuccess the function to call when the request is successful 
     * @param {function} onError the function to call when the request is not successful
     */
    registerBuyer(email, password, name, surname, onSuccess = () => window.location.reload(), onError = (err) => console.error(err)) {
        let _this = this;
        $.ajax({
            url: `${this.baseUrl}register/`,
            type: "POST",
            data: {
                email: email,
                password: password,
                name: name,
                surname: surname
            },
            success: () => {
                _this.login(email, password, onSuccess);
            },
            error: onError
        });
    }

    /**
     * Register a seller
     * @param {string} email the user's email
     * @param {string} password the user's password
     * @param {string} rag_soc the user's rag_soc
     * @param {string} piva the user's piva
     * @param {function} onSuccess the function to call when the request is successful 
     * @param {function} onError the function to call when the request is not successful
     */
    registerSeller(email, password, rag_soc, piva, onSuccess = () => window.location.reload(), onError = (err) => console.error(err)) {
        let _this = this;
        $.ajax({
            url: `${this.baseUrl}register/`,
            type: "POST",
            data: {
                email: email,
                password: password,
                rag_soc: rag_soc,
                piva: piva
            },
            success: () => {
                _this.login(email, password, onSuccess);
            },
            error: onError
        });
    }

    /**
     * Reset the password of a user
     * @param {string} email the user's email
     * @param {function} onSuccess the function to call when the request is successful
     * @param {function} onError the function to call when the request is not successful
     */
    resetPassword(email, onSuccess, onError = (err) => console.error(err)) {
        $.ajax({
            url: `${this.baseUrl}reset-password/`,
            type: "POST",
            data: {
                email: email
            },
            success: onSuccess,
            error: onError
        });
    }

    changePassword(oldPassword, newPassword, onSuccess, onError = (err) => console.error(err)) {

        $.ajax({
            url: `${this.baseUrl}change-password/`,
            type: "POST",
            data: {
                oldPassword: oldPassword,
                newPassword: newPassword
            },
            success: onSuccess,
            error: onError
        });
    }
}