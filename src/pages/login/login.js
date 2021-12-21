$(() => {
    $("form").submit(function(e) {
        e.preventDefault();
        UserManager.login(
            $("#email").val(),
            $("#password").val(),
            onSuccess = () => {
                window.location.href = "./?page=home";
            },
            onError = (err) => {}
        );
    });
})