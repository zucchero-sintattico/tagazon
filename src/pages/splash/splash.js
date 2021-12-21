$(() => {
    UserManager.start(
        ifLogged = () => {
            window.location.href = './?page=home';
        },
        ifNotLogged = () => {}
    );
})