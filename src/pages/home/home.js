$(() => {

    $("form").submit((e) => {
        e.preventDefault();
        UserManager.logout(() => {
            window.location.href = "./?page=splash";
        })
    })

    UserManager.start(
        ifLogged = () => {
            $("h2").text(`Benvenuto ${UserManager.user["email"]}`);
        },
        ifNotLogged = () => {
            window.location.href = "./?page=splash";
        }
    );
});